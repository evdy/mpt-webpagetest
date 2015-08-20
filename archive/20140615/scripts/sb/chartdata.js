google.load("visualization", "1", { packages: ["corechart"] });    
google.setOnLoadCallback();

function getURLParameter(name) {
    return decodeURIComponent((new RegExp('[?|&]' + name + '=' + '([^&;]+?)(&|#|;|$)').exec(location.search)||[,""])[1].replace(/\+/g, '%20'))||null
} 

function initChart(pid) {
    var gProds=new Array("MPT","EH","WTE");
    var gArticleURLs=new Array("http://www.medpagetoday.com/Cardiology/HeartTransplantation/43707", "http://www.everydayhealth.com/infographics/christmas-cookie-monster/", "http://www.whattoexpect.com/preconception/preparing-for-baby/work-and-finance/what-babies-really-cost")
    var gHomepageURLs=new Array("http://www.medpagetoday.com/", "http://www.everydayhealth.com/",  "http://www.whattoexpect.com/")
    var gArticleTitle=gProds[pid - 1] + " Article Page :" + gArticleURLs[pid - 1];
    var gHomepageTitle=gProds[pid - 1] + " Home Page :" + gHomepageURLs[pid - 1];
    
    drawChart(pid, "today", gArticleTitle + " | Today ",  "chart_today");
    drawChart(pid, "7day", gArticleTitle  + " | Last 7 Days", "chart_7day");
    drawChart(pid, "30day", gArticleTitle + " | Last 30 Days", 1, "chart_30day");
    drawChart(pid, "90day", gArticleTitle + " | Last 90 Days", 1, "chart_90day");
    drawChart(pid, "6month", gArticleTitle + " | Last 6 months", 1, "chart_6month");
    drawChart(pid, "today", gHomepageTitle + " | Today", 2,  "chart_today_2");
    drawChart(pid, "7day", gHomepageTitle + " | Last 7 Days", 2, "chart_7day_2");
    drawChart(pid, "30day", gHomepageTitle + " | Last 30 Days", 2, "chart_30day_2");
    drawChart(pid, "90day", gHomepageTitle + " | Last 90 Days", 2, "chart_90day_2");
    drawChart(pid, "6month", gHomepageTitle + " | Last 6 months", 2, "chart_6month_2");
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
            fontSize: 14
        },
        linewidth: 1,
        pointSize: 5,
        colors: gcolors[prod],
        chartArea: {left: 75, width: "90%"},
        legend: {position: 'bottom'},
        vAxis: {title: 'Seconds', titleTextStyle: {color: '#FF0000'}, viewWindowMode:'explicit', viewWindow:{max:12, min:0}}
    };
        
    var chart = new google.visualization.LineChart(document.getElementById(id));
    chart.draw(data, options);
}