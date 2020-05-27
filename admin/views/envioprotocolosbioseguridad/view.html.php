<?php

defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.view');

	class EnvioprotocolosbioseguridadViewEnvioprotocolosbioseguridad extends JViewLegacy {
		public function display($tpl = null) {
			$base = str_replace('\\','/',JPATH_BASE)."/";
			$base = str_replace('administrator/','',$base);

			$ciudades_url = $base."components/com_envioprotocolosbioseguridad/public/assets/js/municipios.json";
			$ciudades_file = file_get_contents($ciudades_url);
			$this->ciudades_data = json_decode($ciudades_file,true);
			
			$sectores_url = $base."components/com_envioprotocolosbioseguridad/public/assets/js/sectores.json";
			$sectores_file = file_get_contents($sectores_url);
			$this->sectores_data = json_decode($sectores_file,true);

			$db = JFactory::getDBO();
			$query_info = $db->getQuery(true);

			$query_info->select($db->quoteName(array('id','tipo_documento','numero_documento','nombre_comercial','nombre_legal','sector_economico','departamento_residencia','ciudad_residencia','direccion_correspondencia','correo_electronico','numero_telefono')));
			$query_info->from($db->quoteName('#__envioprotocolosbioseguridad'));
			//$query_info->where($db->quoteName('nit_empresa').' = '.$db->quote($nit));
			$db->setQuery($query_info);		
			$this->datos = $db->loadObjectList();
			
			// Agrega la barra de Herramientas
			//$this->addToolBar();
			JHtml::_('jquery.framework');
			parent::display($tpl);

			// Set the document
			$this->setDocument();
		}

		protected function setDocument(){
			$document = JFactory::getDocument();
			$document->setTitle(JText::_('Envio protocolos bioseguridad'));
		}
	}
?>