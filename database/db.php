<?php

require_once __DIR__ . '/../config/config.php';

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

/* Open a connection */
$db_table = 'users';
$db_link  = getDatabase() or die(mysqli_error($db_link)) ?? [];

mysqli_query($db_link, "SET NAMES 'utf8'");

/* check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    die();
}
