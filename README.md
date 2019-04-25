# railway_application
1. First run postgres on the system and execute all the commands in order in `queries.sql` in the root folder of the repository
2. Download XAMPP on system and clone the respository into `xampp/htdocs/`
3. Uncomment line `;extension=php_pdo_pgsql.dll` in the `php.ini` file inside XAMPP
4. Rename `example_dbconfig.php` to `dbconfig.php` in the root respository and add the necessary details about the Postgres configuration.
5. Run Apache Server using XAMPP and open `http://localhost/railway_application/pages/signup.html` to open the application and signup a user to start
