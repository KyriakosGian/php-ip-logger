<h3>This is a file for proper control of the class and its methods</h3>
<?php
require_once "./IpLogger.php";

$logger = new IpLogger();
$logger->write('ipsLog.txt', 'Europe/Athens');

//Optionally enter an address you want to check
$logger->set_ip("8.8.4.4");

echo "Test ip :" . $logger->get_ip();
echo "<br>";
echo "Test user os :" . $logger->get_os();
echo "<br>";
echo "Test browser :" . $logger->get_browser();
echo "<br>";

//This request are from https://ipinfo.io/ and are slow
echo "Test country :" . $logger->get_country();
echo "<br>";
echo "Test city :" . $logger->get_city();
echo "<br>";
echo "Test region :" . $logger->get_region();
echo "<br>";
echo "Test timezone :" . $logger->get_timezone();
echo "<br>";
echo "Test hostname :" . $logger->get_hostname();
?>