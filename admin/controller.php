<?php

defined('_JEXEC') or die;

jimport('joomla.application.component.controller');

class EnvioprotocolosbioseguridadController extends JControllerLegacy{

	function display($cachable = false, $urlparams = false){
		// set default view if not set
		JRequest::setVar('view', JRequest::getCmd('view', 'envioprotocolosbioseguridad'));
		// call parent behavior
		parent::display($cachable);
		return $this;
	}

}