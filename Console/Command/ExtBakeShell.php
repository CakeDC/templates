<?php
/**
 * Command-line code generation utility to automate programmer chores.
 *
 * Bake is CakePHP's code generation script, which can help you kickstart
 * application development by writing fully functional skeleton controllers,
 * models, and views. Going further, Bake can also write Unit Tests for you.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         CakePHP(tm) v 1.2.0.5012
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

App::uses('Model', 'Model');
App::uses('BakeShell', 'Console/Command'); 

/**
 * Bake is a command-line code generation utility for automating programmer chores.
 *
 * @package       Cake.Console.Command
 * @link          http://book.cakephp.org/view/1522/Code-Generation-with-Bake
 */
class ExtBakeShell extends BakeShell {

/**
 * Contains tasks to load and instantiate
 *
 * @var array
 */
	public $tasks = array('Project', 'DbConfig', 
		'Templates.ExtModel', 
		'Templates.ExtController', 
		'Templates.ExtView', 
		'Plugin', 'Fixture', 'Test');

/**
 * The connection being used.
 *
 * @var string
 */
	public $connection = 'default';

/**
 * Assign $this->connection to the active task if a connection param is set.
 *
 */
	public function startup() {
		parent::startup();
		$task = Inflector::classify($this->command);
		if (isset($this->{$task}) && !in_array($task, array('Project', 'DbConfig'))) {
			if (isset($this->params['connection'])) {
				$this->{$task}->connection = $this->params['connection'];
			}
		}
	}

/**
 * Override main() to handle action
 *
 */
	public function main() {
		if (!is_dir($this->DbConfig->path)) {
			$path = $this->Project->execute();
			if (!empty($path)) {
				$this->DbConfig->path = $path . 'Config' . DS;
			} else {
				return false;
			}
		}

		if (!config('database')) {
			$this->out(__d('cake_console', 'Your database configuration was not found. Take a moment to create one.'));
			$this->args = null;
			return $this->DbConfig->execute();
		}
		$this->out(__d('cake_console', 'Interactive Bake Shell'));
		$this->hr();
		$this->out(__d('cake_console', '[D]atabase Configuration'));
		$this->out(__d('cake_console', '[M]odel'));
		$this->out(__d('cake_console', '[V]iew'));
		$this->out(__d('cake_console', '[C]ontroller'));
		$this->out(__d('cake_console', '[P]roject'));
		$this->out(__d('cake_console', '[F]ixture'));
		$this->out(__d('cake_console', '[T]est case'));
		$this->out(__d('cake_console', '[Q]uit'));

		$classToBake = strtoupper($this->in(__d('cake_console', 'What would you like to Bake?'), array('D', 'M', 'V', 'C', 'P', 'F', 'T', 'Q')));
		switch ($classToBake) {
			case 'D':
				$this->DbConfig->execute();
				break;
			case 'M':
				$this->ExtModel->execute();
				break;
			case 'V':
				$this->ExtView->execute();
				break;
			case 'C':
				$this->ExtController->execute();
				break;
			case 'P':
				$this->Project->execute();
				break;
			case 'F':
				$this->Fixture->execute();
				break;
			case 'T':
				$this->Test->execute();
				break;
			case 'Q':
				exit(0);
				break;
			default:
				$this->out(__d('cake_console', 'You have made an invalid selection. Please choose a type of class to Bake by entering D, M, V, F, T, or C.'));
		}
		$this->hr();
		$this->main();
	}


/**
 * get the option parser.
 *
 * @return void
 */
	public function getOptionParser() {
		$parser = parent::getOptionParser();
		return 
		$parser		
			->addOption('plugin', array(
				'short' => 'l',
				'help' => __d('cake_console', 'Plugin.')
			))
			->addOption('appTestCase', array(
				'short' => 'z',
				'help' => __d('cake_console', 'App test case.')
			))
			->addOption('noAppTestCase', array(
				'short' => 'n',
				'help' => __d('cake_console', 'App test case.')
			))
			->addOption('slug', array(
				'short' => 's',
				'boolean' => true,
				'help' => __d('cake_console', 'Use slug.')
			))
			->addOption('parentSlug', array(
				'short' => 'f',
				'boolean' => true,
				'help' => __d('cake_console', 'Use slug.')
			))
			->addOption('user', array(
				'short' => 'u',
				'help' => __d('cake_console', 'Use user model.')
			))
			->addOption('parent', array(
				'short' => 'r',
				'help' => __d('cake_console', 'Use parent model.')
			))
			->addOption('theme', array(
				'short' => 't',
				'help' => __d('cake_console', 'theme.')
			))
			->addOption('subthemes', array(
				'short' => 'b',
				'help' => __d('cake_console', 'subthemes.')
			))			
			->addOption('public', array(
				'short' => 'p',
				'help' => __d('cake_console', 'public controller action')
			))			
			->addOption('admin', array(
				'short' => 'a',
				'help' => __d('cake_console', 'admin controller action')
			))			
			->addOption('property', array(
				'short' => 'y',
				'boolean' => true,
				'help' => __d('cake_console', 'generate IDE properties hints for model relations')
			))
		
		;
	}

	public function runCommand($command, $argv) {
		if (strtolower($command) == 'model') {
			$command = 'ext_model';
		}
		if (strtolower($command) == 'controller') {
			$command = 'ext_controller';
		}
		if (strtolower($command) == 'view') {
			$command = 'ext_view';
		}
		return parent::runCommand($command, $argv);
	}

}
