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
    
    // get URL parameter - type
    $pageType = get_url_parameter("type", 1);
    if ($pageType < 1 || $pageType > 10) {
        echo "ERROR: Out of range page type id '$pageType' provided [Type=1-5]. Defaulting to 1.<br>";
        $pageType = 1;
    }
    
    // get URL parameter - start date
    $startDate = get_url_parameter("start", date("Y-m-d"));

    if (strlen($startDate) != 10) {
        echo "ERROR: Not a valid date format. Please use YYYY-MM-DD. Defaulting to today's date.<br>";
        $startDate = date("Y-m-d");
    }
    
    // get URL parameter - end date
    $endDate = get_url_parameter("end", NULL);
    
    if (strlen($endDate) != 0) {
        if (strlen($endDate) != 10) {
            echo "ERROR: Not a valid date format. Please use YYYY-MM-DD. Defaulting to today's date.<br>";
            $endDate = date("Y-m-d");
        }
    }
    else if (strlen($endDate) == 0) {
        $endDate = $startDate;
    }
?>
<html>
<head>
    <title>MPT Page Load - Results page</title>
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
<body style="font-size: 12px; text-align: left; font-family: 'Myriad Pro', 'Courier';">
<div style="width: 100%; height: 100%; text-align: left;">
<!---    <div style="margin-bottom: 10px;">
        <select id="product" style="">
            <option value="1">medpagetoday.com</option>
            <option value="2">everydayhealth.com</option>
            <option value="3">whattoexpect.com</option>
        </select>
    </div> -->
<?php $result = get_query_results_by_day($link, $startDate, $endDate, $prodID, $pageType); ?>
    <table style="font-size: 14px; font-weight: normal;">
        <tr>
            <th style="width: 115px;">Test id</th>
            <th style="width: 115px;">URL</th>
            <th style="width: 90px;">Date</th>
            <th style="width: 80px;">Time</th>
            <th style="width: 90px;">First view Load Time</th>
            <th style="width: 100px;">First view Render Time</th>
            <th style="width: 100px;">First view TTFB</th>
            <th style="width: 100px;">Repeat view Load Time</th>
            <th style="width: 100px;">Repeat view Render Time</th>
            <th style="width: 100px;">Repeat view TTFB</th>
            <th style="width: 100px;">Server Name</th>
            <th style="width: 100px;">Varnish HIT/MISS?</th>
        </tr>
<?php while($row = mysqli_fetch_array($result)) {?>
        <tr>
            <td><a style="text-decoration: none;" target="_blank" href="http://ec2-54-205-157-244.compute-1.amazonaws.com/results.php?test=<?php echo $row['test_id'] ?>"><?php echo $row['test_id'] ?></a></td>
            <td><?php echo $row['url'] ?></td>
            <td><?php echo $row['completed_date'] ?></td>
            <td><?php echo $row['completed_time'] ?></td>
            <td><?php echo $row['first_load_time'] ?></td>
            <td><?php echo $row['first_start_render'] ?></td>            
            <td><?php echo $row['first_first_byte'] ?></td>
            <td><?php echo $row['repeat_load_time'] ?></td>
            <td><?php echo $row['repeat_start_render'] ?></td>            
            <td><?php echo $row['repeat_first_byte'] ?></td>
            <td><?php echo $row['server_name'] ?></td>
            <td><?php echo $row['varnish_status'] ?></td>
        </tr>
<?php  } ?>
    </table>
<?php  mysqli_close($link); ?>
</div>
</body>
</html>