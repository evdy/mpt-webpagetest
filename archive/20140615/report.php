<?php
    // include files
    require_once("includes/dbconnect.php");
    require_once("includes/functions.php");
    
    // default timezone to use
    date_default_timezone_set('America/New_York');
    
    // get URL parameter - Product ID
    $prodID = get_url_parameter("pid", 1);
    if ($prodID < 1 || $prodID > 3) {
        echo "ERROR: Out of range product id '$prodID' provided [MPT=1, EH=2, WTE=3]. Defaulting to 1(MPT).<br>";
        $prodID = 1;
    }
?>
<html>
<head>
    <meta http-equiv="refresh" content="300">
    <title>Page Load Stats</title>
    <!-- Load jQuery -->
    <script language="javascript" type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.0/jquery.min.js"></script>
    <!-- Load Google JSAPI -->
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <!-- Load Page Load js file -->
    <script type="text/javascript" src="scripts/chartdata.js?1"></script>
    <style>
        table, th, td {
            border: 1px solid #aaa;
            border-collapse: collapse;
            text-align: center;
        }
        th {
            background-color: #ddd;
        }
        td {
            background-color: #fff;
            height: 20px;
        }
    </style>
</head>
<body style="background-color: #fff; font: 12px helvetica; text-align: left;" onload="initChart(getURLParameter('pid'));">
<div style="width: 100%; text-align: left; margin-top: 20px;">
    <div style="margin-bottom: 5px; font: 14px courier;"><?php echo "Page last refreshed at: " . date("Y-m-d H:i:s") ?></div>
