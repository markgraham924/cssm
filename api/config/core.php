<?php
// show error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

// set your default time-zone
date_default_timezone_set('Europe/London');
 
// variables used for jwt
$key = 'V~V.2^2%TS+Qm?s--wR6$XeQ-=10}GsV.{:<$n`ZA+;xT"qM(24;Sb+C*nVsrUj';
$iss = "https://gmpauto.co.uk";
$aud = "https://gmpauto.co.uk";
$iat = time();
$nbf = time()-60;
 
// home page url
$home_url="http://gmpauto.co.uk/cssm/api/";
 
// page given in URL parameter, default page is one
$page = isset($_GET['page']) ? $_GET['page'] : 1;
 
// set number of records per page
$records_per_page = 5;
 
// calculate for the query LIMIT clause
$from_record_num = ($records_per_page * $page) - $records_per_page;
?>