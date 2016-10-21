/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function validacionRegistro(){
    
    var password1 = document.getElementById('fos_user_registration_form_plainPassword_first').value;
    var password2 = document.getElementById('fos_user_registration_form_plainPassword_second').value;
    var email = document.getElementById('fos_user_registration_form_useremail');
    var userName= document.getElementById('fos_user_registration_form_username');
    var validacion = true;
    
    
    if(userName == null || userName.length == 0 || /^\s+$/.test(userName)){
        
        validacion = false;
        document.getElementById('containerUserName').className+=' has-error';
        
    } else if(password1 != password2 || password1.length < 8 || !/([\d]+[A-Za-z]+)|[A-Za-z]+[\d]/.test(password1)){
        
        validacion = false;
        document.getElementById('containerPassword1').className+=' has-error';
        document.getElementById('containerPassword2').className+=' has-error';
        
    }else if(/\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)/.test(email)){
        
        validacion = false;
        document.getElementById('containerEmail').className+=' has-error';

    }
    
    return validacion;
}

