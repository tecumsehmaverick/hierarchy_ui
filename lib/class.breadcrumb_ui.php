<?php
	
	class BreadcrumbUI extends XMLElement {
		protected $breadcrumb_id;
		protected $breadcrumb_items;
		
		public function __construct() {
			parent::__construct('div');
			
			$items = new XMLElement('ol');
			$items->setAttribute('class', 'items');
			
			$this->setAttribute('data-breadcrumb', 'yes');
			$this->appendChild($items);
			
			$this->breadcrumb_id = $id;
			$this->breadcrumb_items = $items;
		}
		
		public function appendItem($id, $title) {
			$item = new XMLElement('li');
			$item->setAttribute('class', 'item');
			$item->setAttribute('data-id', $id);
			$item->setValue($title);
			
			$this->breadcrumb_items->appendChild($item);
		}
		
		public function setData($name, $value) {
			$this->setAttribute('data-breadcrumb-' . $name, $value);
		}
	}
	
?>