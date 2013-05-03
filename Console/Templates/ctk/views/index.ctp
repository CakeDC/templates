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
App::uses('IndexBaseView', 'Templates.Lib/Ctk/Default');

class IndexView extends IndexBaseView {

	public function build() {
		$this->wrapperClass = '<?php echo $pluralVar;?> index';
		$this->modelName = '<?php echo $modelClass;?>';
		$this->title = __('<?php echo $pluralHumanName;?>');
		$this->headers = array(
<?php  foreach ($fields as $field):?>
			$this->Paginator->sort('<?php echo $field;?>'),
<?php  endforeach; ?>
			$this->Html->Th(array('text' => __('Actions'), 'class' => 'actions')),
		);

		foreach ($this-><?php echo $pluralVar;?> as $<?php echo $singularVar;?>) {
			$cells = array(
<?php 
		foreach ($fields as $field) {
			$isKey = false;
			if (!empty($associations['belongsTo'])) {
				foreach ($associations['belongsTo'] as $alias => $details) {
					if ($field === $details['foreignKey']) {
						$isKey = true;
						echo "\t\t\t\t\$this->Cake->Link(array('title' => \${$singularVar}['{$alias}']['{$details['displayField']}'], 'url' => array('controller' => '{$details['controller']}', 'action' => 'view', \${$singularVar}['{$alias}']['{$details['primaryKey']}']))),\n";
						break;
					}
				}
			}
			if ($isKey !== true) {
				echo "\t\t\t\t\${$singularVar}['{$modelClass}']['{$field}'],\n";
			}
		}

		$idKeyPK = $idKey = "\${$singularVar}['{$modelClass}']['{$primaryKey}']";
		if ($slugged) {
			$idKey = "\${$singularVar}['{$modelClass}']['slug']";
		}

;?>
			
<?php if (false): //foreach ($fields as $field):?>
				$this->Html->Td(array('text' => $<?php echo $singularVar;?>['<?php echo $modelClass;?>']['<?php echo $field;?>'])),
				$this->_rowActions($user)
<?php endif; //endforeach; ?>
			);
			$actions = $this->Html->Td(array('class' => 'actions'));
			$actions->addMany(array(
<?php 
	echo "\t\t\t\t\$this->_viewLink(\${$singularVar}, array('action' => 'view', {$idKey})),\n";
	echo "\t\t\t\t\$this->_editLink(\${$singularVar}, array('action' => 'edit', {$idKeyPK})),\n";
	echo "\t\t\t\t\$this->_deleteLink(\${$singularVar}, array('action' => 'delete', {$idKeyPK})),\n";
?>
			));
			$cells[] = $actions;
			$this->rows[] = $cells;
		}

		$this->actions = array(
<?php echo "\t\t\t\$this->Cake->Link(array('title' => __('New {$singularHumanName}'), 'url' => array('action' => 'add'{$additionalParams}))),";?>

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
	} ?>
		);

		parent::build();
	}

}
