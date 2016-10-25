/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


function validaEmail(email){
    
    if(/\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)/.test(email)){
        document.getElementById('containerEmail').className+=' has-error';
        return false;
    }else return true;
}

function validaUserName(userName){
    
    if(userName == null || userName.length == 0 || /^\s+$/.test(userName)){
        document.getElementById('containerUserName').className+=' has-error';
        return false;
    }else 
        return true;
}

function validaPasswordRegistro(password1,password2){
    
    if(password1 != password2 || password1.length < 8 || !/([\d]+[A-Za-z]+)|[A-Za-z]+[\d]/.test(password1)){   
        document.getElementById('containerPassword1').className+=' has-error';
        document.getElementById('containerPassword2').className+=' has-error';
        return false;
    }else 
        return true;
}

function validaCambioPassword(password1,password2){
    
    if(password1.length != 0 && password2.length != 0){
    
        if(password1 != password2 || password1.length < 8 || !/([\d]+[A-Za-z]+)|[A-Za-z]+[\d]/.test(password1)){   
            document.getElementById('containerPassword1').className+=' has-error';
            document.getElementById('containerPassword2').className+=' has-error';
            return false;
        }else
            return true;
    }else 
        return true;
}

function calcular_edad(){ 

   	//calculo la fecha de hoy 
   	var hoy=new Date();
   	//alert(hoy) 

   	
   	var year = document.getElementById('www_user_profile_fecha_nacimiento_year').value; 
        var mes = document.getElementById('www_user_profile_fecha_nacimiento_month').value;
        var dia = document.getElementById('www_user_profile_fecha_nacimiento_day').value;
   
   	if (isNaN(year) || isNaN(mes) || isNaN(dia)) 
            return false; 

   	//resto los años de las dos fechas 
   	var edad=hoy.getYear()- year - 1; //-1 porque no se si ha cumplido años ya este año 
        console.log(hoy+" -- "+hoy.getFullYear());
console.log("1 "+edad);
   	//si resto los meses y me da menor que 0 entonces no ha cumplido años. Si da mayor si ha cumplido 
   	if (hoy.getMonth() + 1 - mes < 0){ //+ 1 porque los meses empiezan en 0 
     console.log("2 "+edad);
        return edad 
    }
        if (hoy.getMonth() + 1 - mes > 0) {
            console.log("3 "+edad);
      	return edad+1 
        }
   	//entonces es que eran iguales. miro los dias 
   	//si resto los dias y me da menor que 0 entonces no ha cumplido años. Si da mayor o igual si ha cumplido 
   	if (hoy.getUTCDate() - dia >= 0) {
            console.log("4 "+edad);
      	return edad + 1 }
console.log("5 "+edad)
   	return edad 
}

function validacionRegistro(){
    
    var password1 = document.getElementById('fos_user_registration_form_plainPassword_first').value;
    var password2 = document.getElementById('fos_user_registration_form_plainPassword_second').value;
    var email = document.getElementById('fos_user_registration_form_useremail');
    var userName= document.getElementById('fos_user_registration_form_username');
    
    if(!validaUserName(userName) || !validaPasswordRegistro(password1,password2) || ! validaEmail(email))
        return false;
    else
        return true;
   
}

function validacionPerfil(){
    
    var password1 = document.getElementById('www_user_profile_plainPassword_first').value;
    var password2 = document.getElementById('www_user_profile_plainPassword_second').value;
    var email = document.getElementById('www_user_profile_email').value;
    
    classActiva();
//    console.log(validaEmail(email));
//    console.log(password1+" - "+password2);
 //   console.log(validaCambioPassword(password1,password2));
 calcular_edad();
    if(!validaEmail(email) || !validaCambioPassword(password1, password2)){
//        console.log("error");
        return false;
    }else{
//        console.log("éxito");
        return true;
    }
}


function classActiva(){
    if(/active/.test(document.getElementById('credenciales').className))
        document.getElementById('tabActive').value = 'credenciales';
    
    else  if(/active/.test(document.getElementById('info').className))
        document.getElementById('tabActive').value = 'info';
    
    else if(/active/.test(document.getElementById('direcciones').className))
        document.getElementById('tabActive').value = 'direcciones';
    
    else if(/active/.test(document.getElementById('transacciones').className))
        document.getElementById('tabActive').value = 'transacciones';
    
    else if(/active/.test(document.getElementById('objetos').className))
        document.getElementById('tabActive').value = 'objetos';
}