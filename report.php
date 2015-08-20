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
            border-collapse: collapse;
            text-align: center;
        }
        th {
            background-color: #fff;
            font-weight: normal;
        }
        td {
            background-color: #fff;
            height: 20px;
        }
        a {
            text-decoration: none;
            color: #330099;
        }
    </style>
</head>
<body style="background-color: #fff; font: 12px 'Myriad Pro'; text-align: left;" onload="initChart(getURLParameter('pid'));">
<div style="width: 100%; text-align: left; margin-top: 20px; margin-bottom: 20px;">
    <div style="margin-bottom: 5px; font: 14px 'Myriad Pro'; letter-spacing: 1px; "><?php echo "Page last refreshed at: " . date("Y-m-d H:i:s") ?></div>
<?php $result = get_query_results_report($link, $prodID); ?>
<?php while($row = mysqli_fetch_array($result)) {?>
    <table style="width: 100%; font: 14px 'Myriad Pro'; color: #444;">
        <tr style="border-top: 0px solid #999;"> 
            <th style="height: 20px; text-align: left; font: 15px 'Myriad Pro'; color: #000; padding-top: 3px; letter-spacing: 2px;" colspan="15">URL: <a href="<?php echo $row['url'] ?>"><?php echo substr($row['url'], 0, strpos($row['url'] . '?', '?')) ?></a></th>
            <th style="height: 20px; text-align: right; font: 15px 'Myriad Pro'; color: #000; padding-top: 3px; letter-spacing: 2px;" colspan="4">Browser: <?php echo $row['browser'] ?></a></th>
        </tr>
        <tr style="border-top: 1px solid #999; color: #000; "> 
            <th style="height: 20px;" rowspan="2"><span style="letter-spacing:3px;">VIEWS</span><br><span style="letter-spacing:2px;">(median in seconds)</span></th>
            <th style="height: 20px; background-color: #eee; letter-spacing: 3px;" colspan="3">TODAY</th>
            <th style="height: 20px; letter-spacing:3px;" colspan="3">THIS WEEK</th>
            <th style="height: 20px; background-color: #eee; letter-spacing:3px;" colspan="3">LAST WEEK</th>
            <th style="height: 20px; letter-spacing:3px;" colspan="3">LAST 30 DAYS</th>
            <th style="height: 20px; background-color: #eee; letter-spacing:3px;" colspan="3">LAST 90 DAYS</th>
            <th style="height: 20px; letter-spacing:3px;" colspan="3">LAST 6 MONTHS</th>            
        </tr>
        <tr style="border-top: 0px solid #ccc; color: #000;">
            <th style="width: 5%; background-color: #eee;">Load time</th>
            <th style="width: 5%; background-color: #eee;">Render time</th>
            <th style="width: 5%; background-color: #eee">First byte</th>
            <th style="width: 5%;">Load time</th>
            <th style="width: 5%;">Render time</th>
            <th style="width: 5%;">First byte</th>
            <th style="width: 5%; background-color: #eee">Load time</th>
            <th style="width: 5%; background-color: #eee">Render time</th>
            <th style="width: 5%; background-color: #eee">First byte</th>
            <th style="width: 5%;">Load time</th>
            <th style="width: 5%;">Render time</th>
            <th style="width: 5%;">First byte</th>
            <th style="width: 5%; background-color: #eee">Load time</th>
            <th style="width: 5%; background-color: #eee">Render time</th>
            <th style="width: 5%; background-color: #eee">First byte</th>
            <th style="width: 5%;">Load time</th>
            <th style="width: 5%;">Render time</th>
            <th style="width: 5%;">First byte</th>            
        </tr>
        <tr style="border-top: 1px dotted #bbb;">
            <td style="color: #000; letter-spacing: 2px;">FIRST VIEW</td>
            <td style="background-color: #eee"><?php echo $row['first_load_time_today'] ?></td>
            <td style="background-color: #eee"><?php echo $row['first_start_render_today'] ?></td>            
            <td style="background-color: #eee"><?php echo $row['first_first_byte_today'] ?></td>
            <td><?php echo $row['first_load_time_thisweek'] ?></td>
            <td><?php echo $row['first_start_render_thisweek'] ?></td>            
            <td><?php echo $row['first_first_byte_thisweek'] ?></td>
            <td style="background-color: #eee"><?php echo $row['first_load_time_lastweek'] ?></td>
            <td style="background-color: #eee"><?php echo $row['first_start_render_lastweek'] ?></td>            
            <td style="background-color: #eee"><?php echo $row['first_first_byte_lastweek'] ?></td>
            <td><?php echo $row['first_load_time_30day'] ?></td>
            <td><?php echo $row['first_start_render_30day'] ?></td>            
            <td><?php echo $row['first_first_byte_30day'] ?></td>
            <td style="background-color: #eee"><?php echo $row['first_load_time_90day'] ?></td>
            <td style="background-color: #eee"><?php echo $row['first_start_render_90day'] ?></td>            
            <td style="background-color: #eee"><?php echo $row['first_first_byte_90day'] ?></td>
            <td><?php echo $row['first_load_time_6month'] ?></td>
            <td><?php echo $row['first_start_render_6month'] ?></td>            
            <td><?php echo $row['first_first_byte_6month'] ?></td>            
        </tr>
        <tr style="border-top: 1px dotted #bbb; border-bottom: 1px solid #999;">
            <td style="color: #000; letter-spacing: 2px;">REPEAT VIEW</td>
            <td style="background-color: #eee"><?php echo $row['repeat_load_time_today'] ?></td>
            <td style="background-color: #eee"><?php echo $row['repeat_start_render_today'] ?></td>            
            <td style="background-color: #eee"><?php echo $row['repeat_first_byte_today'] ?></td>            
            <td><?php echo $row['repeat_load_time_thisweek'] ?></td>
            <td><?php echo $row['repeat_start_render_thisweek'] ?></td>            
            <td><?php echo $row['repeat_first_byte_thisweek'] ?></td>
            <td style="background-color: #eee"><?php echo $row['repeat_load_time_lastweek'] ?></td>
            <td style="background-color: #eee"><?php echo $row['repeat_start_render_lastweek'] ?></td>            
            <td style="background-color: #eee"><?php echo $row['repeat_first_byte_lastweek'] ?></td>
            <td><?php echo $row['repeat_load_time_30day'] ?></td>
            <td><?php echo $row['repeat_start_render_30day'] ?></td>            
            <td><?php echo $row['repeat_first_byte_30day'] ?></td>
            <td style="background-color: #eee"><?php echo $row['repeat_load_time_90day'] ?></td>
            <td style="background-color: #eee"><?php echo $row['repeat_start_render_90day'] ?></td>            
            <td style="background-color: #eee"><?php echo $row['repeat_first_byte_90day'] ?></td>
            <td><?php echo $row['repeat_load_time_6month'] ?></td>
            <td><?php echo $row['repeat_start_render_6month'] ?></td>            
            <td><?php echo $row['repeat_first_byte_6month'] ?></td>               
        </tr>
    </table>
    <br>
<?php  } ?>
<?php $result = get_query_results_report($link, $prodID); ?>
</div>
    <div style="position: relative; width: 100%; height: 25px; margin-bottom: 20px;">
<?php $row = mysqli_fetch_array($result) ?>
        <div style="position: relative; float: left; width: 49%; height: 100%; font: 18px 'Myriad Pro'; letter-spacing: 1px;">Page load stats for URL - <?php echo $row['url'] ?></div>
<?php $row = mysqli_fetch_array($result) ?>
        <div style="position: relative; float: right; width: 49%; height: 100%; font: 18px 'Myriad Pro'; letter-spacing: 1px;">Page load stats for URL - <?php echo $row['url'] ?></div>
    </div>
    <div style="position: relative; width: 100%; height: 500px; margin-bottom: 20px;">
        <div id="chart_today" style="position: relative; float: left; width: 49%; height: 500px; border: 1px solid #dddddd;"></div>
        <div id="chart_today_2" style="position: relative; float: right; width: 49%; height: 500px; border: 1px solid #dddddd;"></div>
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
<?php  mysqli_close($link); ?>
</html>