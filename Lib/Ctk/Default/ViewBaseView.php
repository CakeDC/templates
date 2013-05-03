<?php
App::uses('BaseView', 'Templates.Lib/Ctk/Default');
abstract class ViewBaseView extends BaseView {

	public $wrapperClass = 'view';
	public $formOptions = array();
	public $fields = array();

	public function build() {
		$wrapper = $this->Html->Div(array('class' => $this->wrapperClass));
		$this->add($wrapper);
		$wrapper->add($this->_buildFields());
		$this->add($this->_buildActions());
	}
	
	protected function _buildFields() {
		$wrapper = $this->Html->Dl();
		foreach ($this->fields as $field) {
			$wrapper->addMany(array(
				$this->Html->Dt(array('text' => $field['label'])),
				$this->Html->Dd(array('text' => $field['value']))
			));
		}
		return $wrapper;
	}

}
