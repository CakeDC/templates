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

/**
 * Form or index page label
 *
 * @var string
 */
	protected $_pageLabel = '';

/**
 * Model class name
 *
 * @var string
 */
	protected $_modelName = null;

/**
 * Table headers
 *
 * @var array
 */
	protected $_headers = array();

/**
 * Table rows
 *
 * @var array
 */
	protected $_rows = array();

/**
 * List of action links
 *
 * @var array
 */
	protected $_actions = array();

/**
 * Build table based on headers and rows params
 *
 * @return \HtmlTable
 */
	protected function _buildTable() {
		$table = $this->Html->Table();
		$head = $this->Html->Thead();
		$body = $this->Html->TBody();
		$table->addMany(array($head, $body));
		$table->add($body);

		$headRow = $this->Html->Tr();
		$head->add($headRow);
		foreach ($this->_headers as $header) {
			if ($header instanceof HtmlTh) {
				$headRow->add($header);
			} else {
				$headRow->Th(array('text' => $header));
			}
		}
		foreach ($this->_rows as $rowCells) {
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

/**
 * Generates action links list
 *
 * @return CtkNode
 */
	protected function _buildActions() {
		$wrapper = $this->Html->Div(array('class' => 'actions'));
		$wrapper->add($this->Html->H3(array('text' => __('Actions'))));
		$list = $wrapper->Ul();
		foreach ($this->_actions as $action) {
			$item = $this->Html->Li();
			$list->add($item);
			$item->add($action);
		}
		return $wrapper;
	}

/**
 * Generate edit link
 *
 * @param array $record
 * @param array $url
 * @param string $title
 * @return CakeLink
 */
	protected function _buildEditLink($record, $url = array(), $title = null) {
		if (empty($title)) {
			$title = __('Edit');
		}
		$defaultUrl = array(
			'action' => 'edit',
			$record[$this->_modelName]['id']
		);
		if (empty($url)) {
			$url = Set::merge($defaultUrl, $url);
		}
		return $this->Cake->Link(compact('title', 'url'));
	}

/**
 * Generate view link
 *
 * @param array $record
 * @param array $url
 * @param string $title
 * @return CakeLink
 */
	protected function _buildViewLink($record, $url = array(), $title = null) {
		if (empty($title)) {
			$title = __('View');
		}
		$defaultUrl = array(
			'action' => 'view',
			$record[$this->_modelName]['id']
		);
		if (empty($url)) {
			$url = Set::merge($defaultUrl, $url);
		}
		return $this->Cake->Link(compact('title', 'url'));
	}

/**
 * Generate delete link
 *
 * @param array $record
 * @param array $url
 * @param string $title
 * @return CakeLink
 */
	protected function _buildDeleteLink($record, $url = array(), $title = null) {
		if (empty($title)) {
			$title = __('Delete');
		}
		$defaultUrl = array(
			'action' => 'delete',
			$record[$this->_modelName]['id']
		);
		if (empty($url)) {
			$url = Set::merge($defaultUrl, $url);
		}
		return $this->Cake->Link(compact('title', 'url'));
	}

/**
 * Build paginator
 *
 * @return CtkNode
 */
	protected function _buildPaginator() {
		$text =
			$this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled')) .
			 $this->Paginator->numbers(array('separator' => ''))  .
			 $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));

		$wrapper = $this->Html->Div(array('class' => 'paging', 'text' => $text));
		return $wrapper;
	}

/**
 * Build default row action
 *
 * @param $record
 * @return HtmlTd
 */
	protected function _buildRowActions($record) {
		$actions = $this->Html->Td();
		$actions->addMany(array(
			$this->_buildEditLink($record),
			$this->_buildViewLink($record),
			$this->_buildDeleteLink($record),
		));
		return $actions;
	}

}
