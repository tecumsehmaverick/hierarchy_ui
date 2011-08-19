<?php

	/**
	 * @package hierarchy_ui
	 */

	require_once TOOLKIT . '/class.administrationpage.php';

	class ContentExtensionHierarchy_UIFetch_Breadcrumb_Options extends AdministrationPage {
		public function view() {
			header('content-type: text/json');

			$options = array();

			/**
			* Ask other extensions to provide a list of possible breadcrumb ui options.
			*
			* @delegate AppendBreadcrumbOptions
			* @param string $context
			* '/extension/hierarchy_ui/'
			* @param string $id
			* @param array $options
			*/
			Symphony::ExtensionManager()->notifyMembers(
				'AppendBreadcrumbOptions',
				'/extension/hierarchy_ui/',
				array(
					'data'		=> $_REQUEST,
					'options'	=> &$options
				)
			);

			echo json_encode($options); exit;
		}
	}

?>