<?php

	/**
	 * @package hierarchy_ui
	 */

	require_once EXTENSIONS . '/hierarchy_ui/lib/class.breadcrumb_ui.php';
	require_once EXTENSIONS . '/hierarchy_ui/lib/class.tree_ui.php';

	/**
	 * Hierarchy editing user interface.
	 */
	class Extension_Hierarchy_UI extends Extension {
		protected $breadcrumbEnabled = false;
		protected $treeEnabled = false;

		/**
		 * Extension information.
		 */
		public function about() {
			return array(
				'name'			=> 'UI: Hierarchy',
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
					'page'		=> '/backend/',
					'delegate'	=> 'AdminPagePreGenerate',
					'callback'	=> 'appendHeaders'
				)
			);
		}

		/**
		 * Add stylesheets and scripts to page header.
		 */
		public function appendHeaders() {
			$page = Symphony::Engine()->Page;

			if ($page instanceof AdministrationPage === false) return;

			if ($this->breadcrumbEnabled) {
				$page->addStylesheetToHead(URL . '/extensions/hierarchy_ui/assets/breadcrumb_ui.css');
				$page->addScriptToHead(URL . '/extensions/hierarchy_ui/assets/breadcrumb_ui.js');
				$this->breadcrumbEnabled = false;
			}

			if ($this->treeEnabled) {
				$page->addStylesheetToHead(URL . '/extensions/hierarchy_ui/assets/tree_ui.css');
				$page->addScriptToHead(URL . '/extensions/hierarchy_ui/assets/tree_ui.js');
				$this->treeEnabled = false;
			}
		}

		/**
		 * Append Breadcrumb UI stylesheet and scripts.
		 */
		public function appendBreadcrumbUIHeaders() {
			$this->breadcrumbEnabled = true;
		}

		/**
		 * Append Tree UI stylesheet and script.
		 */
		public function appendTreeUIHeaders() {
			$this->treeEnabled = true;
		}
	}

?>