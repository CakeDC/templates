<?php
/**
 * Copyright 2005-2011, Cake Development Corporation (http://cakedc.com)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright 2005-2011, Cake Development Corporation (http://cakedc.com)
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

App::uses('CakeEmail', 'Network/Email');
App::uses('ControllerTestCase', 'TestSuite'); 
/**
 * App Controller Test case. Contains base set of fixtures.
 *
 * @package templates
 * @subpackage templates.libs
 */
class AppControllerTestCase extends ControllerTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $dependedFixtures = array();

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array();

/**
 * Autoload entrypoint for fixtures dependecy solver
 *
 * @var string
 */
	public $plugin = null;

/**
 * Test to run for the test case (e.g array('testFind', 'testView'))
 * If this attribute is not empty only the tests from the list will be executed
 *
 * @var array
 */
	protected $_testsToRun = array();

/**
 * Constructor
 *
 * If a class is extending AppTestCase it will merge these with the extending classes
 * so that you don't have to put the plugin fixtures into the AppTestCase
 *
 * @return void
 */
	public function __construct() {
		parent::__construct();
		if (is_subclass_of($this, 'AppControllerTestCase')) {
			$parentClass = get_parent_class($this);
			$parentVars = get_class_vars($parentClass);
			if (isset($parentVars['fixtures'])) {
				$this->fixtures = array_unique(array_merge($parentVars['fixtures'], $this->fixtures));
			}
			if (!empty($this->plugin)) {
				$this->dependedFixtures = $this->solveDependancies($this->plugin);
			}
			if (!empty($this->dependedFixtures)) {
				foreach ($this->dependedFixtures as $plugin) {
					$fixtures = $this->loadConfig('fixtures', $plugin);
					if (!empty($fixtures)) {
						$this->fixtures = array_unique(array_merge($this->fixtures, $fixtures));
					}
				}
			}
		}
	}

/**
 * Loads a file from app/tests/config/configure_file.php or app/plugins/PLUGIN/tests/config/configure_file.php
 *
 * Config file variables should be formated like:
 *  $config['name'] = 'value';
 * These will be used to create dynamic Configure vars.
 *
 *
 * @param string $fileName name of file to load, extension must be .php and only the name
 *     should be used, not the extenstion.
 * @param string $type Type of config file being loaded. If equal to 'app' core config files will be use.
 *    if $type == 'pluginName' that plugins tests/config files will be loaded.
 * @return mixed false if file not found, void if load successful
 */
	public function loadConfig($fileName, $type = 'app') {
		$found = false;
		if ($type == 'app') {
			$folder = APP . 'Test' . DS . 'Config' . DS;
		} else {
			$folder = App::pluginPath($type);
				if (!empty($folder)) {
				$folder .= 'Test' . DS . 'Config' . DS;
			} else {
				return false;
			}
		}
		if (file_exists($folder . $fileName . '.php')) {
			include($folder . $fileName . '.php');
			$found = true;
		}

		if (!$found) {
			return false;
		}

		if (!isset($config)) {
			$error = __("AppTestCase::load() - no variable \$config found in %s.php", true);
			trigger_error(sprintf($error, $fileName), E_USER_WARNING);
			return false;
		}
		return $config;
	}

/**
 * Solves Plugin Fixture dependancies.  Called in AppTestCase::__construct to solve
 * fixture dependancies.  Uses a Plugins tests/config/dependent and tests/config/fixtures
 * to load plugin fixtures. To use this feature set $plugin = 'pluginName' in your test case.
 *
 * @param string $plugin Name of the plugin to load
 * @return array Array of plugins that this plugin's test cases depend on.
 */
	public function solveDependancies($plugin) {
		$found = false;
		$result = array($plugin);
		$add = $result;
		do {
			$changed = false;
			$copy = $add;
			$add = array();
			foreach ($copy as $pluginName) {
				$dependent = $this->loadConfig('dependent', $pluginName);
				if (!empty($dependent)) {
					foreach ($dependent as $parentPlugin) {
						if (!in_array($parentPlugin, $result)) {
							$add[] = $parentPlugin;
							$result[] = $parentPlugin;
							$changed = true;
						}
					}
				}
			}
		} while ($changed);
		return $result;
	}

