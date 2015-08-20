<?php        
    function get_query_results($aLink, $aChartType, $aPageType) {
        switch($aPageType) {
            case 1:
                $SQLString = "SELECT * FROM v_pageload_articles_" . $aChartType;
                break;
            case 2:
                $SQLString = "SELECT * FROM v_pageload_homepage_" . $aChartType;
                break;
        }
        
        // get the result set
        $result = mysqli_query($aLink, $SQLString);
        
        return $result;
    }
?>