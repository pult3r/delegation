1. Get source from git repository : <br/>
https://github.com/pult3r/delegation.git<br/>
<br/>
2. Create Mysql database : <br/>
CREATE DATABASE delegation DEFAULT CHARACTER SET = 'utf8mb4';<br/>
<br/>
3. set DB connection parameter in .env file : <br/>
DB_CONNECTION=mysql<br/>
DB_HOST=127.0.0.1<br/>
DB_PORT=3306<br/>
DB_DATABASE=delegation<br/>
DB_USERNAME=...<br/>
DB_PASSWORD=...<br/>
<br/>
4. In project directory execute :<br/>
$ php artisan migrate<br/>
<br/>
5. Fill `countryrate` table by default data by<br/>
(default setup you can find in /storage/dbdate/countryrate.json)<br/>
$ php artisan db:seed
