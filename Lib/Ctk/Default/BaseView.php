<?php
App::uses('CtkView', 'Ctk.View');
/**
 * Class IndexBaseView
 *
 * @property  HtmlFactory  $Html
 * @property  JsFactory  $Js
 * @property  CakeFactory  $Cake
 * @property  BootstrapFactory  $Bootstrap
 */
abstract class BaseView extends CtkView {

/**
 * Factories
 *
 * @var array
 */
	public $factories = array(
		'Ctk.Html',
		'Ctk.Js',
		'CakeFactory.Cake',
		'BootstrapFactory.Bootstrap' => array('assets' => false),
	);

	public $title = '';
	public $modelName = null;

	public $headers = array();

	public $rows = array();

	public $actions = array();

	public function build() {
		$wrapper = $this->Html->Div(array('class' => 'users index'));
		$this->add($wrapper);
		$wrapper->add($this->Html->H2(array('text' => $this->title)));

		$wrapper->add($this->_buildTable());
		$wrapper->add($this->_paging());
		$this->add($this->_buildActions());
	}

/**
 * build table
 */
	protected function _buildTable() {
		$table = $this->Html->Table();
		$head = $this->Html->Thead();
		$body = $this->Html->TBody();
		$table->addMany(array($head, $body));
		$table->add($body);

		$headRow = $this->Html->Tr();
		$head->add($headRow);
		foreach ($this->headers as $header) {
			if ($header instanceof HtmlTh) {
				$headRow->add($header);
			} else {
				$headRow->Th(array('text' => $header));
			}
		}
		foreach ($this->rows as $rowCells) {
			$row = $body->Tr();
			foreach ($rowCells as $cell) {
				if ($cell instanceof HtmlTd) {
					$row->add($cell);
				} elseif (is_array($cell)) {
					$td = $row->Td();
					$td->addMany($cell);
				} else {
					$row->Td(array('text' => $cell));
				}
			}
		}
		return $table;
	}

	protected function _buildActions() {
		$wrapper = $this->Html->Div(array('class' => 'actions'));
		$wrapper->add($this->Html->H3(array('text' => __('Actions'))));
		$list = $wrapper->Ul();
		foreach ($this->actions as $action) {
			$item = $this->Html->Li();
			$list->add($item);
			$item->add($action);
		}
		return $wrapper;
	}

	/**
 * @param array $record
 * @param array $url
 * @param string $title
 *
 * @return CakeLink
 */
	protected function _editLink($record, $url = array(), $title = null) {
		if (empty($title)) {
			$title = __('Edit');
		}
		$defaultUrl = array(
			'action' => 'edit',
			$record[$this->modelName]['id']
		);
		if (empty($url)) {
			$url = Set::merge($defaultUrl, $url);
		}
		return $this->Cake->Link(compact('title', 'url'));
	}

	/**
	 * @param array $record
	 * @param array $url
	 * @param string $title
	 *
	 * @return CakeLink
	 */
	protected function _viewLink($record, $url = array(), $title = null) {
		if (empty($title)) {
			$title = __('View');
		}
		$defaultUrl = array(
			'action' => 'view',
			$record[$this->modelName]['id']
		);
		if (empty($url)) {
			$url = Set::merge($defaultUrl, $url);
		}
		return $this->Cake->Link(compact('title', 'url'));
	}

	/**
 * @param array $record
 * @param array $url
 * @param string $title
 *
 * @return CakeLink
 */
	protected function _deleteLink($record, $url = array(), $title = null) {
		if (empty($title)) {
			$title = __('Delete');
		}
		$defaultUrl = array(
			'action' => 'delete',
			$record[$this->modelName]['id']
		);
		if (empty($url)) {
			$url = Set::merge($defaultUrl, $url);
		}
		return $this->Cake->Link(compact('title', 'url'));
	}

	protected function _paging() {
		$text =
			$this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled')) .
			 $this->Paginator->numbers(array('separator' => ''))  .
			 $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));

		$wrapper = $this->Html->Div(array('class' => 'paging', 'text' => $text));
		return $wrapper;
	}

	protected function _rowActions($record) {
		$actions = $this->Html->Td();
		$actions->addMany(array(
			$this->_editLink($record),
			$this->_viewLink($record),
			$this->_deleteLink($record),
		));
		return $actions;
	}

}
