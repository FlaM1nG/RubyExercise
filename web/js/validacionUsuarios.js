/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

 function validaEmail(email){
    
    if(email.length >0 && /^[-a-z0-9~!$%^&*_=+}{\'?]+(\.[-a-z0-9~!$%^&*_=+}{\'?]+)*@([a-z0-9_][-a-z0-9_]*(\.[-a-z0-9_]+)*\.(aero|arpa|biz|com|coop|edu|gov|info|int|mil|museum|name|net|org|pro|travel|mobi|[a-z][a-z])|([0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}))(:[0-9]{1,5})?$/i
.test(email))
        return true;
    else
        return false;
}

function validaFecha(year, month, day){
    
    var fechaActual = new Date();
    var dia = fechaActual.getDate();
    var mes = fechaActual.getMonth();
    var ano = fechaActual.getFullYear();
    
    if((ano-year) > 18)
        return true;
    else if(ano-year < 18)
        return false;
    else if((ano-year) === 18){
        if((mes+1)-month <0 )
            return true;
        else if((mes+1)-month > 0)
            return false;
        else{
            if((day-dia) <= 0)
                return true;
            else
                return false;
        }
    }
    
}

function validaPassword(password1,password2){
    
    if(password1 === password2 && password1.length >= 8 && /^(?=\w*\d)(?=\w*[a-zA-Z])\S{8,}$/.test(password1))
        return true;
    else
        return false;
}

function validaUsername(username){
    
    username.replace(/\s/,"");
    
    if(username.length > 0)
        return true;
    else
        return false;
}

function validaRegistro(){
    
    var email = document.getElementById("registroUsuario_email").value;
    var dia = document.getElementById("registroUsuario_birthdate_day").value;
    var mes = document.getElementById("registroUsuario_birthdate_month").value;
    var year = document.getElementById("registroUsuario_birthdate_year").value;
    var password1 = document.getElementById("registroUsuario_password_first").value;
    var password2 = document.getElementById("registroUsuario_password_second").value;
    var username = document.getElementById("registroUsuario_username").value;
    var validar = true;
    
    if(!validaUsername(username)){
        console.log("Username Debe rellenar este dato");
        validar = false;
    }
   
    if(year ==="" || mes ==="" || dia==="" || !validaFecha(year,mes,dia)){
        console.log("Debe ser mayor de edad");
        validar = false;
    }
    
    if(!validaEmail(email)){
        console.log("Email no válido");
        validar = false;
    }
    
    
    if(!validaPassword(password1,password2)){
        console.log("Contraseña no válida");
        validar = false;
    }
    
    return validar;
}

$(document).ready(function(){
   
    $(document).on('click',"#sectionPersonal, #sectionUsername, #sectionEmail, #sectionPassword, #sectionPhoto, #sectionAddress", changeSection);
    $(document).on('click','.buttonEditAddress',activateEditAddress);
    $(document).on('click','.buttonDeleteAddress', deleteAddress);
    
    function changeSection(e){
       e.stopPropagation(); 
       var section = $(this).attr("id"); 
       
       $('#sectionUser').val(section);
       
    }
    
    function activateEditAddress(e){
        e.stopPropagation();
                
        var id = $(this).parent().attr('id');
        var button = $(this);
        var nameButton = button.prop("name");
        
        if(nameButton === "editar"){
            var endString = id.length;
            var idAddress = id.slice(7,endString);
            var posArrayAddress = $('#'+id+' .posArrayAddress').val();
            $('#'+id+' input').prop("readonly",false);
            $('#'+id+' input').prop("disabled",false);
            $('#idChangeAddress').val(posArrayAddress);
           
            button.prop("name","saveAddress");
            button.html("Guardar");
            
            return false;
        }
        
    }
    
    function deleteAddress(e){
        //e.stopPropagation();
        e.preventDefault();
        var id = $(this).parent().attr('id');
        var button = $(this);
        var nameButton = button.prop("name");
        var posArrayAddress = $('#'+id+' .posArrayAddress').val();
        
        $('#idDeleteAddress').val(posArrayAddress);
    }
});

  function validaForgot(){
    
    var email = document.getElementById("passOlvidado_email").value;
   
    var validar = true;

    if(!validaEmail(email)){
        console.log("Email no válido");
        validar = false;
    }
    
    return validar;
}
  function validaChange(){
    
    var password1 = document.getElementById("cambiarPass_password_first").value;
    var password2 = document.getElementById("cambiarPass_password_second").value;
   
    var validar = true;

    if(!validaPassword(password1,password2)){
        console.log("Contraseña no válida");
        validar = false;
    }
    
    return validar;
}
