<?php
    // include files
    require_once("includes/dbconnect.php");
    require_once("includes/functions.php");
    
    // get URL parameter - Product ID
    $prodID = get_url_parameter("pid", 1);
    
    // get URL parameter - show
    $chartType = get_url_parameter("show", NULL);
    
    // get URL parameter - type
    $pageType = get_url_parameter("type", 1);
    
    // get URL parameter - start date
    $startDate = get_url_parameter("start", NULL);
    
    // get URL parameter - end date
    $endDate = get_url_parameter("end", NULL);
    
    // get the appropriate query result based on input parameters
    $result = get_query_results($link, $prodID, $chartType, $pageType, $startDate, $endDate);

    // initialize master array that holds
    // all the data for google charts
    $table = array();
    
    // columns and rows child array
    $cols = array();
    $rows = array();

    // fetch column names and type by default the first column will
    // be the x-axis all other columns will be depicted in the y-axis
    // The first column should always be of type integer/datetime
    while ($cnt = $result->fetch_field())
    {
	$cols[] = array('id' => "", 'label' => $cnt->name, 'pattern' => "", 'type' => get_type_text($cnt->type));
    }
    
    // add to columns to master array
    $table['cols'] = $cols;
    
    // get number of columns
    $colcount = sizeof($table['cols']);
    
    // get row data
    while ($nt = $result->fetch_assoc())
    {
	// create child array to hold each row data
	$rowdata = array();
	for ($i = 0; $i < $colcount; $i++) {
	    $rowdata[] = array('v' => $nt[$cols[$i]['label']], 'f' =>NULL);
	}
	$rows[] = array('c' => $rowdata);
    }
    
    // add row values to master array
    $table['rows'] = $rows;
    
    // create json object
    echo json_encode($table);
    
    // close mysql link
    mysqli_close($link);
?>