# SSL
Certbot auto certificate renewal using Php.

Upload the ssl_renewal_check.php file to your server in the /usr/share/tools folder or wherever you prefer, replacing https://google.com in the $url with the domain name that you want to check and set a cronjob to run it automatically at 1 minute past midnight every day.

Cron job: 1 0 * * * /usr/bin/php /usr/share/tools/ssl_renewal_check.php > /dev/null 2>&1

You can also run it directly from the command line with /usr/bin/php /usr/share/tools/ssl_renewal_check.php once it's uploaded but it is probably not going to be very useful to you to run it manually.

We read the SSL certificate that is installed on the server for the domain name listed in $url and from the result we get the valid from and valid to dates from the certificate. We then check if the date/time is less than the current date/time, a sure indicator that your certificate has expired when this becomes true.

If we are updating the certificate(s), remember that certbot renew will renew any certificates that are out of date, we end the current session, carry out the renewal and then restart sessions to prevent any session attacks or interference from outside sources as a security precaution.

One useful thing to note here is that we are not requesting new certificates from Letsencrypt (certbot) unless the current one is out of date, this means that we won't trigger any usage limitations because we don't actually check the certificate every day, only when the current one is obsolete.

I am using a Linux Ubuntu server, your requirements may vary slightly. Certbot is installed on the server. /usr/bin/php is the path to my Php binaries. It would be usual to use the -q switch with certbot renew but since we are sending any output to /dev/null in the cronjob we don't need the switch. You can upload the file to wherever you wish, just remember to correct the path to the file in your cronjob. Usr/share/tools seems like a reasonable place to store the file but it is up to you, if you move it elsewhere you may need to adjust the file/folder permissions in order for cron to be able to execute it on demand.
