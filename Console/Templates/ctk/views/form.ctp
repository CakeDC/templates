<?php
/**
 * Copyright 2005-2013, Cake Development Corporation (http://cakedc.com)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright 2005-2013, Cake Development Corporation (http://cakedc.com)
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
?>
<?php include(dirname(dirname(__FILE__)) . DS .  'common_params.php'); 
echo "<?php\n";
?>
App::uses('FormBaseView', 'Templates.Lib/Ctk/Default');

class <?php echo Inflector::camelize($action);?>View extends FormBaseView {

	public function build() {
		$this->_wrapperClass = '<?php echo $pluralVar;?> form';
<?php if (in_array($action, array('add', 'admin_add'))): ?>
<?php echo "\t\t\$this->_modelName = '{$modelClass}';\n";?>
<?php echo "\t\t\$this->_formOptions = array('action' => 'add'{$additionalParams});\n";?>
<?php elseif (in_array($action, array('edit', 'admin_edit'))): ?>
<?php echo "\t\t\$this->_modelName = '{$modelClass}';\n";?>
<?php echo "\t\t\$this->_formOptions = array('action' => 'edit');\n";?>
<?php endif;?>
<?php echo "\t\t\$this->_pageLabel = __('" . Inflector::humanize($action) . " {$singularHumanName}');\n";?>
		
		$this->_fields = array(
<?php
		foreach ($fields as $field) {
			if (in_array($action, array('add', 'admin_add')) && $field == $primaryKey) {
				continue;
			} elseif (!in_array($field, array('created', 'modified', 'updated'))) {
				if (!$parentIncluded || $parentIncluded && $field != $parentIdDbVar) {
					echo "\t\t\t\$this->Cake->Input(array('field' => '{$field}')),\n";
				}
			}
		}
		if (!empty($associations['hasAndBelongsToMany'])) {
			foreach ($associations['hasAndBelongsToMany'] as $assocName => $assocData) {
				echo "\t\t\t\$this->Cake->Input(array('field' => '{$assocName}')),\n";
			}
		}
?>
		);
			
<?php 
	$idKeyPK = $idKey = "\$this->Form->value('{$modelClass}.{$primaryKey}')";
	if ($slugged) {
		$idKey = "\$this->Form->value('{$modelClass}.slug')";
	}
?>
		$this->_actions = array(
<?php if (!in_array($action, array('add', 'admin_add'))):?>
<?php echo "\t\t\t\$this->Cake->Link(array('title' => __('Delete'), 'url' => array('action' => 'delete', {$idKeyPK}))),\n";?>
<?php endif;?>
<?php echo "\t\t\t\$this->Cake->Link(array('title' => __('List {$pluralHumanName}'), 'url' => array('action' => 'index'{$additionalParams}))),\n";?>
<?php
		$done = array();
		foreach ($associations as $type => $data) {
			foreach ($data as $alias => $details) {
				if ($details['controller'] != $this->name && !in_array($details['controller'], $done)) {
					echo "\t\t\t\$this->Cake->Link(array('title' => __('List " . Inflector::humanize($details['controller']) . "'), 'url' => array('controller' => '{$details['controller']}', 'action' => 'index'))),\n";
					echo "\t\t\t\$this->Cake->Link(array('title' => __('New " . Inflector::humanize(Inflector::underscore($alias)) . "'), 'url' => array('controller' => '{$details['controller']}', 'action' => 'add'))),\n";
					$done[] = $details['controller'];
				}
			}
		}
?>
		);

		parent::build();
	}

}
