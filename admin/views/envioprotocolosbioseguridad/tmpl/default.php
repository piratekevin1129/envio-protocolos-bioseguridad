<?php

defined('_JEXEC') or die('Restricted access');

//print_r($this->datos);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
   
    <!--Jquery-->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" crossorigin="anonymous"></script>

    <!--Estilos propios-->
    <link href="<?php echo JURI::base(); ?>components/com_envioprotocolosbioseguridad/assets/main.css" rel="stylesheet" type="text/css" />
    
    <title>Envio protocolos bioseguridad</title>
</head>
<body>

<div id="tabla">
	<table class="table table-striped">
		<thead>
			<tr>
				<th class="nowrap center" width="2%"><a>Id</a></th>
				<th class="nowrap" width="20%"><a>Nombres apellidos</a></th>
				<th class="nowrap" width="10%"><a>Documento</a></th>
				<th class="nowrap" width="10%"><a>Teléfono</a></th>
				<th class="nowrap" width="11%"><a>Correo</a></th>
				<th class="nowrap" width="16%"><a>Área prestación de servicios</a></th>
				<th class="nowrap" width="11%"><a>Ocupación</a></th>
				<th class="nowrap" width="10%"><a>Fecha registro</a></th>
				<th class="nowrap" width="10%"><a>Dirección IP</a></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach($this->datos as $dato){?>
			<tr>
				<td><?php echo $dato->id?></td>
				<td><?php echo $dato->nombres_apellidos?></td>
				<td><?php echo $dato->tipo_documento.'.'.$dato->numero_documento?></td>
				<td><?php echo $dato->numero_telefono?></td>
				<td><?php echo $dato->correo_electronico?></td>
				<td>
					<?php 
					$area_name = "";
					if($dato->area_prestacion!='3'){
						$area_name = $this->areas[(int)$dato->area_prestacion];
					}else{
						$area_name = $dato->area_prestacion_txt;
					}
					echo $area_name;
					?>
				</td>
				<td><?php echo $dato->ocupacion?></td>
				<td><?php echo $dato->fecha_registro?></td>
				<td><?php echo $dato->ipadress?></td>
			</tr>
			<?php } ?>
		</tbody>
	</table>
</div>

<script src="<?php echo JURI::base(); ?>components/com_envioprotocolosbioseguridad/assets/main.js"></script>
<script>
//titulo
var container_tile = document.getElementsByClassName('container-title')[0]
container_tile.innerHTML = '<h1 class="page-title"><span class="icon-database" aria-hidden="true"></span>Envio protocolos bioseguridad</h1>'

//botones arriba
var toolbar = document.getElementById('toolbar')
var btn = ''

btn+='<div class="btn-wrapper" id="toolbar-edit">'
	btn+='<button onclick="clickDescargar()" class="btn btn-small button-download">'
	btn+='<span class="icon-download" aria-hidden="true"></span>'
	btn+='Descargar reporte'
	btn+='</button>'
btn+='</div>'
toolbar.innerHTML = btn

</script>
</body>
</html>