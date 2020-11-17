<?php
defined('_JEXEC') or die('Restricted access');

class EnvioprotocolosbioseguridadController extends JControllerLegacy{

	function display($cachable=false,$urlparams=false){
		$app = JFactory::getApplication();
		
		parent::display();
	}
	
	function guardarArchivo(){
		$numero_documento_txt = checkComillas(JRequest::getVar('nd','','post'));
        $tipo_documento_txt = checkComillas(JRequest::getVar('td','','post'));
        //$numero_documento_txt = '123456789';
        //$tipo_documento_txt = 'N';

        $validacion_archivo = validarArchivo($_FILES);
        if($validacion_archivo['success']=='success'){
			$info = pathinfo($_FILES['archivo_txt']['name']);
			$ext = $info['extension']; // get the extension of the file
			$newname = getNameAlias($info['filename']);
			$prefix = $tipo_documento_txt.$numero_documento_txt.'-';
			
			$unique_id = md5(uniqid($prefix.$newname)).'.'.$ext;

			//servicio PUT
			//API URL
			$url = 'https://storageprotocolosbioarl.blob.core.windows.net/protocolos/'.$unique_id.'?sv=2019-10-10&ss=b&srt=co&sp=wc&se=2024-01-01T09:29:09Z&st=2020-06-04T01:29:09Z&spr=https,http&sig=Eq0YF9%2FzLUmjRqjlNPUWmcAk8evTQzcJbCIV9Mv2UfY%3D';

			$ch = curl_init($url);

			$tmpfile = $_FILES['archivo_txt']['tmp_name'];
			$data = array(
			    'file' => '@'.$tmpfile.';filename='.$unique_id,
			);
			
			$headers = array(
				'Content-Type: '.$_FILES['archivo_txt']['type'],
				'x-ms-blob-type: BlockBlob'
				//'x-ms-blob-content-disposition : attachment; filename="'.$unique_id.'"'
			);

			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
			curl_setopt($ch, CURLOPT_POSTFIELDS, file_get_contents($tmpfile));
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			
			$result = curl_exec($ch);
			$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			curl_close($ch);

			//echo $httpcode.'<br />'.$unique_id;
			//$_FILES['archivo_txt']['tmp_name']
			exit('{"success":"success","msg":"'.$unique_id.'","code":"'.$httpcode.'"}');
			
        }else{
        	exit('{"success":"error","msg":"'.$validacion_archivo['msg'].'"}');
        }
	}

	function guardarArchivoFake(){
        $validacion_archivo = validarArchivo($_FILES);

        exit(print_r($validacion_archivo));
	}

	function guardarDatos(){
		$app = JFactory::getApplication();
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

		$departamento_name = $ciudades_data[$departamento_residencia_txt-1]['departamento'];
		$ciudad_name = $ciudades_data[$departamento_residencia_txt-1]['municipios'][$ciudad_residencia_txt-1]['municipio'];

		$secretkey = '6Lf7QAETAAAAAH1jj-pXZPuOAjFmcKfTuvCg7oI5';
		$recaptcha = JRequest::getVar('g_recaptcha_response','','post');
		
		if(!empty($recaptcha)){	
			$google_url="https://www.google.com/recaptcha/api/siteverify";
			$secret='6Lf7QAETAAAAAH1jj-pXZPuOAjFmcKfTuvCg7oI5';
			$ip=$_SERVER['REMOTE_ADDR'];
			$url=$google_url."?secret=".$secret."&response=".$recaptcha."&remoteip=".$ip;
			
			$curl = curl_init();
			curl_setopt($curl, CURLOPT_URL, $url);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($curl, CURLOPT_TIMEOUT, 10);
			curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.9.2.16) Gecko/20110319 Firefox/3.6.16");
			$curlData = curl_exec($curl);
			curl_close($curl);
			
			$res= json_decode($curlData, true);
			
			if($res['success']){
				$db = JFactory::getDBO();
		        $query_inserta = $db->getQuery(true);
		        
		        $columns = array('tipo_documento','numero_documento','nombre_comercial','nombre_legal','sector_economico','departamento_residencia','ciudad_residencia','direccion_correspondencia','correo_electronico','numero_telefono','archivo');
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
								$db->quote($numero_telefonico_txt),
								$db->quote($newname)
		                        );
		        $query_inserta->insert($db->quoteName('#__envioprotocolosbioseguridad'))
		                        ->columns($db->quoteName($columns))
		                        ->values(implode(',',$values));
		        $db->setQuery($query_inserta);
		        $db->execute();
				//$last_id = $db->insertid();

				//API URL
				$url = 'https://prod-25.eastus.logic.azure.com:443/workflows/f3fff22925d94e01a2a99f25bf69985b/triggers/manual/paths/invoke?api-version=2016-10-01&sp=%2Ftriggers%2Fmanual%2Frun&sv=1.0&sig=hZJpFDfKQ0pv7_1bFU7TL6w4akm5e0J2h3GKF8KZeUI';
				$ch = curl_init($url);

				//setup request to send json via POST
				$data = array(
					'tipoDoc'=>$tipo_documento_txt,
					'numeroDoc'=>$numero_documento_txt,
					'nombreEmpresa'=>$nombre_comercial_txt,
					'nombreLegalEmpresa'=>$nombre_legal_txt,
					'sector'=>$sectores_data[$sector_txt],
					'departamento'=>$departamento_name,
					'municipio'=>$ciudad_name,
					'direccion'=>$direccion_txt,
					'correo'=>$correo_electronico_txt,
					'celular'=>$numero_telefonico_txt,
					'archivo'=>$newname
				);
				
				$payload = json_encode($data);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
				curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
				curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:text/plain'));
				
				$result = curl_exec($ch);
				$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
				curl_close($ch);
				
				if($httpcode==202||$httpcode==200){
					exit("success");
				}else{
					exit(print_r($result));
				}
			}else{
				exit("captcha incorrecto");
			}
		}else{
			exit("captcha inválido");
		}
  	}
  
  	//genera reporte en el administrador
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

