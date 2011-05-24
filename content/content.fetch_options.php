<?php
	
	/**
	 * @package breadcrumb_ui
	 */
	
	require_once TOOLKIT . '/class.administrationpage.php';
	
	class ContentExtensionBreadcrumb_UIFetch_Options extends AdministrationPage {
		public function view() {
			$data = json_decode($_GET['data']);
			$options = array();
			
			/**
			* Ask other extensions to provide a list of possible breadcrumb options.
			*
			* @delegate AppendAttachmentHandler
			* @param string $context
			* '/extension/emailbuilder/'
			* @param string $id
			* @param array $options
			*/
			Symphony::ExtensionManager()->notifyMembers(
				'AppendBreadcrumbOptions',
				'/extension/breadcrumb_ui/',
				array(
					'data'		=> $data,
					'options'	=> &$options
				)
			);
			
			header('content-type: text/plain');
			echo json_encode($options); exit;
		}
	}
	
?>