google.load("visualization", "1", { packages: ["corechart"] });    
google.setOnLoadCallback();

function getURLParameter(name) {
    return decodeURIComponent((new RegExp('[?|&]' + name + '=' + '([^&;]+?)(&|#|;|$)').exec(location.search)||[,""])[1].replace(/\+/g, '%20'))||null
} 

function initChart(pid) {
    var gProds=new Array("MPT","EH","WTE");
    var gArticleURLs=new Array("http://www.medpagetoday.com/Cardiology/HeartTransplantation/43707", "http://www.everydayhealth.com/infographics/christmas-cookie-monster/", "http://www.whattoexpect.com/preconception/preparing-for-baby/work-and-finance/what-babies-really-cost")
    var gHomepageURLs=new Array("http://www.medpagetoday.com/", "http://www.everydayhealth.com/",  "http://www.whattoexpect.com/")
    var gArticleTitle=gProds[pid - 1] + " Article Page: " + gArticleURLs[pid - 1];
    var gHomepageTitle=gProds[pid - 1] + " Home Page: " + gHomepageURLs[pid - 1];

    drawChart(pid, "today", "STATS FOR TODAY", 1, "chart_today");
    drawChart(pid, "7day", "STATS FOR THE LAST 7 DAYS", 1, "chart_7day");
    drawChart(pid, "30day", "STATS FOR THE LAST 30 DAYS", 1, "chart_30day");
    drawChart(pid, "90day", "STATS FOR THE LAST 90 DAYS", 1, "chart_90day");
    drawChart(pid, "6month", "STATS FOR THE LAST 6 MONTHS", 1, "chart_6month");
    drawChart(pid, "today", "STATS FOR TODAY", 2,  "chart_today_2");
    drawChart(pid, "7day", "STATS FOR THE LAST 7 DAYS", 2, "chart_7day_2");
    drawChart(pid, "30day", "STATS FOR THE LAST 30 DAYS", 2, "chart_30day_2");
    drawChart(pid, "90day", "STATS FOR THE LAST 90 DAYS", 2, "chart_90day_2");
    drawChart(pid, "6month", "STATS FOR THE LAST 6 MONTHS", 2, "chart_6month_2");
}
    
function drawChart(prod, day, gtitle, type, id) {
    
    var urlStr = "chartdata.php?pid=" + prod + "&show=" + day + "&type=" + type;
    var gcolors = new Array(3);
    gcolors[1] = ['#00688b','#3299cc','#00bfff'];
    gcolors[2] = ['#009900','#33cc33','#33ff00'];
    gcolors[3] = ['#cc3366','#ff6699','#ff3399'];
    
    var jsonData = $.ajax({
        url: urlStr,
        dataType: "json",
        async: false
    }).responseText;
        
    var data = new google.visualization.DataTable(jsonData);
        
    var options = {
        title: gtitle,
        titleTextStyle: {
            fontStyle: "bold",
            fontName: 'Myriad Pro',
            fontSize: 20
        },
        linewidth: 1,
        pointSize: 5,
        colors: gcolors[prod],
        chartArea: {left: 75, width: "90%", 'height': '75%'},
        legend: {position: 'bottom', textStyle: { fontName: 'Myriad Pro' }},
        hAxis: {textStyle: { fontName: 'Myriad Pro' }},
        vAxis: {title: 'Seconds', titleTextStyle: {color: '#FF0000', fontName: 'Myriad Pro'}, textStyle: { fontName: 'Myriad Pro' }, viewWindowMode:'explicit', viewWindow:{max:12, min:0}}
    };
        
    var chart = new google.visualization.LineChart(document.getElementById(id));
    chart.draw(data, options);
}