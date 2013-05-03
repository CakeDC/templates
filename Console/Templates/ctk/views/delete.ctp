<?php 
/**
 * Copyright 2005-2013, Cake Development Corporation (http://cakedc.com)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright 2005-2010, Cake Development Corporation (http://cakedc.com)
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
?>
<?php include(dirname(dirname(__FILE__)) . DS .  'common_params.php'); 
echo "<?php\n";
?>
App::uses('FormBaseView', 'Templates.Lib/Ctk/Default');

class DeleteView extends FormBaseView {

	public function build() {
		$this->_wrapperClass = '<?php echo $pluralVar;?> form';
		$this->_modelName = '<?php echo $modelClass;?>';
		$this->_formOptions = array('action' => 'delete', $this-><?php echo $singularVar;?>['<?php echo $modelClass;?>']['id']);
		$this->_title = array(
			$this->Html->P(array('text' => __('Delete User'))),
			$this->Html->P(array('text' => <?php echo "sprintf(__('Delete {$singularHumanName} \"%s\"?'), \$this->{$singularVar}['{$modelClass}']['title'])";?>)),
			$this->Html->P(array('text' => __('Be aware that your <?php echo $singularHumanName;?> and all associated data will be deleted if you confirm!'))),
		);
		$this->_formButtonTitle = __('Continue');

		$this->_fields = array(
			$this->Cake->Input(array(
				'field' => 'confirm', 
				'options' => array(
					'label' => __('Confirm'),
					'type' => 'checkbox',
					'error' => __('You have to confirm.'),
				)
			)),
		);
			
		$this->_actions = array(
<?php echo "\t\t\t\$this->Cake->Link(array('title' => __('List {$pluralHumanName}'), 'url' => array('action' => 'index'{$additionalParams}))),\n";?>
		);

		parent::build();
	}

}
