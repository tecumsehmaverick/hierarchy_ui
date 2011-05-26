<?php
	
	class BreadcrumbUI extends XMLElement {
		protected $breadcrumb_input;
		protected $breadcrumb_items;
		
		public function __construct($name) {
			parent::__construct('div');
			
			$input = new XMLElement('input');
			$input->setAttribute('type', 'hidden');
			$input->setAttribute('name', $name);
			$this->appendChild($input);
			
			$items = new XMLElement('ol');
			$items->setAttribute('class', 'items');
			
			$this->setAttribute('data-breadcrumb', 'yes');
			$this->appendChild($items);
			
			$this->breadcrumb_input = $input;
			$this->breadcrumb_items = $items;
		}
		
		public function appendItem($id, $title) {
			$item = new XMLElement('li');
			$item->setAttribute('class', 'item');
			$item->setAttribute('data-id', $id);
			$item->setValue($title);
			
			$this->breadcrumb_input->setAttribute('value', $id);
			$this->breadcrumb_items->appendChild($item);
		}
		
		public function setData($name, $value) {
			$this->setAttribute('data-breadcrumb-' . $name, $value);
		}
	}
	
?>