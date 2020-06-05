var i = 0;

function openModal(data){
    $('#modal-body').html('<div>'+data.content+'</div>')
    $('#modal-box').attr('class',data.modalclass)

    $('#modal').attr('class','modal-on')
    if(data.action!=null&&data.action!=undefined){
        $('#modal-btn').attr('onclick',data.action)
        $('#modal-btn').html(data.value)
        $('#modal-btn').attr('class',data.btnclass)
    }else{
        $('#modal-btn').attr('onclick','closeModal()')
    }
}
function closeModal(){
    $('#modal').attr('class','modal-off')
}

var guardar_btn = getI('guardar-btn')

function fillDepartamentos(){
    var html = '<option value="0">Seleccionar</option>'
    var opti1 = document.createElement('option')
    opti1.innerHTML = 'Seleccionar'
    for(i = 0;i<ciudades_data.length;i++){
        html+='<option value="'+(i+1)+'">'+ciudades_data[i].departamento+'</option>'
        
    }
    $('#departamento_residencia_txt').html(html)
    $('#departamento_residencia_txt').val('0')
}

function fillSectores(){
    var html = ''
    
    for(i = 0;i<sectores_data.length;i++){
        html+='<option value="'+i+'">'+sectores_data[i]+'</option>'
        
    }
    $('#sector_txt').html(html)
    $('#sector_txt').val('0')
}

function cambiarDepartamento(select){
    if(select.value!='0'){
        var municipios_data = ciudades_data[parseInt(select.value-1)].municipios
        var html = '<option value="0">Seleccionar</option>'
        var opti1 = document.createElement('option')
        opti1.innerHTML = 'Seleccionar'
        for(i = 0;i<municipios_data.length;i++){
            html+='<option value="'+(i+1)+'">'+municipios_data[i].municipio+'</option>'
        }
        $('#ciudad_residencia_txt').html(html)
        $('#ciudad_residencia_txt').val('0')
    }
    
    validarForm2(this)
}

function changeArchivo(file){
    var texto = file.value
    var padre = file.parentNode
    var p = padre.getElementsByTagName('p')[0]
    p.innerHTML = texto
    validarForm2(document.getElementById('archivo_cont'))
}

function borrarArchivo(file){
    $('#archivo_form').trigger("reset");
    var padre = file.parentNode
    var p = padre.getElementsByTagName('p')[0]
    p.innerHTML = 'Seleccionar un archivo'
    validarForm2(document.getElementById('archivo_cont'))
}

function recaptchaExpired(){
    clickRegresar(null)
    validarForm()
}
function recaptchaCallback(){
    validarForm()
}

function validarForm(campo){
    validateForm(false)
}
function validarForm2(campo){
    validateForm(true,campo.id)
}

