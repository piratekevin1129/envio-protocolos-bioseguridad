<?php

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

class EnvioprotocolosbioseguridadViewDemo extends JViewLegacy{
	function display($tpl = null){
		// Assign data to the view
		$this->msg = 'Hello World';

		// Display the view
		parent::display($tpl);

		$document = JFactory::getDocument();
		$document->setTitle("Demo");
	}
}