/**
 * Overrides parent method to allow selecting tests to run in the current test case
 * It is useful when working on one particular test
 *
 * @return array List of tests to run
 */
	public function getTests() {
		if (!empty($this->_testsToRun)) {
			debug('Only the following tests will be executed: ' . join(', ', (array) $this->_testsToRun), false, false);
			$result = array_merge(array('start', 'startCase'), (array) $this->_testsToRun, array('endCase', 'end'));
			return $result;
		} else {
			return parent::getTests();
		}
	}

/**
 * Asserts that data are valid given Model validation rules
 * Calls the Model::validate() method and asserts the result
 *
 * @param Model $Model Model being tested
 * @param array $data Data to validate
 * @return void
 */
	public function assertValid(Model $Model, $data) {
		$this->assertTrue($this->_validData($Model, $data));
	}

/**
 * Asserts that data are invalid given Model validation rules
 * Calls the Model::validate() method and asserts the result
 *
 * @param Model $Model Model being tested
 * @param array $data Data to validate
 * @return void
 */
	public function assertInvalid(Model $Model, $data) {
		$this->assertFalse($this->_validData($Model, $data));
	}

/**
 * Asserts that data are validation errors match an expected value when
 * validation given data for the Model
 * Calls the Model::validate() method and asserts validationErrors
 *
 * @param Model $Model Model being tested
 * @param array $data Data to validate
 * @param array $expectedErrors Expected errors keys
 * @return void
 */
	public function assertValidationErrors($Model, $data, $expectedErrors) {
		$this->_validData($Model, $data, $validationErrors);
		sort($expectedErrors);
		$this->assertEqual(array_keys($validationErrors), $expectedErrors);
	}

/**
 * Convenience method allowing to validate data and return the result
 *
 * @param Model $Model Model being tested
 * @param array $data Profile data
 * @param array $validationErrors Validation errors: this variable will be updated with validationErrors (sorted by key) in case of validation fail
 * @return boolean Return value of Model::validate()
 */
	protected function _validData(Model $Model, $data, &$validationErrors = array()) {
		$valid = true;
		$Model->create($data);
		if (!$Model->validates()) {
			$validationErrors = $Model->validationErrors;
			ksort($validationErrors);
			$valid = false;
		} else {
			$validationErrors = array();
		}
		return $valid;
	}

	
	public static function assertIsA($actual, $expected, $message = '') {
		self::assertType($expected, $actual, $message);
	}

	public static function assertNotA($actual, $expected, $message = '') {
		self::assertNotType($expected, $actual, $message);
	}

	public static function assertTrue($condition, $message = '') {
		parent::assertTrue((bool)$condition, $message);
	}

	public static function assertFalse($condition, $message = '') {
		parent::assertFalse((bool)$condition, $message);
	}

	public function pass($message = '') {
	}

	// public static function assertEqual($expected, $actual, $message = '') {
		// self::assertEquals($expected, $actual, $message);
	// }	
	
	private $__redirectExpectCount = 0;
	private $__setFlashExpectCount = 0;
	
	public function expectRedirect($Controller, $url) {
		$Controller
			->expects($this->at($this->__redirectExpectCount++))
			->method('redirect')
			->with($url);
		
	}

	public function assertFlash($Controller, $message) {
		$Controller->Session
			->expects($this->at($this->__setFlashExpectCount++))
			->method('setFlash')
			->with($message);
	}


	protected function _resetExpectation() {
		$this->__redirectExpectCount = 0;
		$this->__setFlashExpectCount = 0;
	}

/**
 * Provides conventional method to mock CakeEmail object
 * 
 * @return PHPUnit_Framework_MockObject_MockObject
 */
	public function mockCakeEmail() {
		$CakeEmail = $this->getMock('CakeEmail');
		$cakeEmailMethods = array('from', 'to', 'subject', 'template', 'viewVars', 'emailFormat', 'transport', 'replyTo', 'cc');
		foreach ($cakeEmailMethods as $method) {
			$CakeEmail->expects($this->any())
				 ->method($method)
				 ->will($this->returnSelf());
		}
		return $CakeEmail;
	}
	
}


