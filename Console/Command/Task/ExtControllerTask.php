<?php
/**
 * The ControllerTask handles creating and updating controller files.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2011, Cake Software Foundation, Inc.
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         CakePHP(tm) v 1.2
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

App::uses('ExtBakeTask', 'Templates.Console/Command/Task');  
App::uses('ControllerTask', 'Console/Command/Task'); 

/**
 * Task class for creating and updating controller files.
 *
 * @package       Cake.Console.Command.Task
 */
class ExtControllerTask extends ControllerTask {

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
		return $parser
			->addOption('noAppTestCase', array(
				'short' => 'n',
				'help' => __d('cake_console', 'App test case.')
			))
			->addOption('slug', array(
				'short' => 's',
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
			;
	}


}
