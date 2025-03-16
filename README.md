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

Remember to replace `your_database_name`, `your_username`, and `your_password` with your actual desired values. Also, ensure you're using strong, unique passwords for security[2].

Citations:
[1] https://www.mariadbtutorial.com/mariadb-basics/mariadb-create-database/
[2] https://alvinalexander.com/blog/post/mysql/add-user-mysql/
[3] https://mariadb.com/kb/en/account-management-sql-commands/
[4] https://www.inmotionhosting.com/support/website/how-to-create-a-database-with-mariadb/
[5] https://www.beekeeperstudio.io/blog/how-to-create-a-user-in-mariadb
[6] https://phoenixnap.com/kb/how-to-create-mariadb-user-grant-privileges
[7] https://mariadb.com/kb/en/create-database/
[8] https://mariadb.com/kb/en/create-user/

---
Answer from Perplexity: pplx.ai/share
