# WeaponBuilder

Ok, I don't have a lot of time to write this right now, I will update later. If you want to actually host and use these files on your own web server, there are a few steps.

1. pphrase.php and db_connect.php are ment to be kept one directory behind the web root directory. for example on a basic Apache2 install, web root is /var/www/html. those files should be kept in /var/www
2. phatWeapons.sql needs to be imported into a database accessible by the web server.
3. edit db_connect.php and add in working username/password/etc
4. edit pphrase.php if you would like to change the passphrase


All the site styling is in the default.css file. I did this so "themes" could be easily created (I do this with all my websites) so if anyone would like to submit modifications, please DO NOT add any inline CSS
