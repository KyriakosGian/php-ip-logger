<?php
require_once "./IpLogger.php";
$logger = new IpLogger();
$logger->write('ipsLog.txt', 'Europe/Athens');
?>