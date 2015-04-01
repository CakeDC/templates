Home
====

This plugin allows you to quickly bake your applications with collection-like operations over your models and high test coverage (100%) for all your baked code.

In short, this plugin includes custom templates for the bake code generator. It also provides a wizard which will help you choose the right options for your bake commands.

Generated code focuses on the "fat models" mantra - they will have most of the logic for handling your data, and sending messages back to the controller to do the flow control.

One might ask, "why would I need to test model CRUD code that is already checked with cake core tests?"

The answer is simple: when you extend model features with callbacks and different behavior unexpected things might happen with model configurations and some of the CRUD operations can be easily broken. The same applies to controller level tests.

Requirements
------------

* CakePHP 2.x
* PHP 5.2.8+

Documentation
-------------

* [Installation](Documentation/Installation.md)
* [Basic Usage](Documentation/Basic-Usage.md)
* [Introducing the AppTestCase library](Documentation/Introducing-the-AppTestCase-Library.md)
* [Test and Fixture Conventions](Documentation/Test-and-Fixture-Conventions.md)
* [Command Line Modifiers](Documentation/Command-Line-Modifiers.md)
* [Usage Example](Documentation/Usage-Example.md)
* [Integrating with Search plugin](Documentation/Integrating-with-Search-Plugin.md)
* [User Dependent Actions](Documentation/User-Dependent-Actions.md)
