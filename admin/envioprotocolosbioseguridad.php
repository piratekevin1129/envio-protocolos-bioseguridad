<?php
jimport('joomla.application.component.controller');

$controller = JControllerLegacy::getInstance('envioprotocolosbioseguridad');

// Perform the Request task
$controller->execute(JRequest::getCmd('task'));

// Redirect if set by the controller
$controller->redirect();