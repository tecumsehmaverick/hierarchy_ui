<?php
	
	/**
	 * @package breadcrumb_ui
	 */
	
	/**
	 * Breadcrumb editing user interface.
	 */
	class Extension_Breadcrumb_UI extends Extension {
		protected $appendedHeaders = false;
		
		/**
		 * Extension information.
		 */
		public function about() {
			return array(
				'name'			=> 'Breadcrumb UI',
				'version'		=> '0.3',
				'release-date'	=> '2011-06-09',
				'author'		=> array(
					'name'			=> 'Rowan Lewis',
					'website'		=> 'http://rowanlewis.com/',
					'email'			=> 'me@rowanlewis.com'
				)
			);
		}
		
		/**
		 * Listen for these delegates.
		 */
		public function getSubscribedDelegates() {
			return array(
				array(
					'page' => '/backend/',
					'delegate' => 'AdminPagePreGenerate',
					'callback' => 'appendHeaders'
				)
			);
		}
		
		/**
		 * Add stylesheets and scripts to page header.
		 */
		public function appendHeaders() {
			$page = Symphony::Engine()->Page;

			if (!$this->appendedHeaders && $page instanceof AdministrationPage) {
				$page = Symphony::Engine()->Page;
				$page->addStylesheetToHead(URL . '/extensions/breadcrumb_ui/assets/ui.css');
				$page->addScriptToHead(URL . '/extensions/breadcrumb_ui/assets/ui.js');
			}
		}
	}
	
?>