function validarArchivo($file){
    if($file){
    	if($file['archivo_txt']){
    		if($file['archivo_txt']['name']){
    			if(
    				$file['archivo_txt']['type']=='image/jpg'||
    				$file['archivo_txt']['type']=='image/jpeg'||
    				$file['archivo_txt']['type']=='image/png'||

    				$file['archivo_txt']['type']=='application/pdf'||
    				$file['archivo_txt']['type']=='application/vnd.openxmlformats-officedocument.wordprocessingml.document'||
    				$file['archivo_txt']['type']=='application/msword'||
    				$file['archivo_txt']['type']=='application/vnd.ms-excel'||
    				$file['archivo_txt']['type']=='application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'||
    				$file['archivo_txt']['type']=='application/vnd.ms-powerpoint'||
    				$file['archivo_txt']['type']=='application/vnd.openxmlformats-officedocument.presentationml.presentation'||
    				$file['archivo_txt']['type']=='application/zip'
    			){

    				$finfo = finfo_open(FILEINFO_MIME_TYPE); // return mime-type extension
    				$tipe = finfo_file($finfo, $_FILES['archivo_txt']['tmp_name']);
    				finfo_close($finfo);
    				if(
    					$tipe=='image/jpg'||
	    				$tipe=='image/jpeg'||
	    				$tipe=='image/png'||
	    				$tipe=='application/pdf'||
	    				$tipe=='application/vnd.openxmlformats-officedocument.wordprocessingml.document'||
	    				$tipe=='application/msword'||
	    				$tipe=='application/vnd.ms-excel'||
	    				$tipe=='application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'||
	    				$tipe=='application/vnd.ms-powerpoint'||
	    				$tipe=='application/vnd.openxmlformats-officedocument.presentationml.presentation'||
	    				$tipe=='application/zip'
    				){
						if($file['archivo_txt']['size']<2000000){
	    					$info = pathinfo($file['archivo_txt']['name']);
							$ext = $info['extension']; // get the extension of the file

							//validar extencion
							if(
								$ext=='jpg'||
								$ext=='png'||
								$ext=='jpeg'||
								$ext=='pdf'||
								$ext=='docx'||
								$ext=='doc'||
								$ext=='xls'||
								$ext=='xlsx'||
								$ext=='ppt'||
								$ext=='pptx'||
								$ext=='zip'
							){
								return array('success'=>'success','tipe'=>$tipe);
							}else{
								return array('success'=>'error','msg'=>'El formato de la extensión del archivo no es válido');
							}
	    				}else{
	    					return array('success'=>'error','msg'=>'El archivo sobrepasa el límite de peso permitido (2M)');
	    				}
    				}else{
						return array('success'=>'error','msg'=>'El formato del archivo es raro '.$tipe);
    				}
    			}else{
    				return array('success'=>'error','msg'=>'El formato del archivo no es válido');
    			}
    		}else{
    			return array('success'=>'error','msg'=>'Error con el nombre del archivo');
    		}
    	}else{
    		return array('success'=>'error','msg'=>'No se encontró el archivo');
    	}
    }else{
    	return array('success'=>'error','msg'=>'No se adjuntó ningún archivo');
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