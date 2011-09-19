<?php
/**
 * The ModelTask handles creating and updating models files.
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
 * @since         CakePHP(tm) v 1.2
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

App::uses('ModelTask', 'Console/Command/Task'); 
//App::uses('ExtBakeTask', 'Templates.Console/Command/Task'); 

/**
 * Task class for creating and updating model files.
 *
 * @package       Cake.Console.Command.Task
 */
class ExtModelTask extends ModelTask {

	public $name = 'Model';

	public function execute() {
		parent::execute();
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
			->addOption('property', array(
				'short' => 'y',
				'boolean' => true,
				'help' => __d('cake_console', 'generate IDE properties hints for model relations')
			))			
			;
	}


}
