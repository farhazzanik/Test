Here are its specifications:
A user can submit a URL and receive a unique shortcode in response.
A user can submit a URL and shortcode and will receive the chosen shortcode if it is available.
A user can access a /<shortcode> endpoint and be redirected to the URL associated with that shortcode, if it exists.
All shortcodes can contain digits, upper case letters, and lowercase letters. It is case sensitive.
Automatically generated shortcodes are exactly 6 characters long.
User submitted shortcodes must be at least 4 characters long.
A user can access a /<shortcode>/stats endpoint in order to see when the shortcode was registered, when it was last accessed, and how many times it was accessed.


Technology Name : php oop,mysql,bootstrap,javascript

software names that you need for run this project.

1.Xampp,wamp

->open xampp application and start Apache and mysql

Extract wmAssaingments folder and send folder to C:\xampp\htdocs\ this location

go to http://localhost/phpmyadmin/ link on your browser


->create a databse with name "movingworlds"

->select movingworld database 

->click on import 

->click on choose file

->C:\xampp\htdocs\wmAssaingments in this folder you will see one movingworlds.sql file,select this file and click on go then you will see one table import name with "short_urls"

->http://localhost/wmAssaingments/ go to this link i hope this project will run if everything is ok


NB:  -> maybe your apache port would not be 80,check your apache port,then link might be like that,http://localhost:81/wmAssaingments/
	-> please make sure that your  Hostname ="localhost" and username="root" and userpassword = "" and databsename="movingworlds"