function validateForm(save,id){
    var errors = []
    var correct = []

    var nombre_legal_txt = $('#nombre_legal_txt').val()
    if(empty(nombre_legal_txt)){
        errors.push({field:'nombre_legal_txt',text:"Campo obligatorio"})
    }else{
        correct.push({field:'nombre_legal_txt'})
    }
    var nombre_comercial_txt = $('#nombre_comercial_txt').val()
    if(empty(nombre_comercial_txt)){
        errors.push({field:'nombre_comercial_txt',text:"Campo obligatorio"})
    }else{
        correct.push({field:'nombre_comercial_txt'})
    }
    var numero_documento_txt = $('#numero_documento_txt').val()
    if(empty(numero_documento_txt)){
        errors.push({field:'numero_documento_txt',text:"Campo obligatorio"})
    }else{
        if(validateNumber(numero_documento_txt)){
            correct.push({field:'numero_documento_txt'})
        }else{
            errors.push({field:'numero_documento_txt',text:"Número inválido"})
        }
    }
    
    var tipo_documento_txt = $('#tipo_documento_txt').val()
    if(tipo_documento_txt=='0'){
        errors.push({field:'tipo_documento_txt',text:"Seleccione una opción"})
    }else{
        correct.push({field:'tipo_documento_txt'})
    }
    
    var numero_telefonico_txt = $('#numero_telefonico_txt').val()
    if(empty(numero_telefonico_txt)){
        errors.push({field:'numero_telefonico_txt',text:"Campo obligatorio"})
    }else{
        if(validateNumber(numero_telefonico_txt)){
            correct.push({field:'numero_telefonico_txt'})
        }else{
            errors.push({field:'numero_telefonico_txt',text:"Número inválido"})
        }        
    }
    
    var correo_electronico_txt = $('#correo_electronico_txt').val()
    if(empty(correo_electronico_txt)){
        errors.push({field:'correo_electronico_txt',text:"Campo obligatorio"})
    }else{
        if(validateEmail(correo_electronico_txt)){
            correct.push({field:'correo_electronico_txt'})
        }else{
            errors.push({field:'correo_electronico_txt',text:"Email inválido"})
        }
    }

    var sector_txt = $('#sector_txt').val()
    if(sector_txt=='0'){
        errors.push({field:'sector_txt',text:"Seleccione una opción"})
    }else{
        correct.push({field:'sector_txt'})
    }
    
    ///validar aqui direccion
    var departamento_residencia_txt = $('#departamento_residencia_txt').val()
    if(departamento_residencia_txt=='0'){
        errors.push({field:'departamento_residencia_txt',text:"Seleccione una opción"})
    }else{
        correct.push({field:'departamento_residencia_txt'})
    }
    var ciudad_residencia_txt = $('#ciudad_residencia_txt').val()
    if(ciudad_residencia_txt=='0'){
        errors.push({field:'ciudad_residencia_txt',text:"Seleccione una opción"})
    }else{
        correct.push({field:'ciudad_residencia_txt'})
    }

    var direccion_txt = $('#direccion_txt').val()
    if(empty(direccion_txt)){
        errors.push({field:'direccion_txt',text:"Campo obligatorio"})
    }else{
        correct.push({field:'direccion_txt'})
    }

    var politicas_txt = $('#politicas_txt').prop('checked')
    if(!politicas_txt){
        errors.push({field:'politicas_txt',text:""})
    }else{
        correct.push({field:'politicas_txt'})
    }

    var file_txt = $('#archivo_txt').val()
    if(empty(file_txt)){
        errors.push({field:'archivo_cont',text:"Suba un archivo"})
    }else{
        var file = document.getElementById('archivo_txt')
        if(file.files.length > 0){
            var size = file.files[0].size; 
            var size_m = Math.round((size / 1024)); 
            // The size of the file. 
            if(size_m>=2000){
                errors.push({field:'archivo_cont',text:"El archivo sobrepasa el límite de peso 2MG"})
            }else{ 
                correct.push({field:'archivo_cont'})
            }
        }else{
            errors.push({field:'archivo_cont',text:"No hay archivos adjuntos"})
        }
    }

    var captcha_verified = grecaptcha.getResponse().length
    console.log("captcha_verified: "+captcha_verified)
    if(captcha_verified===0){
        errors.push({field:'',text:"",active:false})
    }else{
        correct.push({field:''})
    }

    //console.log(errors.length)

    if(save){
        for(i = 0;i<correct.length;i++){
            if(correct[i].field==id){
                var field = getI(correct[i].field)
                field.classList.remove('form-input-error')
                var form_group = field.parentNode
                var label_error = form_group.getElementsByClassName('form-error')
                if(label_error.length>0){
                    label_error[0].innerHTML = ""
                }
            }
        }
    }    

    if(errors.length==0){
        //habilitar boton
        $(guardar_btn).attr('class','btn-unlocked')
        guardar_btn.disabled = false
    }else{
        //deshabilitar
        $(guardar_btn).attr('class','btn-locked')
        guardar_btn.disabled = true
        if(save){
            for(i = 0;i<errors.length;i++){
                var activo = errors[i].active
                if(activo!=false){
                    if(errors[i].field==id){
                        var field = getI(errors[i].field)
                        if(field.className.indexOf('error')==-1){
                            field.classList.add('form-input-error')
                        }
                        var form_group = field.parentNode
                        var label_error = form_group.getElementsByClassName('form-error')
                        if(label_error.length>0){
                            label_error[0].innerHTML = errors[i].text
                        }
                    }    
                }
            }
        }
    }
}

