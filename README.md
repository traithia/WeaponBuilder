# WeaponBuilder updated 9/23/17

Basic Setup:

requirements: webserver running PHP7 (will proabably work with PHP5 but is untested), MySQL or compatible 

1. pphrase.php and db_connect.php are ment to be kept one directory behind the web root directory. for example on a basic Apache2 install, web root is /var/www/html. those files should be kept in /var/www  
2. phatWeapons.sql needs to be imported into a database accessible by the web server.
3. edit db_connect.php and add in working username/password/etc
4. edit pphrase.php if you would like to change the passphrase
5. webserver must have write privilages for the directory "json_temp"

