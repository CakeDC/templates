CakeDC Templates Plugin
========================

[![Bake Status](https://secure.travis-ci.org/CakeDC/templates.png?branch=master)](http://travis-ci.org/CakeDC/templates)
[![Downloads](https://poser.pugx.org/CakeDC/templates/d/total.png)](https://packagist.org/packages/CakeDC/templates)
[![Latest Version](https://poser.pugx.org/CakeDC/templates/v/stable.png)](https://packagist.org/packages/CakeDC/templates)

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

For documentation, as well as tutorials, see the [Docs](Docs/Home.md) directory of this repository.

Support
-------

For bugs and feature requests, please use the [issues](https://github.com/CakeDC/templates/issues) section of this repository.

Commercial support is also available, [contact us](http://cakedc.com/contact) for more information.

Contributing
------------

This repository follows the [CakeDC Plugin Standard](http://cakedc.com/plugin-standard). If you'd like to contribute new features, enhancements or bug fixes to the plugin, please read our [Contribution Guidelines](http://cakedc.com/contribution-guidelines) for detailed instructions.

License
-------

Copyright 2007-2015 Cake Development Corporation (CakeDC). All rights reserved.

Licensed under the [MIT](http://www.opensource.org/licenses/mit-license.php) License. Redistributions of the source code included in this repository must retain the copyright notice found in each file.