function clickGuardar(btn){
    var nombre_legal_txt = $('#nombre_legal_txt').val()
    var nombre_comercial_txt = $('#nombre_comercial_txt').val()
    var numero_documento_txt = $('#numero_documento_txt').val()
    var tipo_documento_txt = $('#tipo_documento_txt').val()
    var numero_telefonico_txt = $('#numero_telefonico_txt').val()
    var correo_electronico_txt = $('#correo_electronico_txt').val()
    var departamento_residencia_txt = $('#departamento_residencia_txt').val()
    var ciudad_residencia_txt = $('#ciudad_residencia_txt').val()
    var direccion_txt = $('#direccion_txt').val()
    var archivo_txt = $('#archivo_txt').val()
    var archivo_name_txt = archivo_txt.substr(archivo_txt.lastIndexOf('\\') + 1).split('.')[0];
    var archivo_ext_txt = archivo_txt.substr(archivo_txt.lastIndexOf('\\') + 1).split('.')[1];
    
    var politicas_txt = $('#politicas_txt').prop('checked')

    var sector_txt = $('#sector_txt').val()
    
    $('#nombre_legal_value').html(clearVal(nombre_legal_txt))
    $('#nombre_comercial_value').html(clearVal(nombre_comercial_txt))
    $('#documento_value').html(clearVal(tipo_documento_txt)+'. '+clearVal(numero_documento_txt))

    $('#numero_telefonico_value').html(clearVal(numero_telefonico_txt))
    $('#correo_electronico_value').html(clearVal(correo_electronico_txt))

    $('#sector_value').html(clearVal(sectores_data[sector_txt]))
                    
    $('#departamento_residencia_value').html(ciudades_data[parseInt(departamento_residencia_txt-1)].departamento)
    $('#ciudad_residencia_value').html(ciudades_data[parseInt(departamento_residencia_txt-1)].municipios[ciudad_residencia_txt-1].municipio)
    $('#direccion_value').html(clearVal(direccion_txt))
    
    if(politicas_txt){
        $('#politicas_value').addClass('form-checkbox-square-checked')
    }

    $('#archivo_value').html(archivo_name_txt+'.'+archivo_ext_txt)

    $('#actualizacion-datos-formulario').attr('style','display:none')
    $('#actualizacion-datos-formulario2').attr('style','display:block')
    $("html, body").animate({ scrollTop: $('#actualizacion-datos-formulario2').offset().top }, 500);
}

function clickRegresar(btn){
    $('#actualizacion-datos-formulario').attr('style','display:block')
    $('#actualizacion-datos-formulario2').attr('style','display:none')
    $("html, body").animate({ scrollTop: $('#actualizacion-datos-formulario').offset().top }, 500);
}


function clickConfirmar(btn){
    $('#regresar-btn').disabled = true
    $('#correctos-btn').disabled = true
    $('#correctos-btn').html('... ENVIANDO')
    
    var nombre_legal_txt = $('#nombre_legal_txt').val()
    var nombre_comercial_txt = $('#nombre_comercial_txt').val()
    var numero_documento_txt = $('#numero_documento_txt').val()
    var tipo_documento_txt = $('#tipo_documento_txt').val()
    var sector_txt = $('#sector_txt').val()
    var departamento_residencia_txt = $('#departamento_residencia_txt').val()
    var ciudad_residencia_txt = $('#ciudad_residencia_txt').val()
    var direccion_txt = $('#direccion_txt').val()
    var correo_electronico_txt = $('#correo_electronico_txt').val()
    var numero_telefonico_txt = $('#numero_telefonico_txt').val()
    
    console.log(grecaptcha.getResponse())

    //subir archivo
    var file_td = $('#file_td').val(tipo_documento_txt)
    var file_nd = $('#file_nd').val(numero_documento_txt)
    
    $("#archivo_form").ajaxForm({
        success: function(result) {
            var result_json = JSON.parse(result)
            if(result_json.success=='success'&&result_json.code=='201'){

                var nombre_txt = result_json.msg;

                //////GUARDAR Y ENVIAR////////
                $.ajax({
                    type: 'post',
                    url: 'index.php?option=com_envioprotocolosbioseguridad&task=guardarDatos',
                    data:{
                        g_recaptcha_response:grecaptcha.getResponse(),
                        nombre_legal_txt:clearVal(nombre_legal_txt),
                        nombre_comercial_txt:clearVal(nombre_comercial_txt),
                        tipo_documento_txt:clearVal(tipo_documento_txt),
                        numero_documento_txt:clearVal(numero_documento_txt),
                        sector_txt:clearVal(sector_txt),
                        departamento_residencia_txt:clearVal(departamento_residencia_txt),
                        ciudad_residencia_txt:clearVal(ciudad_residencia_txt),
                        direccion_txt:clearVal(direccion_txt),
                        correo_electronico_txt:clearVal(correo_electronico_txt),
                        numero_telefonico_txt:clearVal(numero_telefonico_txt),
                        nombre_txt:clearVal(nombre_txt)
                    },
                    success: function(result){
                        if(result=='success'){
                            openModal({
                                content:'<h3 class="modal-body-title">¡Muchas gracias!</h3><br /><p class="modal-body-text">confirmamos que hemos recibido tu formulario, te estaremos contactando una vez realicemos su revisión.</p>',
                                modalclass:'modal-estrellas',
                                action:'gotoARL()',
                                value:'Salir',
                                btnclass:'modal-btn-salir'
                            })
                        }else{
                            openModal({
                                content:'<h3 class="modal-body-title">;(<br />¡Algo salió mal!</h3><br /><p class="modal-body-text">Por favor vuelve e inténtalo de nuevo.</p>',
                                modalclass:'',
                                action:'closeModal()',
                                value:'Volver',
                                btnclass:'modal-btn-volver'
                            })
                            console.log(result)
                        }
                        $('#regresar-btn').disabled = true
                        $('#correctos-btn').disabled = true
                        $('#correctos-btn').html('Están correctos')
                    },
                    error: function(xhr){
                        console.log(xhr)
                        $('#regresar-btn').disabled = true
                        $('#correctos-btn').disabled = true
                        $('#correctos-btn').html('Están correctos')
                        openModal({
                            content:'<h3 class="modal-body-title">;(<br />Algo salió mal</h3><br /><p class="modal-body-text">Por favor vuelve e inténtalo de nuevo.</p>',
                            modalclass:'',
                            action:'closeModal()',
                            value:'Volver',
                            btnclass:'modal-btn-volver'
                        })
                    }
                })
            }else{
                $('#regresar-btn').disabled = true
                $('#correctos-btn').disabled = true
                $('#correctos-btn').html('Están correctos')
                openModal({
                    content:'<h3 class="modal-body-title">;(<br />Algo salió mal</h3><br /><p class="modal-body-text">'+result_json.msg+'.</p>',
                    modalclass:'',
                    action:'closeModal()',
                    value:'Volver',
                    btnclass:'modal-btn-volver'
                })
                console.log(result)
            }
        },
        error: function(request){
            $('#regresar-btn').disabled = true
            $('#correctos-btn').disabled = true
            $('#correctos-btn').html('Están correctos')
            openModal({
                content:'<h3 class="modal-body-title">;(<br />Algo salió mal</h3><br /><p class="modal-body-text">Por favor vuelve e inténtalo de nuevo.</p>',
                modalclass:'',
                action:'closeModal()',
                value:'Volver',
                btnclass:'modal-btn-volver'
            })
            console.log("error ajaxForm")
            console.log(request.responseText)
        }
    });
    $("#archivo_form").submit()
    
}

