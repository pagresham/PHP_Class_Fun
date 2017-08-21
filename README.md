# PHP_Class_Fun
This would be the login in and create user portion of a larger application. 
Instead of procedural programming for the form processing, I used a more OO approach as well as a MVC structure.

Model -> MySql DB -> DBConnection Class - contains all methods that go to the DB for various reasons. 

View -> index.php, header.php, elsewhere.php - Serve as the view and the 'main' or start page for the application

Controller -> Control.php CreateUserController.php, LoginController.php - Contain methods for the logic, and to go between the model and the view.
