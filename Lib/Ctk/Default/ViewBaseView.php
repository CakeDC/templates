<?php
App::uses('BaseView', 'Templates.Lib/Ctk/Default');
abstract class ViewBaseView extends BaseView {

/**
 * Wrapper class value
 *
 * @var string
 */
	protected $_wrapperClass = 'view';

/**
 * Field inputs list
 *
 * @var array
 */
	protected $_fields = array();

/**
 * Default build for method
 */
	public function build() {
		$wrapper = $this->Html->Div(array('class' => $this->_wrapperClass));
		$this->add($wrapper);
		$wrapper->add($this->_buildFields());
		$this->add($this->_buildActions());
	}
	
	protected function _buildFields() {
		$wrapper = $this->Html->Dl();
		foreach ($this->_fields as $field) {
			$wrapper->addMany(array(
				$this->Html->Dt(array('text' => $field['label'])),
				$this->Html->Dd(array('text' => $field['value']))
			));
		}
		return $wrapper;
	}

}
