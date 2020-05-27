<?php
defined('_JEXEC') or die('Restricted access');

class EnvioprotocolosbioseguridadController extends JControllerLegacy{

	function display($cachable=false,$urlparams=false){
		$app = JFactory::getApplication();
		
		parent::display();
	}
	    
	function guardarDatos(){
		$app = JFactory::getApplication();
				
        $nombre_legal_txt = checkComillas(JRequest::getVar('nombre_legal_txt','','post'));
        $nombre_comercial_txt = checkComillas(JRequest::getVar('nombre_comercial_txt','','post'));
        $numero_documento_txt = checkComillas(JRequest::getVar('numero_documento_txt','','post'));
        $tipo_documento_txt = checkComillas(JRequest::getVar('tipo_documento_txt','','post'));
        
		$sector_txt = checkComillas(JRequest::getVar('sector_txt','','post'));
		$departamento_residencia_txt = checkComillas(JRequest::getVar('departamento_residencia_txt','','post'));
        $ciudad_residencia_txt = checkComillas(JRequest::getVar('ciudad_residencia_txt','','post'));
        $direccion_txt = checkComillas(JRequest::getVar('direccion_txt','','post'));
        $correo_electronico_txt = checkComillas(JRequest::getVar('correo_electronico_txt','','post'));
		$numero_telefonico_txt = checkComillas(JRequest::getVar('numero_telefonico_txt','','post'));
		
        $db = JFactory::getDBO();
        $query_inserta = $db->getQuery(true);
        
        $columns = array('tipo_documento','numero_documento','nombre_comercial','nombre_legal','sector_economico','departamento_residencia','ciudad_residencia','direccion_correspondencia','correo_electronico','numero_telefono');
        $values = array(
                        $db->quote($tipo_documento_txt),
                        $db->quote($numero_documento_txt),
                        $db->quote($nombre_comercial_txt),
                        $db->quote($nombre_legal_txt),
                        $db->quote($sector_txt),
                        $db->quote($departamento_residencia_txt),
                        $db->quote($ciudad_residencia_txt),
                        $db->quote($direccion_txt),
						$db->quote($correo_electronico_txt),
						$db->quote($numero_telefonico_txt)
                        );
        $query_inserta->insert($db->quoteName('#__envioprotocolosbioseguridad'))
                        ->columns($db->quoteName($columns))
                        ->values(implode(',',$values));
        $db->setQuery($query_inserta);
        $db->execute();
        
		//$last_id = $db->insertid();
        exit("success");
  	}

