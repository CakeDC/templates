<?php
App::uses('BaseView', 'Templates.Lib/Ctk/Default');

abstract class FormBaseView extends BaseView {

	public $wrapperClass = 'form';
	public $formOptions = array();
	public $fields = array();
	public $formButtonTitle = null;

	public function build() {
		if (empty($this->formButtonTitle)) {
			$this->formButtonTitle = __('Submit');
		}
		$wrapper = $this->Html->Div(array('class' => $this->wrapperClass));
		$this->add($wrapper);
		$wrapper->add($this->_buildForm());
		$this->add($this->_buildActions());
	}

	protected function _buildForm() {
		$formOptions = Hash::merge(array('model' => $this->modelName), $this->formOptions);
		$form = $this->Cake->Form($formOptions);
		$fieldSet = $this->Html->Fieldset();
		$form->add($fieldSet);
		if (is_array($this->title)) {
			$legend = $fieldSet->Legend();
			$legend->addMany($this->title);
		} else {
			$fieldSet->Legend(array('text' => $this->title));
		}

		$fieldSet->addMany($this->fields);

		$form->add($this->Cake->Submit(array('caption' => $this->formButtonTitle)));
		return $form;
	}

}
