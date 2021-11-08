# SSL
Certbot auto certificate renewal using Php.
Upload this file to your server replacing https://google.com with the domain name that you want to check and set a cronjob to run it automatically at 1 minute past midnight every day.
1 0 * * * /usr/bin/php /usr/share/tools/ssl_renewal_check.php > /dev/null 2>&1
