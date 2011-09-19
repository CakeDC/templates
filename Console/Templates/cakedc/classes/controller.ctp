<?php
/**
 * Copyright 2005-2010, Cake Development Corporation (http://cakedc.com)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright 2005-2010, Cake Development Corporation (http://cakedc.com)
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

/**
 * Controller bake template file
 *
 */

 include(dirname(dirname(__FILE__)) . DS .  'common_params.php');

App::uses('SubTemplateShell', 'Templates.Console/Command');
$Subtemplate = new SubTemplateShell($this); 


echo $Subtemplate->generate('controller', 'preset');
extract($this->templateVars);

echo "<?php\n";
?>

<?php if (!empty($plugin)): ?>
App::uses('<?php echo $plugin; ?>AppController', '<?php echo $plugin; ?>.Controller');
<?php else: ?>
App::uses('AppController', 'Controller');
<?php endif; ?>

<?php if (!empty($property)): ?>
/**
<?php 
	echo " * @property {$currentModelName} \${$currentModelName}\n";
?>
 */
<?php endif; ?>
class <?php echo $controllerName; ?>Controller extends <?php echo $plugin; ?>AppController {
/**
 * Controller name
 *
 * @var string
 * @access public
 */
	public $name = '<?php echo $controllerName; ?>';

<?php if ($isScaffold): ?>
	public $scaffold;

<?php else: 
?>
/**
 * Helpers
 *
 * @var array
 * @access public
 */
<?php
echo "\tpublic \$helpers = array('Html', 'Form'";
if (count($helpers)):
	foreach ($helpers as $help):
		echo ", '" . Inflector::camelize($help) . "'";
	endforeach;
endif;
echo ");\n";

if (count($components)):
?>

/**
 * Components
 *
 * @var array
 * @access public
 */
<?php
	echo "\tpublic \$components = array(";
	for ($i = 0, $len = count($components); $i < $len; $i++):
		if ($i != $len - 1):
			echo "'" . Inflector::camelize($components[$i]) . "', ";
		else:
			echo "'" . Inflector::camelize($components[$i]) . "'";
		endif;
	endfor;
	echo ");\n";
endif;

echo $Subtemplate->generate('controller', 'var');

echo $actions;

endif; ?>


}
