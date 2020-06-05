<?php 
header('Access-Control-Allow-Origin: *');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
   
    <!--Jquery-->
    <!--<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" crossorigin="anonymous"></script>-->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.2/jquery.form.min.js" crossorigin="anonymous"></script>

    <title>Demo</title>

</head>
<body>

<form id="formulario" method="post" enctype="multipart/form-data" action="index.php?option=com_envioprotocolosbioseguridad&task=guardarArchivo">
    <input type="file" name="archivo_txt" />
</form>
<br />
<br />

<button onclick="enviarDatos()">Enviar</button>

<script>

function enviarDatos(){
    $('#formulario').submit()
}

</script>
</body>
</html>
