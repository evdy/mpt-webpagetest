<?php
    $dbhost="10.133.120.40";
    $dblogin="seo";
    $dbpwd="seo";
    $dbname="webpagetest";
    $dbport="3307";
    
    // connect to database 
    $link = mysqli_connect($dbhost, $dblogin, $dbpwd, $dbname, $dbport);
    
    // error checing
    if (!$link) {
	printf("Connect failed: %s\n", mysqli_connect_error());
	exit();
    }
?>