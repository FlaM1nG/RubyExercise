/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$(document).ready(function(){
    
    $(document).on('click','.buttonEditAddress',activateEditAddress);
    $(document).on('click','.buttonDeleteAddress', deleteAddress);
    $(document).on('click','#buttonAddAddress', addFormAddress);
    $(document).on('blur','.zipCode', autoCompleteZipCode);
    //$(document).on('click','',checkDeleteOffers);
    
    //function
    
    function activateEditAddress(e){
        e.stopPropagation();
        //e.preventDefault();        
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
    
    function addFormAddress(e){
        e.preventDefault();
        $(".contentAddress").append("<div><label class='required'>Nombre dirección</label>"+
                        "<input type='tex' name='nameNewAddress' required>"+
                        "<label class='required'>Calle</label>"+
                        "<input type='text' name='streetNewAddress' required>"+
                        "<label class='required'>Dirección principal</label>"+
                        "<input type='checkbox' name='isDefaultNewAddress' value='0'>"+
                        "<input class='posArrayAddress' type='hidden' name='posArrayAddress' value=''>"+
                        "<button type='submit' name='newAddress' class='buttonEditAddress'>Guardar</button></div>");
    }
    
    function deleteAddress(e){
        e.stopPropagation();
        //e.preventDefault();
        var id = $(this).parent().attr('id');
        var button = $(this);
        var nameButton = button.prop("name");
        var posArrayAddress = $('#'+id+' .posArrayAddress').val();
         
        $('#idDeleteAddress').val(posArrayAddress);
    }
    
    function autoCompleteZipCode(e){
        e.preventDefault();
        
        console.log("entro");
        var url = $(this).attr('href');
        var zipCode = $(this).attr('value');
        console.log($(this).attr('value'));
        
        
        $.ajax({
            url: "/api_rest/user/addresses/get_zipcode.php",
            data: { zipcode : zipCode },
            dataType: "json",
            method: "POST",
            success: function (data) {
               console.log(data);
            },
            fail: function () {
                console.log("error");
            },
            complete: function (data) {
                console.log("complete");
                console.log(data);
            }
        })
    }
});