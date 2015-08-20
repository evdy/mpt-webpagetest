google.load("visualization", "1", { packages: ["corechart"] });    
google.setOnLoadCallback();

function getURLParameter(name) {
    return decodeURIComponent((new RegExp('[?|&]' + name + '=' + '([^&;]+?)(&|#|;|$)').exec(location.search)||[,""])[1].replace(/\+/g, '%20'))||null
} 

function initChart(pid) {
    var gProds=new Array("MPT","EH","WTE");
    var gProdName=gProds[pid - 1];
    
    drawChart(pid, "today", gProdName + " Page Load | Article Page | Today ", 1,  "chart_today");
    drawChart(pid, "7day", gProdName + " Page Load | Article Page | Last 7 Days", 1, "chart_7day");
    drawChart(pid, "30day", gProdName + " Page Load | Article Page | Last 30 Days", 1, "chart_30day");
    drawChart(pid, "90day", gProdName + " Page Load | Article Page | Last 90 Days", 1, "chart_90day");
    drawChart(pid, "6month", gProdName + " Page Load | Article Page | Last 6 months", 1, "chart_6month");
    drawChart(pid, "today", gProdName + " Page Load | Home Page | Today", 2,  "chart_today_2");
    drawChart(pid, "7day", gProdName + " Page Load | Home Page | Last 7 Days", 2, "chart_7day_2");
    drawChart(pid, "30day", gProdName + " Page Load | Home Page | Last 30 Days", 2, "chart_30day_2");
    drawChart(pid, "90day", gProdName + " Page Load | Home Page | Last 90 Days", 2, "chart_90day_2");
    drawChart(pid, "6month", gProdName + " Page Load | Home Page | Last 6 months", 2, "chart_6month_2");
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
            fontSize: 20
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