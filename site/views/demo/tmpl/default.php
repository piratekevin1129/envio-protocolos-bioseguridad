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

</head>
<body>

<form id="archivo_form" method="post" enctype="multipart/form-data" action="index.php?option=com_envioprotocolosbioseguridad&task=guardarArchivoFake">
    <input type="file" name="archivo_txt" id="archivo_txt" accept=".pdf,.jpg,.jpeg,.png,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.zip" />
    <br />
    <input type="submit" value="Enviar" />
</form>

</body>
</html>
