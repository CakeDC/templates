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

include(dirname(dirname(__FILE__)) . DS .  'common_params.php');
echo "<?php\n";	?>
App::uses('ViewBaseView', 'Templates.Lib/Ctk/Default');

class ViewView extends ViewBaseView {

	public function build() {
		$this->_wrapperClass = '<?php echo $pluralVar;?> index';
		$this->_modelName = '<?php echo $modelClass;?>';
		$this->_pageLabel = __('<?php echo $pluralHumanName;?>');
		$this->_fields = array(
<?php
foreach ($fields as $field) {
	$isKey = false;
	if (!empty($associations['belongsTo'])) {
		foreach ($associations['belongsTo'] as $alias => $details) {
			if ($field === $details['foreignKey']) {
				$isKey = true;
				echo "\t\t<dt<?php if (\$i % 2 == 0) echo \$class;?>><?php echo __('" . Inflector::humanize(Inflector::underscore($alias)) . "'); ?></dt>\n";
				echo "\t\t<dd<?php if (\$i++ % 2 == 0) echo \$class;?>>\n\t\t\t<?php echo \$this->Html->link(\$this->{$singularVar}['{$alias}']['{$details['displayField']}'], array('controller' => '{$details['controller']}', 'action' => 'view', \$this->{$singularVar}['{$alias}']['{$details['primaryKey']}'])); ?>\n\t\t\t&nbsp;\n\t\t</dd>\n";
				echo "\t\t\tarray(\n";
				echo "\t\t\t\t'label' => __('" . Inflector::humanize(Inflector::underscore($alias)) . "'),\n";
				echo "\t\t\t\t'value' => \$this->Cake->Link('title' => \$this->{$singularVar}['{$alias}']['{$details['displayField']}'], 'url' => array('controller' => '{$details['controller']}', 'action' => 'view', \$this->{$singularVar}['{$alias}']['{$details['primaryKey']}']))),\n";
				echo "\t\t\t),\n";
				break;
			}
		}
	}
	if ($isKey !== true) {
		echo "\t\t\tarray(\n";
		echo "\t\t\t\t'label' => __('" . Inflector::humanize($field) . "'),\n";
		echo "\t\t\t\t'value' => \$this->{$singularVar}['{$modelClass}']['{$field}'] . '&nbsp;',\n";
		echo "\t\t\t),\n";
	}
}
?>
		);
<?php 
		$idKeyPK = $idKey = "\$this->{$singularVar}['{$modelClass}']['{$primaryKey}']";
		if ($slugged) {
			$idKey = "\$this->{$singularVar}['{$modelClass}']['slug']";
		}
?>

		$this->_actions = array(
<?php echo "\t\t\t\$this->Cake->Link(array('title' => __('Edit {$singularHumanName}'), 'url' => array('action' => 'edit', {$idKeyPK}))),\n";?>
<?php echo "\t\t\t\$this->Cake->Link(array('title' => __('Delete {$singularHumanName}'), 'url' => array('action' => 'delete', {$idKeyPK}))),\n";?>
<?php echo "\t\t\t\$this->Cake->Link(array('title' => __('List {$pluralHumanName}'), 'url' => array('action' => 'index'{$additionalParams}))),\n";?>
<?php echo "\t\t\t\$this->Cake->Link(array('title' => __('New {$singularHumanName}'), 'url' => array('action' => 'add'{$additionalParams}))),\n";?>
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
