# SSL
Certbot auto certificate renewal using Php.

Upload this file to your server in the /usr/share/tools folder or wherever you prefer, replacing https://google.com in the $url with the domain name that you want to check and set a cronjob to run it automatically at 1 minute past midnight every day.

Cron job: 1 0 * * * /usr/bin/php /usr/share/tools/ssl_renewal_check.php > /dev/null 2>&1

You can also run it directly from the command line with /usr/bin/php /usr/share/tools/ssl_renewal_check.php once it's uploaded but it is probably not going to be very useful to you to run it manually.
