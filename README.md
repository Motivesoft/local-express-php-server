# PHP WordGriddle site
Small web server working with PHP files

## Creating the database
To create a database and add users using MariaDB command-line tools, follow these steps:

1. **Log in to MariaDB**:
   ```bash
   mysql -u root -p
   ```
   Enter your root password when prompted.

2. **Create a new database**:
   ```sql
   CREATE DATABASE your_database_name;
   ```
   Replace `your_database_name` with your desired database name[1][7].

3. **Create a new user**:
   ```sql
   CREATE USER 'your_username'@'localhost' IDENTIFIED BY 'your_password';
   ```
   Replace `your_username` and `your_password` with your desired credentials[5][6].

4. **Grant privileges to the new user**:
   ```sql
   GRANT ALL PRIVILEGES ON your_database_name.* TO 'your_username'@'localhost';
   ```
   This grants all privileges on the specified database to the new user[2][6].

5. **Apply the changes**:
   ```sql
   FLUSH PRIVILEGES;
   ```
   This reloads the privileges table, ensuring the changes take effect immediately[5].

6. **Verify the new user and database**:
   ```sql
   SHOW DATABASES;
   SELECT User FROM mysql.user;
   ```
   These commands will display the list of databases and users, respectively[1][6].

7. **Exit MariaDB**:
   ```sql
   EXIT;
   ```


## Creating and dropping tables
```
php  -d xdebug.mode=off drop-tables.php 
php  -d xdebug.mode=off create-tables.php 
```

## Running the server
```
cd public
php -S 0.0.0.0:9999 router.php
```