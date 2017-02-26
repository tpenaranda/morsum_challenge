# Virtual shelf using homemade Framework.
## Morsum Code Challenge
> In this test we will ask you to create your own tool, to speed things up in the future. The purpose is to build a  light-weight MVC framework. The exercise should emphasis traditional MVC directory structure. .

This was a 48hs challenge, the goal was to create a Virtual Shelf to manage Books, Vinlys, DVDs, etc. The shelf allows to add/delete items using the UI (using JQuery Ajax capabilities, hitting two endpoints using POST or DELETE methods).
Our framework handles the routing, calling the appropiate Controller/Action according to current URL and request method.

### Framework usage
New classes (Models/Controllers) **must** follow this convention.

| Class | Path | Naming | Notes |
| --- | --- | --- | --- |
| Model | app/Models/<model>.php | ucfirst | Table name must be "<model>+s". |
| View | app/Views/<controller_name>/<action>.view | lcase | We can respond with a view file (using "$this->render()" in the Controller) only when responding to GET method ("getAction" action method as example) |
| Controller | app/Controllers/<controller_name>.php | ucfirst  | Must end with "Controller.php" ("AcmeController.php" for instance) |

##### Routing
Routing is very basic.

| URL | Request method | Controller | Action | Notes |
| --- | --- | --- | --- | --- |
| / | <method> | IndexController.php | <method>Index() |
| /<controller> | <method> | <controller>Controller.php | <method>Index() |
| /<controller>/<action> | <method> | <controller>Controller.php | <method><action>() |
| /<controller>/<int> | GET | <controller>Controller.php | getDetails(<int>) |
| /<controller>/<int>/<action> | <method> | <controller>Controller.php | <method><action>(<int>) |

If a Controller or an Action is not defined, framework will fallback to index. Let's check some examples.

| URL | Method | Controller | Action | Notes |
| --- | --- | --- | --- | --- |
| / | GET | IndexController.php | getIndex() ||
| /vinyls | GET | VinylsController.php | getIndex() ||
| /vinyls/hello | GET | VinylsController.php | getHello() ||
| /vinyls/<int> | GET | VinylsController.php | getDetails(<int>) | Routing calls "getDetails(<int>)" if no action was specified afger an int value. |
| /vinyls/hello | DELETE | VinylsController.php | deleteHello() ||
| /vinyls/<int> | DELETE | VinylsController.php | deleteIndex(<int>) ||
| /vinyls | POST | VinylsController.php | postIndex() ||
| /vinyls/hello | POST | VinylsController.php | postHello() ||
| /vinyls/<int> | POST | VinylsController.php | postIndex(<int>) ||

Remember on the Action method, you can call `render()` or `->renderJson()`, this will set the desired `Content-Type` on the header and also you can pass an http code to `->renderJson([], <code>)`.

##### Models
Models are quite simple, just set these propierties as public, framework will use that information to pull/validate data. That's it.
```php
public static $fillable = ['column1', 'column2', 'column3'];
public static $tableName = 'examples';
```

##### OurLittleORM Usage
Available methods:
```php
Model::getById(<id>); #Return model instance.
Model::create(<data_array>); #Instantiate the model and calls save().
Model::fetchAll(); # Returns array of Model items.
modelInstance->save(); # Persist Model into the DB.
modelInstance->delete(); # Persist Model into the DB.
Model::validate(); # Checks if Model data is filled properly according to $fillable property of the model.
```
### Requirements
- PHP >= 5.6
- Apache >= 2.4
- Composer >= 1.1

### Installation steps:
- Check requirements above.
- Configure Apache in order to look for `<project_root>/public/index.php`. Check 'AllowOverride' on Apache configuration in order to support parsing of .htaccess file.
```sh
    <Directory /project_root/public/>
        AllowOverride All
    </Directory>
```
- Install PHP dependencies: `composer install`

- Copy `config/config.php.example` to `config/config.php`. Configure `local_url`and databases. Create the empty DB for production. Create the empty DB for testing.

- [Optional] Create/seed books table running `php <project_root>/app/seeds/Books.php` (warning this will destroy old data).

- [Optional] Create/seed vinils table running `php <project_root>/app/seeds/Vinyls.php` (warning this will destroy old data).

- Run tests. From `<project_folder>` fire up `./vendor/bin/phpunit`.
Expected output:
```sh
PHPUnit 5.7.14 by Sebastian Bergmann and contributors.

.......                                   7 / 7 (100%)

Time: 211 ms, Memory: 4.75MB

OK (7 tests, 19 assertions)
```
- Navigate to `local_url` value from config file and enjoy the app!

### Notes

Wow, time is almost over.  
I really enjoyed this challenge, there is a lot to improve of course (and probably build from scratch) but well, I think that I come up with something which is working and has a value. Actually when I work in this kinds of projects, I try to be as organic as possible, we all know time will be over and project is not going to be completed as we want.  
I don't remember the last time I have written PHP without a Framework but I really missed one when dealing with the tests, testing DB, routing... well, all the time.  
I created some tests (kind of end to end testing using Guzzle) to cover create/delete and pull data from the DB. Adding unit testing for the framework classes look like will be a pain due to the rushed design, but at least those tests are covering what I think is the most important part of the application.  
So, maybe is not.. haha, but I have tried to do our small framework as flexible and open as possible. I think adding a new item type (DVDs, for instance) will be fast and straightforward.  
So, thanks, please let me know any questions!.  
Tate.
