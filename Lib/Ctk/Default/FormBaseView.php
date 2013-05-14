<?php
App::uses('BaseView', 'Templates.Lib/Ctk/Default');

abstract class FormBaseView extends BaseView {

/**
 * Wrapper class value
 *
 * @var string
 */
	protected $_wrapperClass = 'form';

/**
 * Cake form settings
 *
 * @var array
 */
	protected $_formOptions = array();

/**
 * Field inputs list
 *
 * @var array
 */
	protected $_fields = array();

/**
 * Form submit button title
 *
 * @var string
 */
	protected $_formButtonTitle = null;

/**
 * Default build for method
 */
	public function build() {
		if (empty($this->_formButtonTitle)) {
			$this->_formButtonTitle = __('Submit');
		}
		$wrapper = $this->Html->Div(array('class' => $this->_wrapperClass));
		$this->add($wrapper);
		$wrapper->add($this->_buildForm());
		$this->add($this->_buildActions());
	}

/**
 * Generates form based on field lists
 *
 * @return CakeForm
 */
	protected function _buildForm() {
		$formOptions = Hash::merge(array('model' => $this->_modelName), $this->_formOptions);
		$form = $this->Cake->Form($formOptions);
		$fieldSet = $this->Html->Fieldset();
		$form->add($fieldSet);
		if (is_array($this->_pageLabel)) {
			$legend = $fieldSet->Legend();
			$legend->addMany($this->_pageLabel);
		} else {
			$fieldSet->Legend(array('text' => $this->_pageLabel));
		}

		$fieldSet->addMany($this->_fields);

		$form->add($this->Cake->Submit(array('caption' => $this->_formButtonTitle)));
		return $form;
	}

}