function clickTerminosCondiciones(){
    var html = ''
    html+='<h3 class="modal-body-title">Términos y condiciones</h3>'
    html+='<br />'
    html+='<div class="modal-body-wraper">'
    html+='<p class="modal-body-text">Autorizo a SURAMERICANA S.A. para el tratamiento de mis datos personales, incluso los biométricos o de salud que son sensibles, pudiendo utilizar computación en la nube; con la finalidad de prevenir, tratar o controlar la propagación del COVID-19 y mitigar sus efectos. Ésta autorización comprende el compartir información con aliados estratégicos y las demás finalidades contempladas en la política de privacidad disponible en www.suramericana.com.'
    html+='<br /><br />'
    html+='Como Titular de sus datos tiene derecho a conocerlos, actualizarlos y rectificarlos, a solicitar prueba de la autorización otorgada para el tratamiento, informarse sobre el uso que se ha dado a los mismos, revocar la autorización, solicitar la supresión de sus datos cuando sea procedente y acceder de forma gratuita a los mismos. El responsable del tratamiento de la información es SURAMERICANA S.A., para ejercer los derechos sobre sus datos personales, comunicarse a la línea de Atención al 4378888 desde Medellín, Bogotá y Cali o al 01 800051888 en el resto del país, enviar un correo electrónico a protecciondedatos@suramericana.com.co o establecer contacto a través de los distintos medios que estas tienen dispuestos para tal fin, tales como sitio web, redes sociales y oficinas de atención al cliente.</p>'
    html+='</div>'
    
    openModal({
        content:html,
        modalclass:'modal-politicas',
        action:'closeModal()',
        value:'Entendido',
        btnclass:'modal-btn-salir'
    })
}

function gotoARL(){
    location.href = 'https://www.arlsura.com'
}

var isresponsive = false
function resizeContainer(){
	var ancho_window = ancho_window = (window.innerWidth-18)
	
	if(ancho_window<560){
		ancho_window = (window.innerWidth)
		isresponsive = true
	}else{
		isresponsive = false
	}

	getI('contenedor_principal').style.width = ancho_window+'px'
	getI('contenedor_principal').style.marginLeft = '50%'
	getI('contenedor_principal').style.marginLeft = 'calc(50% - ('+ancho_window+'px / 2))'
	getI('contenedor_principal').style.marginLeft = '-moz-calc(50% - ('+ancho_window+'px / 2))'
	//alert("ANCHOOO "+ancho_window)
}

resizeContainer()
window.onresize = function(){
	resizeContainer()	
}