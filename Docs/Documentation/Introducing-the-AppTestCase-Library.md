Introducing the AppTestCase library
===================================

This plugin introduces additional features into your application tests.

First of all it contains an `AppTestCase` class that extends `CakeTestCase` with some nice features. This allows you to solve the problem of adding new models into your app without breaking model and controller level tests. Instead of defining a list of fixtures in each test file it is now possible to define these just in the test scope.

In test case files, it is enough to define `$plugin = 'app'` for app level tests or `$plugin = 'plugin_name'` for plugin level tests.

The `APP/tests/config/fixtures.php` should look like:

```php
$config = array(
	'app.article',
	'app.comment',
	'plugin.users.user'
);
```

The `AppTestCase` also introduces plugin fixtures dependency resolving.

To use it, the `APP/tests/config/dependent.php` should look like

```php
$config = array(
	'friends',
	'messages'
);
```

During development, sometimes it is really useful to run just one test. You can use the `$_testsToRun` array to list what test methods should be executed.

Also it provides several mock methods.

* `AppMock::getTestModel()` - create a mock for a model.
* `AppMock::getTestController()` - allows creation of a mocked controller object, introducing `expectRedirect()` method. Together with `expectRedirect()` it is necessary to use `expectExactRedirectCount()` at the end of tested method. Also added are the `expectRender()`/`expectExactRender()` and `expectSetAction()`/`expectExactSetActionCount()` method pairs.

Here is an example of creating a mocked controller object.

```php
$this->Consoles = AppMock::getTestController('ConsolesController');
```
