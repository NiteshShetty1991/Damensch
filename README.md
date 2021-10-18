# Registration and User Api's built with CodeIgniter4

Implemented a Registration page and REST API using codeigniter and mysql.

## Steps to configure the project:

- Install Apache and Mysql.
- Clone the Project folder inside opt/lampp(or Xampp)/htdocs.
- Create a database with  name "Damensch" and import the given sql file.
- Navigate to Project folder in terminal.
- Run `php spark serve`.
- Copy the url and open in browser.`eg:- http://localhost:8080/`

## List of User REST API:

- CREATE USER: http://localhost:8080/userCreate
- GET ALL USERS: http://localhost:8080/user
- GET SINGLE USER: http://localhost:8080/user/{id}
- UPDATE USER: http://localhost:8080/user/{id}
- DELETE USER: http://localhost:8080/user/{id}

CREATE USER returns JWT Token which is required for other api's.

Unit testing is available inside test folder.

