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

    <!--Bootstrap-->
    <!--CDN-->
    <!--
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">    
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    -->
    
    <!--FONT AWASOME-->
    <script src="https://kit.fontawesome.com/a6f44a68f2.js" crossorigin="anonymous"></script>

    <!--Estilos propios-->
    <link href="<?php echo JURI::base(); ?>components/com_envioprotocolosbioseguridad/public/assets/css/fonts.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo JURI::base(); ?>components/com_envioprotocolosbioseguridad/public/assets/css/reset.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo JURI::base(); ?>components/com_envioprotocolosbioseguridad/public/assets/css/master.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo JURI::base(); ?>components/com_envioprotocolosbioseguridad/public/assets/css/responsive.css" rel="stylesheet" type="text/css" />

    <title>Envío Protocolos Bioseguridad</title>

</head>
<body>

<!--
<div id="actualizacion-mensaje-login">
    <p><span>ATENCIÓN!</span><br />Para acceder a esta opción es necesario estar autenticado en nuestro sitio web. Lo invitamos a ingresar con su documento y clave.</p>
</div>
-->

<!--simulador del div #main de arl-->
<div class="" id="contenedor_principal">
    <div id="contenedor_principal_background-wrap">
        <div id="contenedor_principal_background"></div>
    </div>
    <br />
    
    <div id="actualizacion-datos-formulario" style="display:block">
        <div class="actualizacion-datos-formulario-sombra"></div>
        <h2>Envío de Protocolos generales de Bioseguridad a la ARLSURA</h2>
        <br />
        <p>Hemos dispuesto el siguiente formulario para que las empresas afiliadas a la ARL SURA envíen sus protocolos generales de Bioseguridad para ser validados y emitido su certificación.</p>
        <br />
        
        <div class="form-group">
        <!--<div class="form-subgroup form-subgroup-30 form-subgroup-pr">-->
            <p class="form-error"></p>
            <p class="form-label">Tipo Doc*</p>
            <select id="tipo_documento_txt" class="form-select" onchange="validarForm2(this)" onblur="validarForm2(this)" autocomplete="off">
                <option value="0">Seleccionar</option>
                <option value="C">CEDULA</option>
                <option value="E">CEDULA DE EXTRANJERIA</option>
                <option value="TC">CERTIFICADO NACIDO VIVO</option>
                <option value="D">DIPLOMATICO</option>
                <option value="X">DOC.IDENT. DE EXTRANJEROS</option>
                <option value="F">IDENT. FISCAL PARA EXT.</option>
                <option value="A">NIT</option>
                <option value="CA">NIT PERSONAS NATURALES</option>
                <option value="N">NUIP</option>
                <option value="P">PASAPORTE</option>
                <option value="TP">PASAPORTE ONU</option>
                <option value="TF">PERMISO ESPECIAL FORMACN PEPFF</option>
                <option value="TE">PERMISO ESPECIAL PERMANENCIA </option>
                <option value="R">REGISTRO CIVIL</option>
                <option value="TS">SALVOCONDUCTO DE PERMANENCIA</option>
                <option value="T">TARJ.IDENTIDAD</option>
            </select>
        <!--</div>-->
        </div>  

        <div class="form-group">
        <!--<div class="form-subgroup form-subgroup-70 form-subgroup-pl">-->
            <p class="form-error"></p>
            <p class="form-label">Número Doc / NIT *</p>
            <input id="numero_documento_txt" class="form-input" placeholder="Número de cédula o NIT" autocomplete="off" type="text" maxlength="20" onblur="validarForm2(this)" onkeyup="validarForm(this)" />
        <!--</div>-->
        </div>

        <div class="form-group">
            <p class="form-error"></p>
            <p class="form-label">Nombre comercial de la empresa *</p>
            <input id="nombre_comercial_txt" class="form-input" placeholder="Ingrese Nombre Comercial" autocomplete="off" type="text" maxlength="255" onblur="validarForm2(this)" onkeyup="validarForm(this)" />
        </div>

        <div class="form-group">
            <p class="form-error"></p>
            <p class="form-label">Nombre Legal de la empresa *</p>
            <input id="nombre_legal_txt" class="form-input" placeholder="Ingrese Nombre Legal" autocomplete="off" type="text" maxlength="255" onblur="validarForm2(this)" onkeyup="validarForm(this)" />
        </div> 

        <div class="form-group">
            <p class="form-error"></p>
            <p class="form-label">Sector económico</p>
            <select id="sector_txt" class="form-select" onchange="validarForm2(this)" onblur="validarForm2(this)" autocomplete="off">
                
            </select>
        </div>

        <div class="form-group">
            <p class="form-error"></p>
            <p class="form-label">Departamento *</p>
            <select id="departamento_residencia_txt" class="form-select" onchange="cambiarDepartamento(this)" autocomplete="off">
            </select>
        </div>  

        <div class="form-group">
            <p class="form-error"></p>
            <p class="form-label">Municipio *</p>
            <select id="ciudad_residencia_txt" class="form-select" onchange="validarForm2(this)" autocomplete="off">
                <option value="0">Seleccionar</option>
            </select>
        </div>  

        <div class="form-group">
            <p class="form-error"></p>
            <p class="form-label">Dirección</p>
            <!--<p class="form-help">tenga presente sus horarios laborales para garantizar que esté en el lugar definido a la hora de recibir los EPP</p>-->
            <input id="direccion_txt" class="form-input" placeholder="Ingrese dirección" autocomplete="off" type="text" maxlength="255" onblur="validarForm2(this)" onkeyup="validarForm(this)" />
        </div>

        <div class="form-group">
            <p class="form-error"></p>
            <p class="form-label">Correo electrónico *</p>
            <input id="correo_electronico_txt" class="form-input form-input-email" placeholder="Ingrese una dirección de correo válida" autocomplete="off" type="text" maxlength="255" onblur="validarForm2(this)" onkeyup="validarForm(this)" />
        </div>

        <div class="form-group">
            <p class="form-error"></p>
            <p class="form-label">Número celular *</p>
            <input id="numero_telefonico_txt" class="form-input" placeholder="Ingrese número fijo o celular" autocomplete="off" type="text" maxlength="10" onblur="validarForm2(this)" onkeyup="validarForm(this)" />
        </div> 

        <div class="form-group">
            <p class="form-error"></p>
            <p class="form-label">Adjuntar archivo *</p>
            <div class="form-input-file" id="archivo_cont">
                <form id="archivo_form" method="post" enctype="multipart/form-data" action="index.php?option=com_envioprotocolosbioseguridad&task=saveFile">
                    <button>Subir</button>
                    <p>Seleccionar un archivo</p>
                    <input type="hidden" name="td" id="file_td" />
                    <input type="hidden" name="nd" id="file_nd" />
                    <input type="file" name="archivo_txt" id="archivo_txt" accept=".pdf,.jpg,.jpeg,.png,.docx,.docx,.xls,.xlsx,.ppt,.pptx,.zip" onchange="changeArchivo(this)" onchange="validarForm2(this)" />
                </form>
            </div>
            <p class="form-help">Los tipos de archivo permitido son: <span>JPG</span>, <span>PNG</span>, <span>Docs WORD</span>, <span>Docs EXCEL</span>, <span>Docs PowerPoint</span>, <span>PDF</span>, <span>ZIP</span>. Y deben tener un tamaño menor a 2MB</p>
        </div>

        <br />
        <div class="g-recaptcha" data-sitekey="6Lf7QAETAAAAAHR-6hqEwDoZ8OPO_vbzJi1r2lOb" data-callback="recaptchaCallback" data-expired-callback="recaptchaExpired" id="capcha"></div>

        <br />
        <button onclick="clickGuardar(this)" id="guardar-btn" class="btn-locked">Continuar</button>
        <br />
        <br />
        <label class="actualizacion-datos-politics">
            Ley 1581 de 2012  (Podemos compartir datos con Sura y sus filiales y con empresas (envíos, y demás). <a onclick="clickTerminosCondiciones()">Términos y condiciones</a>
            <input id="politicas_txt" type="checkbox" autocomplete="off" class="form-checkbox" onchange="validarForm(this)" />
            <span class="form-checkbox-square"></span>
        </label>
    </div>

    <div id="actualizacion-datos-formulario2" style="display:none">
        <div class="actualizacion-datos-formulario-sombra"></div>
        <h2>Guardaremos tus datos!</h2>
        <p>Revísalos en detalle y confirma que <span>todo está bien</span></p>
        <br />
            
        <div class="form-group">
            <p class="form-texto">Número de cédula / NIT</p>
            <p class="form-value" id="documento_value"></p>
        </div>  

        <div class="form-group">
            <p class="form-texto">Nombre Legal de la empresa</p>
            <p class="form-value" id="nombre_legal_value"></p>
        </div>  

        <div class="form-group">
            <p class="form-texto">Nombre Comercial de la empresa</p>
            <p class="form-value" id="nombre_comercial_value"></p>
        </div>  

        <div class="form-group">
            <p class="form-texto">Sector económico</p>
            <p class="form-value" id="sector_value"></p>
        </div>

        <div class="form-group">
            <p class="form-texto">Departamento</p>
            <p class="form-value" id="departamento_residencia_value"></p>
        </div>  

        <div class="form-group">
            <p class="form-texto">Municipio</p>
            <p class="form-value" id="ciudad_residencia_value"></p>
        </div>  

        <div class="form-group">
            <p class="form-texto">Dirección</p>
            <p class="form-value" id="direccion_value"></p>
        </div>
        
        <div class="form-group">
            <p class="form-texto">Correo electrónico</p>
            <p class="form-value" id="correo_electronico_value"></p>
        </div>

        <div class="form-group">
            <p class="form-texto">Número celular</p>
            <p class="form-value" id="numero_telefonico_value"></p>
        </div>  

        <div class="form-group">
            <p class="form-texto">Archivo</p>
            <p class="form-value" id="archivo_value"></p>
        </div>

        <br />
        <button onclick="clickRegresar(this)" id="regresar-btn"><i class="fas fa-arrow-left"></i>Algo está mal, volver</button>
        <br />
        <button onclick="clickConfirmar(this)" id="correctos-btn" class="btn-unlocked">Están correctos</button>
        <br />
        <br />
        <label class="actualizacion-datos-politics">
            Ley 1581 de 2012  (Podemos compartir datos con Sura y sus filiales y con empresas (envíos, y demás). <a onclick="clickTerminosCondiciones()">Términos y condiciones</a>
            <span id="politicas_value" class="form-checkbox-square"></span>
        </label>
    </div>

    <br />
    <br />
    <br />
    <br />
    
    <div id="modal" class="modal-off">
        <div id="modal-box">
            <div id="modal-body">
                <div id="modal-body-title"></div>
                <div id="modal-body-text"></div>
            </div>
            <button id="modal-btn" class="modal-btn-salir"></button>
        </div>
    </div>
</div>

<script src="<?php echo JURI::base(); ?>components/com_envioprotocolosbioseguridad/public/assets/js/validation.js"></script>
<script src="<?php echo JURI::base(); ?>components/com_envioprotocolosbioseguridad/public/assets/js/master.js"></script>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<script>

var ciudades_data = null
var sectores_data = null

window.onload = function(){
    //resizeContainer()
    $.ajax ({ 
        url: '/components/com_envioprotocolosbioseguridad/public/assets/js/municipios.json', 
        method: "GET",
        success: function(response){
            //console.log(response)
            ciudades_data = response;
            fillDepartamentos()
        },
        error: function (xhr){
            console.log("error loading json")
            console.log(xhr)
        }
    })
    $.ajax({
        url: '/components/com_envioprotocolosbioseguridad/public/assets/js/sectores.json', 
        method: "GET",
        success: function(response){
            //console.log(response)
            sectores_data = response;
            fillSectores()
        },
        error: function (xhr){
            console.log("error loading json")
            console.log(xhr)
        }
    })
}

</script>
</body>
</html>
