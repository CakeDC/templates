<?php
App::uses('BaseView', 'Templates.Lib/Ctk/Default');
abstract class IndexBaseView extends BaseView {

	public $wrapperClass = 'index';

	public function build() {
		$wrapper = $this->Html->Div(array('class' => $this->wrapperClass));
		$this->add($wrapper);
		$wrapper->add($this->Html->H2(array('text' => $this->title)));

		$wrapper->add($this->_buildTable());
		$wrapper->add($this->_paging());
		$this->add($this->_buildActions());
	}

	protected function _paging() {
		$text =
			$this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled')) .
			 $this->Paginator->numbers(array('separator' => ''))  .
			 $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));

		$wrapper = $this->Html->Div(array('class' => 'paging', 'text' => $text));
		return $wrapper;
	}

}