  	function saveFile(){
  		$base = str_replace('\\','/',JPATH_BASE)."/";
		$files_path = $base."components/com_envioprotocolosbioseguridad/public/storage";

  		$numero_documento_txt = checkComillas(JRequest::getVar('nd','','post'));
        $tipo_documento_txt = checkComillas(JRequest::getVar('td','','post'));

        if($_FILES){
        	if($_FILES['archivo_txt']){
        		if($_FILES['archivo_txt']['name']){
        			if(
        				$_FILES['archivo_txt']['type']=='image/jpg'||
        				$_FILES['archivo_txt']['type']=='image/jpeg'||
        				$_FILES['archivo_txt']['type']=='image/png'||

        				$_FILES['archivo_txt']['type']=='application/pdf'||
        				$_FILES['archivo_txt']['type']=='application/vnd.openxmlformats-officedocument.wordprocessingml.document'||
        				$_FILES['archivo_txt']['type']=='application/msword'||
        				$_FILES['archivo_txt']['type']=='application/vnd.ms-excel'||
        				$_FILES['archivo_txt']['type']=='application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'||
        				$_FILES['archivo_txt']['type']=='application/vnd.ms-powerpoint'||
        				$_FILES['archivo_txt']['type']=='application/vnd.openxmlformats-officedocument.presentationml.presentation'||
        				$_FILES['archivo_txt']['type']=='application/zip'
        			){
        				if($_FILES['archivo_txt']['size']<2000000){
        					$info = pathinfo($_FILES['archivo_txt']['name']);
							$ext = $info['extension']; // get the extension of the file
							$newname = getNameAlias($info['filename']);
							
							$folder = $tipo_documento_txt.$numero_documento_txt;
							$path = $files_path."/".$folder."/".$newname.".".$ext;

							if(!file_exists($files_path."/".$folder)){
								if(mkdir($files_path."/".$folder)){
									if(chmod($files_path."/".$folder,775)){
										if(move_uploaded_file( $_FILES['archivo_txt']['tmp_name'], $path)){

											//enviar correo
			
											exit('{"success":"success","msg":"'.$newname.".".$ext.'"}');
										}else{
											exit('{"success":"error","msg":"Error guardando el archivo"}');
										}
									}else{
										exit('{"success":"error","msg":"Error modificando la carpeta"}');
									}
								}else{
									exit('{"success":"error","msg":"Error creando la carpeta"}');
								}
							}else{
								if(move_uploaded_file( $_FILES['archivo_txt']['tmp_name'], $path)){

									//enviar correo
	
									exit('{"success":"success","msg":"'.$newname.".".$ext.'"}');
								}else{
									exit('{"success":"error","msg":"Error guardando el archivo en una carpeta ya creada"}');
								}
							}
							
        				}else{
        					exit('{"success":"error","msg":"El archivo sobrepasar el límite de peso permitido (2M)"}');
        				}
        			}else{
        				exit('{"success":"error","msg":"El formato del archivo no es válido"}');
        			}
        		}else{
        			exit('{"success":"error","msg":"Error con el nombre del archivo"}');
        		}
        	}else{
        		exit('{"success":"error","msg":"No se encontró el archivo"}');
        	}
        }else{
        	exit('{"success":"error","msg":"No se adjuntó ningún archivo"}');
        }
  	}

  	function sendMail(){
  		$base = str_replace('\\','/',JPATH_BASE)."/";
  		$sectores_url = $base."components/com_envioprotocolosbioseguridad/public/assets/js/sectores.json";
		$sectores_file = file_get_contents($sectores_url);
		$sectores_data = json_decode($sectores_file,true);

		$ciudades_url = $base."components/com_envioprotocolosbioseguridad/public/assets/js/municipios.json";
		$ciudades_file = file_get_contents($ciudades_url);
		$ciudades_data = json_decode($ciudades_file,true);

		$nombre_legal_txt = checkComillas(JRequest::getVar('nombre_legal_txt','','post'));
        $nombre_comercial_txt = checkComillas(JRequest::getVar('nombre_comercial_txt','','post'));
        $numero_documento_txt = checkComillas(JRequest::getVar('numero_documento_txt','','post'));
        $tipo_documento_txt = checkComillas(JRequest::getVar('tipo_documento_txt','','post'));
        
		$sector_txt = checkComillas(JRequest::getVar('sector_txt','','post'));
		$departamento_residencia_txt = checkComillas(JRequest::getVar('departamento_residencia_txt','','post'));
        $ciudad_residencia_txt = checkComillas(JRequest::getVar('ciudad_residencia_txt','','post'));
        $direccion_txt = checkComillas(JRequest::getVar('direccion_txt','','post'));
        $correo_electronico_txt = checkComillas(JRequest::getVar('correo_electronico_txt','','post'));
		$numero_telefonico_txt = checkComillas(JRequest::getVar('numero_telefonico_txt','','post'));
		$newname = checkComillas(JRequest::getVar('nombre_txt','','post'));

		$from = 'jsanchezy@sura.com.co';
		$to = 'desarrollo3@virtualcolors.com';
		$departamento_name = $ciudades_data[$departamento_residencia_txt-1]['departamento'];
		$ciudad_name = $ciudades_data[$departamento_residencia_txt-1]['municipios'][$ciudad_residencia_txt-1]['municipio'];

		$files_path = $base."components/com_envioprotocolosbioseguridad/public/storage";
		$folder = $tipo_documento_txt.$numero_documento_txt;
		
		$path = $files_path."/".$folder."/".$newname;

		# Invocar JMail Class
		$mailer = JFactory::getMailer();

		# Seteamos quien envia el correo junto el nombre
		$mailer->setSender($from);

		# Añadimos el que recibe el correo
		$mailer->addRecipient($to);

		# Mandamos como HTML
		$mailer->isHTML(true);

		$mailer->Encoding = 'base64';

		$body = '';
		$body.='
		<style type="text/css">
		h1,p{
			font-family: Arial;
			font-size: 16px;
			color: #111111;
			text-align:left;
		}
		</style>
		<h1>Envío de Protocolos generales de Bioseguridad a la ARLSURA</h1>
		<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus</p>
		<br />
		<p><b>Nombre Legal: </b>'.$nombre_legal_txt.'</p>
		<p><b>Nombre Comercial: </b>'.$nombre_comercial_txt.'</p>
		<p><b>NIT: </b>'.$tipo_documento_txt.".".$numero_documento_txt.'</p>
		<p><b>Sector: </b>'.$sectores_data[$sector_txt].'</p>
		<p><b>Departamento: </b>'.$departamento_name.'</p>
		<p><b>Municipio: </b>'.$ciudad_name.'</p>
		<p><b>Dirección: </b>'.$direccion_txt.'</p>
		<p><b>E-mail: </b>'.$correo_electronico_txt.'</p>
		<p><b>Número telefónico: </b>'.$numero_telefonico_txt.'</p>';

		//$subject = "Solicitudes EPS - ".ucwords($_POST['numero_identificacion']);
		//NUEVO SUBJECT
		$subject = "Envio protocolos bioseguridad ".$tipo_documento_txt.$numero_documento_txt;
		$mailer->setSubject($subject);
		$mailer->setBody($body);

		# Añadimos el documento como archivo adjunto
		$mailer->addAttachment($path);

		#Eviamos el correo
		$mailer->Send();
		exit("success");
  	}
  
