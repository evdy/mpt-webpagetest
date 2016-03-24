#!/bin/sh
 
# intialize variables
# mysql command line command
MYSQL_COMMAND="/usr/bin/mysql --host=10.133.120.40 --port=3307 --user=seo --password=seo --database=webpagetest --silent --execute"
 
# sql string to get the concatenated webpagetest URL string that includes the test URL, webpagetest token id and location
SQL_STRING_URLS="SELECT wpt_url FROM webpagetest.v_wpt_url_list;"
 
# Debug flag
# 0:none
# 1:basic
# 2:verbose
DEBUG=1
 
# print start date and time for logging
if [ $DEBUG -gt 0 ]; then echo " "; fi
if [ $DEBUG -gt 0 ]; then echo "starting at..." $(date); fi
 
# retrieve url's to get pageload info for
urls=$($MYSQL_COMMAND="$SQL_STRING_URLS")
 
# initialize arrays
aUrls=()
aXmlFiles=()
aTestIDs=()
 
# intiating the tests
if [ $DEBUG -gt 0 ]; then echo "initiating the tests... "; fi
if [ $DEBUG -gt 0 ]; then echo " "; fi
 
# loop through the urls
for url in $urls
do
        # intialize variables
        testStatus=0
 
        # get the intial xml from webpagetest and extract the xmlFile URL and the testID
        outFile=$(curl -s "$url" | tr -d '\n')
        if [ $DEBUG -gt 1 ]; then echo $outFile; fi
        testStatus=$(echo $outFile | awk -F'</*statusCode>' '{print $2}')
 
        # if testStatus is 200 get the xmlfile path and testids
        # if not print the error message and move to the next url
        if [ "$testStatus" == "200" ]; then
                # get the xmlfile and testids for this test
                xmlFile=$(echo $outFile | awk -F'</*xmlUrl>' '{print $2}')
                testID=$(echo $outFile | awk -F'</*testId>' '{print $2}')
 
                # print xml url for logging
                if [ $DEBUG -gt 0 ]; then echo "TestID: $testID | URL: $url | XML File: $xmlFile"; fi
 
                # store the xmlfile path, test ids and urls in arrays to process later
                # need separate arrays as shell doesn't do mutli-dim arrays very well
                aXmlFiles=("${aXmlFiles[@]}" "$xmlFile")
                aTestIDs=("${aTestIDs[@]}" "$testID")
                aUrls=("${aUrls[@]}" "$url")
        elif [ "$testStatus" == "400" ]; then
                # get the test status and print the error message
                testStatusText=$(echo $outFile | awk -F'</*statusText>' '{print $2;}')
                echo "Error initiating test for URL: $url. Error message: $testStatusText"
        fi
done
 
# get array size
arrsize=${#aTestIDs[@]}
 
# loop through the urls
for (( i=0; i<=$(( $arrsize-1 )); i++ ))
do
        # intialize variables
        httpcode=0
        successfulRun=0
        xmlFile=${aXmlFiles[$i]}
        testID=${aTestIDs[$i]}
        url=${aUrls[$i]}
        wpturl=$(echo $url | awk '{print substr($0, 1, index($0, "runtest")-1)"results/"}')
 
        # print logging statements
        if [ $i -eq 0 ]; then
                if [ $DEBUG -gt 0 ]; then echo " "; fi
                if [ $DEBUG -gt 0 ]; then echo "retrieving test data for all the tests that were initiated..."; fi
                if [ $DEBUG -gt 0 ]; then echo " "; fi
        fi
 
        # print xml url for logging
        if [ $DEBUG -gt 1 ]; then echo "TestID: $testID | URL: $url | XML File: $xmlFile"; fi
 
        # webpagetest takes time to run the test so we need to check
        # if the file has been created and is ready for download
        printf "waiting for file to be created "
        httpcode=$(curl -s "$xmlFile" | tr -d '\n' | awk -F'</*statusCode>' '{print $2}')
 
        # loop through until the file has been created and is ready for download
        while [ "$httpcode" != "200" ]
        do
                if [ $DEBUG -gt 1 ]; then printf " $httpcode "; fi
                printf "."
                sleep 30
                httpcode=$(curl -s "$xmlFile" | tr -d '\n' | awk -F'</*statusCode>' '{print $2}')
        done
        printf "\n"
 
        # check to see if the run was successful and did not fail
        successfulRun=$(curl -s "$xmlFile" | tr -d '\n' | awk -F'</*successfulFVRuns>' '{if (length($2) == 0) print 0; else print $2}')
 
        if [ $successfulRun -gt 0 ]; then
                # download the csv file and escape any qoutes in the text
                xmloutput=$(curl -s "$xmlFile" | tr -d '\n' | sed "s/'/''/g")
 
                # extract the location name in the testinfo.ini file
                testinfofile=$wpturl$(echo $testID | awk -F_ '{print substr ($1, 0, 2)"/"substr ($1, 3, 2)"/"substr ($1, 5, 2)"/"$2"/"$3"/testinfo.ini"}')
                WPTloc=$(curl -s "$testinfofile" | tr -d  '\r\n' | sed -n 's/.*loc=\([^ ]*\)id=.*/\1/p')
                if [ $DEBUG -gt 0 ]; then echo "TEST INFO FILE: $testinfofile | WPT location: $WPTloc"; fi
 
                # pass the xml output to a stored procedure that extracts the values and inserts it into the t_page_load_info table
                if [ $DEBUG -gt 2 ]; then echo $xmloutput; fi
                returnstring=$($MYSQL_COMMAND="call webpagetest.p_wpt_parseXML('$xmloutput', '$WPTloc')")
 
                # extract the serverName in the response header
                reportFile=$wpturl$(echo $testID | awk -F_ '{print substr ($1, 0, 2)"/"substr ($1, 3, 2)"/"substr ($1, 5, 2)"/"$2"/"$3"/1_report.txt.gz"}')
 
                # get the gzipped results file and unzip it
                returnstring=$(curl -s -o /tmp/1_report.txt.gz $reportFile)
                gunzip /tmp/1_report.txt.gz
 
                serverName=$(cat /tmp/1_report.txt | sed -n '/Request 1:/,/Request 2:/p' | tr '[:lower:]' '[:upper:]' | grep -i "USNJ.WEB" | awk -F'USNJ' '{print "USNJ" substr($2,0,10)}' | awk -F: '{print $1}')
                varnishstatus=$(cat /tmp/1_report.txt | sed -n '/Request 1:/,/Request 2:/p' | grep -i "X-Cache:" | awk -F: '{print $2}' | sed 's/ //g')
 
                # remove the results.txt file
                rm -f /tmp/1_report.txt
 
                # update the servername in the t_page_load_info table using testID as the reference
                if [ $DEBUG -gt 0 ]; then echo "test data captured for url: $url | Report File: $reportFile | Server Name: $serverName | Varnish status: $varnishstatus"; fi
                returnstring=$($MYSQL_COMMAND="call webpagetest.p_wpt_update_test_info('$testID','$serverName','$varnishstatus')")
        else
                echo "test: $testID failed to generate any successful runs for url: $url!"
        fi
done
 
# print end date and time for logging
if [ $DEBUG -gt 0 ]; then echo "ending at..." $(date); fi
if [ $DEBUG -gt 0 ]; then echo " "; fi