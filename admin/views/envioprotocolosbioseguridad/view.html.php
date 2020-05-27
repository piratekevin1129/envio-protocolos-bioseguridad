<?php

defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.view');

	class EnvioprotocolosbioseguridadViewEnvioprotocolosbioseguridad extends JViewLegacy {
		public function display($tpl = null) {
			/*$base = str_replace('\\','/',JPATH_BASE)."/";
			$base = str_replace('administrator/','',$base);
			$ciudades_url = $base."components/com_envioprotocolosbioseguridad/public/assets/js/municipios.json";
			$file = file_get_contents($ciudades_url);
			$this->ciudades_data = json_decode($file,true);
			$this->areas = array('','Salud y asistencia social','Educación en las áreas de la salud','Otras áreas');

			$db = JFactory::getDBO();
			$query_info = $db->getQuery(true);

			$query_info->select($db->quoteName(array('id','nombres_apellidos','tipo_documento','numero_documento','numero_telefono','ocupacion','ciudad_residencia','direccion_correspondencia','correo_electronico','fecha_registro','departamento_residencia','area_prestacion','area_prestacion_txt','pregunta1','pregunta2','pregunta3','pregunta4','pregunta5','pregunta6','pregunta7','ipadress')));
			$query_info->from($db->quoteName('#__envioprotocolosbioseguridad'));
			//$query_info->where($db->quoteName('nit_empresa').' = '.$db->quote($nit));
			$db->setQuery($query_info);		
			$this->datos = $db->loadObjectList();
			
			// Agrega la barra de Herramientas
			//$this->addToolBar();
			JHtml::_('jquery.framework');
			parent::display($tpl);

			// Set the document
			$this->setDocument();*/
		}

		protected function setDocument(){
			$document = JFactory::getDocument();
			$document->setTitle(JText::_('Envio protocolos bioseguridad'));
		}
	}
?>