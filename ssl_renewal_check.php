<?php
    $url = "https://blastfm.net";
    $orignal_parse = parse_url($url, PHP_URL_HOST);
    $get = stream_context_create(array("ssl" => array("capture_peer_cert" => TRUE)));
    $read = stream_socket_client("ssl://".$orignal_parse.":443", $errno, $errstr, 30, STREAM_CLIENT_CONNECT, $get);
    $cert = stream_context_get_params($read);
    $certinfo = openssl_x509_parse($cert['options']['ssl']['peer_certificate']);
	$valid_from = date(DATE_RFC2822,$certinfo['validFrom_time_t']);
	$valid_to = date(DATE_RFC2822,$certinfo['validTo_time_t']);
	echo $url." - SSL Certificate Valid From: ".$valid_from.PHP_EOL;
	echo $url." - SSL Certificate Valid To: ".$valid_to.PHP_EOL;
if($certinfo['validTo_time_t'] < time()) {
	session_write_close();
	exec("certbot renew;killall sc_serv;cd /etc/shoutcast;./sc_serv &");
	session_start();
	echo "One or more certificates were renewed.".PHP_EOL;
// 1 0 * * * /usr/bin/php /usr/share/tools/ssl_renewal_check.php > /dev/null 2>&1
} else {
	echo "No certificates due for renewal.".PHP_EOL;
}
?>