<?php $result = get_query_results_report($link, $prodID); ?>
<?php while($row = mysqli_fetch_array($result)) {?>
    <table style="width: 100%; font: 12px courier; font-weight: normal;">
        <tr> 
            <th style="height: 20px; font: 14px courier; text-align: left; background-color: #efefef;" colspan="19">URL: <?php echo substr($row['URL'], 0, 100) ?></th>
        </tr>
        <tr> 
            <th style="height: 20px; font: 14px courier;" rowspan="2">Views (median in seconds)</th>
            <th style="height: 20px; font: 14px courier; background-color: #ccc;" colspan="3">Today</th>
            <th style="height: 20px; font: 14px courier;" colspan="3">This week</th>
            <th style="height: 20px; font: 14px courier; background-color: #ccc;" colspan="3">Last week</th>
            <th style="height: 20px; font: 14px courier;" colspan="3">Last 30 days</th>
            <th style="height: 20px; font: 14px courier; background-color: #ccc;" colspan="3">Last 90 days</th>
            <th style="height: 20px; font: 14px courier;" colspan="3">Last 6 months</th>            
        </tr>
        <tr>
            <th style="width: 5%; font: 14px courier; background-color: #ccc">Load Time</th>
            <th style="width: 5%; font: 14px courier; background-color: #ccc">Render Time</th>
            <th style="width: 5%; font: 14px courier; background-color: #ccc">TTFB</th>
            <th style="width: 5%; font: 14px courier; ">Load Time</th>
            <th style="width: 5%; font: 14px courier; ">Render Time</th>
            <th style="width: 5%; font: 14px courier; ">TTFB</th>
            <th style="width: 5%; font: 14px courier; background-color: #ccc">Load Time</th>
            <th style="width: 5%; font: 14px courier; background-color: #ccc">Render Time</th>
            <th style="width: 5%; font: 14px courier; background-color: #ccc">TTFB</th>
            <th style="width: 5%; font: 14px courier;">Load Time</th>
            <th style="width: 5%; font: 14px courier; ">Render Time</th>
            <th style="width: 5%; font: 14px courier; ">TTFB</th>
            <th style="width: 5%; font: 14px courier; background-color: #ccc">Load Time</th>
            <th style="width: 5%; font: 14px courier; background-color: #ccc">Render Time</th>
            <th style="width: 5%; font: 14px courier; background-color: #ccc">TTFB</th>
            <th style="width: 5%; font: 14px courier;">Load Time</th>
            <th style="width: 5%; font: 14px courier; ">Render Time</th>
            <th style="width: 5%; font: 14px courier; ">TTFB</th>            
        </tr>
        <tr>
            <td>First View</td>
            <td style="background-color: #eee"><?php echo$row['1st_loadtime_today'] ?></td>
            <td style="background-color: #eee"><?php echo$row['1st_rendertime_today'] ?></td>            
            <td style="background-color: #eee"><?php echo$row['1st_firstbytetime_today'] ?></td>
            <td><?php echo $row['1st_loadtime_thisweek'] ?></td>
            <td><?php echo $row['1st_rendertime_thisweek'] ?></td>            
            <td><?php echo $row['1st_firstbytetime_thisweek'] ?></td>
            <td style="background-color: #eee"><?php echo$row['1st_loadtime_lastweek'] ?></td>
            <td style="background-color: #eee"><?php echo$row['1st_rendertime_lastweek'] ?></td>            
            <td style="background-color: #eee"><?php echo$row['1st_firstbytetime_lastweek'] ?></td>
            <td><?php echo $row['1st_loadtime_30day'] ?></td>
            <td><?php echo $row['1st_rendertime_30day'] ?></td>            
            <td><?php echo $row['1st_firstbytetime_30day'] ?></td>
            <td style="background-color: #eee"><?php echo$row['1st_loadtime_90day'] ?></td>
            <td style="background-color: #eee"><?php echo$row['1st_rendertime_90day'] ?></td>            
            <td style="background-color: #eee"><?php echo$row['1st_firstbytetime_90day'] ?></td>
            <td><?php echo $row['1st_loadtime_6month'] ?></td>
            <td><?php echo $row['1st_rendertime_6month'] ?></td>            
            <td><?php echo $row['1st_firstbytetime_6month'] ?></td>            
        </tr>
        <tr>
            <td>Repeat View</td>
            <td style="background-color: #eee"><?php echo$row['2nd_loadtime_today'] ?></td>
            <td style="background-color: #eee"><?php echo$row['2nd_rendertime_today'] ?></td>            
            <td style="background-color: #eee"><?php echo$row['2nd_firstbytetime_today'] ?></td>            
            <td><?php echo $row['2nd_loadtime_thisweek'] ?></td>
            <td><?php echo $row['2nd_rendertime_thisweek'] ?></td>            
            <td><?php echo $row['2nd_firstbytetime_thisweek'] ?></td>
            <td style="background-color: #eee"><?php echo$row['2nd_loadtime_lastweek'] ?></td>
            <td style="background-color: #eee"><?php echo$row['2nd_rendertime_lastweek'] ?></td>            
            <td style="background-color: #eee"><?php echo$row['2nd_firstbytetime_lastweek'] ?></td>
            <td><?php echo $row['2nd_loadtime_30day'] ?></td>
            <td><?php echo $row['2nd_rendertime_30day'] ?></td>            
            <td><?php echo $row['2nd_firstbytetime_30day'] ?></td>
            <td style="background-color: #eee"><?php echo$row['2nd_loadtime_90day'] ?></td>
            <td style="background-color: #eee"><?php echo$row['2nd_rendertime_90day'] ?></td>            
            <td style="background-color: #eee"><?php echo$row['2nd_firstbytetime_90day'] ?></td>
            <td><?php echo $row['2nd_loadtime_6month'] ?></td>
            <td><?php echo $row['2nd_rendertime_6month'] ?></td>            
            <td><?php echo $row['2nd_firstbytetime_6month'] ?></td>               
        </tr>
    </table>
    <br>
<?php  } ?>    
<?php  mysqli_close($link); ?>
</div>
    <div style="position: relative; width: 100%; height: 500px; margin-bottom: 20px;">
        <div id="chart_today" style="position: relative; float: left; width: 49%; height: 500px; border: 1px solid #dddddd;"></div>
        <div id="chart_today_2" style="position: relative; float: right; width: 49%; height: 500px; border: 1px solid #dddddd;"></div>
        <div style="position: absolute; top: 50px; left: 75px"></div>
    </div>
    <div style="width: 100%; height: 500px; margin-bottom: 20px;">
        <div id="chart_7day" style="position: relative; float: left; width: 49%; height: 500px; text-align: center; border: 1px solid #dddddd;"></div>
        <div id="chart_7day_2" style="position: relative; float: right; width: 49%; height: 500px; border: 1px solid #dddddd;"></div>
    </div>
    <div style="width: 100%; height: 500px; margin-bottom: 20px;">   
        <div id="chart_30day" style="position: relative; float: left; width: 49%; height: 500px; text-align: center; border: 1px solid #dddddd;"></div>
        <div id="chart_30day_2" style="position: relative; float: right; width: 49%; height: 500px; border: 1px solid #dddddd;"></div>
    </div>
    <div style="width: 100%; height: 500px; margin-bottom: 20px;">
        <div id="chart_90day" style="position: relative; float: left; width: 49%; height: 500px; text-align: center; border: 1px solid #dddddd;"></div>
        <div id="chart_90day_2" style="position: relative; float: right; width: 49%; height: 500px; border: 1px solid #dddddd;"></div>
    </div>
    <div style="width: 100%; height: 500px; margin-bottom: 20px;">
        <div id="chart_6month" style="position: relative; float: left; width: 49%; height: 500px; text-align: center; border: 1px solid #dddddd;"></div>
        <div id="chart_6month_2" style="position: relative; float: right; width: 49%; height: 500px; border: 1px solid #dddddd;"></div>
    </div>
</body>
</html>