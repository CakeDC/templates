Command Line Modifiers
======================

* `-user UserModelName` - generated model code contains `userId` parameter for all CRUD methods. Controllers pass `userId` (as `Auth->user('id')` value) to the models.
* `-slug` - make the generator do all model searches using a slug field instead of an ID.
* `-noAppTestCase` - generate tests that extend `CakeTestCase` instead of `AppTestCase`.
* `-parent` - introduce a parent-child model structure into the generated code.
* `-parentSlug` - make the generator do all parent model searches using a slug field on the controller index.
* `-subthemes` - allows injecting additional features into the baked code. For example, introducing Search capabilities.
