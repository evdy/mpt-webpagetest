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
    // get URL parameter - Product ID
    $instID = get_url_parameter("i", 1);
    if ($instID < 1 || $instID > 2) {
        echo "ERROR: Out of range instance id '$instID' provided [Public=1, Private=2]. Defaulting to 1(Public).<br>";
        $instID = 1;
    }
?>
<html>
<head>
    <meta http-equiv="refresh" content="300">
    <title>Page Load Stats</title>
    <style>
        table, th, td {
            border: 1px solid #bbb;
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
    <div style="margin-bottom: 5px; font-size: 20px; font-weight: bold; font-family: courier;">PRIVATE INSTANCE</div>
<?php $result = get_query_results_report_pi($link, $prodID, 2); ?>
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
        <div style="margin-bottom: 5px; font-size: 20px; font-weight: bold; font-family: courier; color: red;">PUBLIC INSTANCE *** No Longer in use. Last updated 05/25/2014 ***</div>
<?php $result = get_query_results_report_pi($link, $prodID, 1); ?>
<?php while($row = mysqli_fetch_array($result)) {?>
    <table style="width: 100%; font: 12px courier; font-weight: normal;">
        <tr> 
            <th style="height: 20px; font: 14px courier; text-align: left; background-color: #efefef;" colspan="19">URL: <?php echo substr($row['URL'], 0, 100) ?></th>
        </tr>
        <tr> 
            <th style="height: 20px; font: 14px courier;" rowspan="2">Views (median in seconds)</th>
            <th style="height: 20px; font: 14px courier; background-color: #ccc;" colspan="3">Today (5/25)</th>
            <th style="height: 20px; font: 14px courier;" colspan="3">This week (5/25)</th>
            <th style="height: 20px; font: 14px courier; background-color: #ccc;" colspan="3">Last week (5/18)</th>
            <th style="height: 20px; font: 14px courier;" colspan="3">Last 30 days (as of 5/25)</th>
            <th style="height: 20px; font: 14px courier; background-color: #ccc;" colspan="3">Last 90 days (as of 5/25)</th>
            <th style="height: 20px; font: 14px courier;" colspan="3">Last 6 months (as of 5/25)</th>            
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
</body>
</html>