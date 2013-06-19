<?php
App::uses('BaseView', 'Templates.Lib/Ctk/Default');
abstract class IndexBaseView extends BaseView {

/**
 * Wrapper class value
 *
 * @var string
 */
	protected $_wrapperClass = 'index';

/**
 * Default build for method
 */
	public function build() {
		$wrapper = $this->Html->Div(array('class' => $this->_wrapperClass));
		$this->add($wrapper);
		$wrapper->add($this->Html->H2(array('text' => $this->_pageLabel)));

		$wrapper->add($this->_buildTable());
		$wrapper->add($this->_buildPaginator());
		$this->add($this->_buildActions());
	}

}