  	function generarReporte(){
		$base = str_replace('\\','/',JPATH_BASE)."/";
		$ciudades_url = $base."components/com_envioprotocolosbioseguridad/public/assets/js/municipios.json";
		$file = file_get_contents($ciudades_url);
		$ciudades_data = json_decode($file,true);
		
		$db = JFactory::getDBO();
		$query_info = $db->getQuery(true);

		$query_info->select($db->quoteName(array('id','tipo_documento','numero_documento','nombre_comercial','nombre_legal','sector_economico','departamento_residencia','ciudad_residencia','direccion_correspondencia','correo_electronico','numero_telefono')));
		$query_info->from($db->quoteName('#__envioprotocolosbioseguridad'));
		//$query_info->where($db->quoteName('nit_empresa').' = '.$db->quote($nit));
		$db->setQuery($query_info);		
		$datos = $db->loadObjectList();
		/////////////////////////////////////

		$tab_text = '<html xmlns:x="urn:schemas-microsoft-com:office:excel">';
		$tab_text.='<head><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet>';
		$tab_text.='<x:Name>Inventario de tareas</x:Name>';
		$tab_text.='<x:WorksheetOptions><x:Panes></x:Panes></x:WorksheetOptions></x:ExcelWorksheet>';
		$tab_text.='</x:ExcelWorksheets></x:ExcelWorkbook></xml></head><body>';
			
		$html_table = $tab_text;
		$html_table.='
		<table border="1">
			<tr>
				<td> 
					<table border="1">
						<tr>
							'.renderTableSubtitulo("Envio protocolos bioseguridad").'
						</tr>
						<tr>
							<td>
								<table border="1">
									<tr>';
										$html_table.=renderTablePregunta("Id");
										$html_table.=renderTablePregunta("Nombre Legal");
										$html_table.=renderTablePregunta("Nombre Comercial");
										$html_table.=renderTablePregunta("Documento");
										$html_table.=renderTablePregunta("Sector");
										$html_table.=renderTablePregunta("Departamento");
										$html_table.=renderTablePregunta("Ciudad");
										$html_table.=renderTablePregunta("Email");
										$html_table.=renderTablePregunta("Domicilio");
										$html_table.=renderTablePregunta("Teléfono Celular");
										$html_table.=renderTablePregunta("Fecha registro");
									$html_table.='</tr>';
									
									foreach($datos as $dato){
										$html_table.='<tr>';
										$html_table.=renderTableTexto($dato->id);
										$html_table.=renderTableTexto($dato->nombre_legal);
										$html_table.=renderTableTexto($dato->nombre_comercial);
										$html_table.=renderTableTexto($dato->tipo_documento.'.'.$dato->numero_documento);
										$html_table.=renderTableTexto($dato->sector_economico);

										$departamento_name = $ciudades_data[$dato->departamento_residencia-1]['departamento'];
										$html_table.=renderTableTexto($departamento_name);
										$ciudad_name = $ciudades_data[$dato->departamento_residencia-1]['municipios'][$dato->ciudad_residencia-1]['municipio'];
										$html_table.=renderTableTexto($ciudad_name);

										$html_table.=renderTableTexto($dato->correo_electronico,false);
										$html_table.=renderTableTexto($dato->direccion_correspondencia);
										$html_table.=renderTableTexto($dato->numero_telefono);
										$html_table.=renderTableTexto($dato->fecha_registro);
										$html_table.='</tr>';
									}
								$html_table.='</table>';
							$html_table.='</td>';
						$html_table.='</tr>';
					$html_table.='</table>';
				$html_table.='</td>';
			$html_table.='</tr>';
		$html_table.='</table>';

		$html_table.='</body></html>';

		ob_end_clean();
		JResponse::clearHeaders();
		JResponse::setHeader('Content-type', 'application/vnd.ms-excel', true);
		JResponse::setHeader('Content-Disposition', 'attachment; filename=reporte_envio_protocolos_bioseguridad'.$nit.'.xls', true);
		JResponse::setHeader('Pragma', 'no-cache', true);
		JResponse::setHeader('Expires', '0', true);
		JResponse::sendHeaders();

		/*ob_end_clean();
		JResponse::clearHeaders();
		JResponse::setHeader('Content-type', 'text/html; charset=utf-8', true);
		JResponse::setHeader('Content-type', 'text/html', true);
		JResponse::sendHeaders();*/
		
		exit($html_table);
	}
}
	
