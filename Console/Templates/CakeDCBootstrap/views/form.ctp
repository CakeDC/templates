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
?>
<?php include(dirname(dirname(__FILE__)) . DS .  'common_params.php'); ?>
<div class="row-fluid <?php echo $pluralVar;?>-form">
	<div class="span9"> 
<?php if (in_array($action, array('add', 'admin_add'))): ?>
<?php echo "<?php echo \$this->Form->create('{$modelClass}', array('url' => array('action' => 'add'{$additionalParams})));?>\n";?>
<?php elseif (in_array($action, array('edit', 'admin_edit'))): ?>
<?php echo "<?php echo \$this->Form->create('{$modelClass}', array('url' => array('action' => 'edit')));?>\n";?>
<?php endif;?>
		<fieldset>
			<legend><?php echo "<?php echo __('" . Inflector::humanize($action) . " {$singularHumanName}');?>";?></legend>
<?php
		echo "\t<?php\n";
		foreach ($fields as $field) {
			if (in_array($action, array('add', 'admin_add')) && $field == $primaryKey) {
				continue;
			} elseif (!in_array($field, array('created', 'modified', 'updated'))) {
				if (!$parentIncluded || $parentIncluded && $field != $parentIdDbVar) {
					echo "\t\t\techo \$this->Form->input('{$field}');\n";
				}
			}
		}
		if (!empty($associations['hasAndBelongsToMany'])) {
			foreach ($associations['hasAndBelongsToMany'] as $assocName => $assocData) {
				echo "\t\t\techo \$this->Form->input('{$assocName}');\n";
			}
		}
		echo "\t\t?>\n";
?>
		</fieldset>
<?php
	echo "<?php echo \$this->Form->end('Submit');?>\n";
	$idKeyPK = $idKey = "\$this->Form->value('{$modelClass}.{$primaryKey}')";
	if ($slugged) {
		$idKey = "\$this->Form->value('{$modelClass}.slug')";
	}
?>
	</div>
	<div class="span3">
		<div class="well" style="padding: 8px 0; margin-top:8px;">
			<ul class="nav nav-list">
				<li class="nav-header"><?php echo "<?php echo __('Actions'); ?>"; ?></li>
<?php if (!in_array($action, array('add', 'admin_add'))):?>
				<li><?php echo "<?php echo \$this->Html->link(__('Delete'), array('action' => 'delete', {$idKeyPK})); ?>";?></li>
<?php endif;?>
				<li><?php echo "<?php echo \$this->Html->link(__('List {$pluralHumanName}'), array('action' => 'index'{$additionalParams}));?>";?></li>
<?php
		$done = array();
		foreach ($associations as $type => $data) {
			foreach ($data as $alias => $details) {
				if ($details['controller'] != $this->name && !in_array($details['controller'], $done)) {
					echo "\t\t<li><?php echo \$this->Html->link(__('List " . Inflector::humanize($details['controller']) . "'), array('controller' => '{$details['controller']}', 'action' => 'index')); ?> </li>\n";
					echo "\t\t<li><?php echo \$this->Html->link(__('New " . Inflector::humanize(Inflector::underscore($alias)) . "'), array('controller' => '{$details['controller']}', 'action' => 'add')); ?> </li>\n";
					$done[] = $details['controller'];
				}
			}
		}
?>
			</ul>
		</div>
	</div>
</div>