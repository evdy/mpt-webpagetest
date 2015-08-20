<?php
    function get_type_text($type) {
	switch ($type) {
	    case   1: return 'number';
	    case   2: return 'number';
	    case   3: return 'number';
	    case   4: return 'number';
	    case   5: return 'number';
	    case 246: return 'number';
	    case   7: return 'datetime';
	    case  10: return 'date';
	    case  11: return 'datetime';
	    case  12: return 'datetime';
	    case  13: return 'date';
	    case  16: return 'boolean';
	    case 252: return 'string';
	    case 253: return 'string';
	    case 254: return 'string';
	    default: return 'string';
	}
    }
    
    function get_url_parameter($aParam, $aDefault) {
	if($_GET[$aParam] === "" || $_GET[$aParam] === null) {
	    $aParamValue = $aDefault;
	}
	else {
	    $aParamValue = $_GET[$aParam];
	}
	
	return $aParamValue;
    }
    
    function get_query_results($aLink, $aPID, $aChartType, $aPageType, $aStartDate, $aEndDate) {
	
	if ($aChartType != NULL) {
	    switch($aPageType) {
		case 1:
		    $SQLString = "SELECT `time`, `load time`, `render time`, `time to first byte`
				  FROM v_pageload_articles_" . $aChartType . "
				  WHERE product_id = " . $aPID;
		    break;
		case 2:
		    $SQLString = "SELECT `time`, `load time`, `render time`, `time to first byte`
				  FROM v_pageload_homepage_" . $aChartType . "
				  WHERE product_id = " . $aPID;
		    break;
	    }
	}
	else if ($aStartDate != NULL && $aEndDate != NULL) {
	    $SQLString = "SELECT `time`, `load time`, `render time`, `time to first byte`
			  FROM v_pageload_byhour
			  WHERE page_type_id=" . $aPageType . " 
			  AND completed_date BETWEEN '" . $aStartDate . "' AND '" . $aEndDate . "' 
			  ORDER BY completed_date, time";
	}
	else {
	    
	}
	
        // get the result set
        $result = mysqli_query($aLink, $SQLString);
        
        return $result;
    }
    
    function get_query_results_by_day($aLink, $aStartDate, $aEndDate, $aProductID, $aPageTypeID) {
        $SQLString = "SELECT * FROM v_pageload_all where `completed_date` >= '" . $aStartDate . "'" . " and `completed_date` <= '" . $aEndDate . "'" . " and product_id = " . $aProductID . " and page_type_id = " . $aPageTypeID;
	
        // get the result set
        $result = mysqli_query($aLink, $SQLString);
        
        return $result;
    }

    function get_query_results_prod_id($aLink, $aProdName) {
        $SQLString = "SELECT id FROM t_product where product_name = '" . $aProdName . "'";
	
        // get the result set
        $result = mysqli_query($aLink, $SQLString);
	
	// get the data
	$row = mysqli_fetch_array($result);
	
        return $row['id'];
    }
    
    function get_query_results_report($aLink, $aPID) {
	$SQLString = "SELECT * FROM v_wpt_median_by_timeperiod where product_id = " . $aPID;
        
	
        // get the result set
        $result = mysqli_query($aLink, $SQLString);
        
        return $result;
    }
?>