function checkComillas($cadeneta){
	$cadena_nueva = str_replace("$","",$cadeneta);
	$cadena_nueva = str_replace("%","",$cadena_nueva);
	$cadena_nueva = str_replace("\\","/",$cadena_nueva);
	$cadena_nueva = str_replace("'","",$cadena_nueva);
	$cadena_nueva = str_replace('"',"",$cadena_nueva);
	$cadena_nueva = str_replace('<',"",$cadena_nueva);
	$cadena_nueva = str_replace('>',"",$cadena_nueva);
		
	return strip_tags($cadena_nueva);
}

function getNameAlias($name){
	$new_name = str_replace("á","a",$name);
	$new_name = str_replace("é","e",$new_name);
	$new_name = str_replace("í","i",$new_name);
	$new_name = str_replace("ó","o",$new_name);
	$new_name = str_replace("ú","u",$new_name);
	$new_name = str_replace("ñ","n",$new_name);
	$new_name = str_replace("Á","A",$new_name);
	$new_name = str_replace("É","E",$new_name);
	$new_name = str_replace("Í","I",$new_name);
	$new_name = str_replace("Ó","O",$new_name);
	$new_name = str_replace("Ú","U",$new_name);
	$new_name = str_replace("Ñ","N",$new_name);
	$new_name = str_replace(" ","_",$new_name);
	$new_name = strtolower($new_name);
	return $new_name;
}

?>