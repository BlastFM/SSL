<?php
    $url = "https://google.com";
    $orignal_parse = parse_url($url, PHP_URL_HOST);
    $get = stream_context_create(array("ssl" => array("capture_peer_cert" => TRUE)));
    $read = stream_socket_client("ssl://".$orignal_parse.":443", $errno, $errstr, 30, STREAM_CLIENT_CONNECT, $get);
    $cert = stream_context_get_params($read);
    $certinfo = openssl_x509_parse($cert['options']['ssl']['peer_certificate']);
	echo $url." - SSL Certificate Valid From: ".date(DATE_RFC2822, $certinfo['validFrom_time_t']).PHP_EOL;
	echo $url." - SSL Certificate Valid To: ".date(DATE_RFC2822, $certinfo['validTo_time_t']).PHP_EOL;
if ($certinfo['validTo_time_t'] <= time() OR $certinfo['validFrom_time_t'] >= time()) {
	exec("sudo certbot renew && sudo killall sc_serv && sudo cd /etc/shoutcast && sudo ./sc_serv &");
	echo "One or more SSL certificates were renewed.".PHP_EOL;
} else {
	echo "No SSL certificates are due for renewal today.".PHP_EOL;
}
?>
