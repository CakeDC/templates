Test and Fixture Conventions
============================

Tests baked with the Templates plugin follow some important conventions.

Each fixture should contain at least one data record. As we use UUID primary keys for all our models, we also add easy to read ID keys. The first record ID should be named like `article-1` or `user-1`, so it is the lowercase and dash-delimited model name with a numeric "-1" at end.

All tests are baked so that this record is used for testing different model and controller operations.

If slugs are used during the bake, this field should instead contain `first_article` or `first_comment` in the fixture.

No other requirements exists.

Add and edit tests checks both valid and invalid user actions. To test invalid passed model data, we need to setup a fixture record using `unset()` on fixture fields.

So if `Article.title` is required and there is a validation rule for it, then this field is a good candidate to unset in the second part of the `testAdd()` method. You just need to add `unset($data['Article']['title']);` to make this test pass. In generated test files such string exists both in the `testAdd()` and `testEdit()` methods but are commented out. The reason for this is simple - not all models have title field, and during the bake the Template plugin has no information about what fields are supposed to be required.

When a fixture is configured and model test cases are updated, the tests should be all green and show 100% code coverage.

In other cases, if some tests are failing then fixture is not set up correctly or something is missing in model class

By default you are required to add the fixture name into the `APP/tests/config/fixtures.php` file after baking.
