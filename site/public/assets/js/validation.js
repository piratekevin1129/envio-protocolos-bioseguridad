function validateNumber(cadena){
	var cadena_str = clearVal(String(cadena))
	var cadena_arr = cadena_str.split("")

	var correctos = 0
	
	for(var i = 0;i<cadena_arr.length;i++){
		if(
			cadena_arr[i]=="0"||
			cadena_arr[i]=="1"||
			cadena_arr[i]=="2"||
			cadena_arr[i]=="3"||
			cadena_arr[i]=="4"||
			cadena_arr[i]=="5"||
			cadena_arr[i]=="6"||
			cadena_arr[i]=="7"||
			cadena_arr[i]=="8"||
			cadena_arr[i]=="9"
		){
			correctos++
		}
	}
	if(correctos==cadena_arr.length){
		return true
	}else{
		return false
	}
}

function validateEmail(cadena_){
	var cadena = clearVal(String(cadena_))
	if(cadena.indexOf('@')!=-1&&cadena.indexOf('.')!=-1){
		return true
	}else{
		return false
	}
}

function clearVal(str){
	var new_str = str.replace(new RegExp('<','g'), '')
	var new_str1 = new_str.replace(new RegExp('>','g'), '')
	var new_str2 = new_str1.replace(new RegExp('"','g'), '')
	var new_str3 = new_str2.replace(new RegExp("'",'g'), '')
	var new_str4 = new_str3.replace(new RegExp('\\\\','g'), '')
	var new_str4 = new_str3.replace(new RegExp('\\\\','g'), '')
	var new_str5 = new_str4.replace(new RegExp('=','g'), '')
	return new_str5
}

function empty(str){
	var input = clearVal(str)
	var text_value = input
	var text_value_arr = text_value.split("")
	var espacios = 0
	var t = 0;
	for(t = 0;t<text_value_arr.length;t++){
		if(text_value_arr[t]==" "){
			espacios++
		}
	}
	if(text_value==""||espacios==text_value_arr.length){
		//vacio
		return true
	}else{
        //no vacio
        return false
	}
}

function getI(idname){
	return document.getElementById(idname)
}