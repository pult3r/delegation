1. Get source from git repository : 
https://github.com/pult3r/delegation.git

2. Create Mysql database : 
CREATE DATABASE delegation DEFAULT CHARACTER SET = 'utf8mb4';

3. set DB connection parameter in .env file : 
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=delegation
DB_USERNAME=...
DB_PASSWORD=...

4. In project directory execute :
$ php artisan migrate

5. Fill `countryrate` table by default data by
(default setup you can find in /storage/dbdate/countryrate.json)
$ php artisan db:seed
