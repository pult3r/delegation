$(document).ready(function(){
    
    $("#button-get-auth-code").click(function(){
        var data = new Object(); 

        data['_token'] = $('meta[name="csrf-token"]').attr('content') ; 

        $.ajax({
            method:"POST",
            url:'api/getauthcode',
            data: data , 
        }).done(function(response){
                        
            if(response.success == true ){
                Swal.fire({
                    icon: response.type,
                    title: response.message,
                    showConfirmButton: true,
                    timer: 5000
                }).then(function(result) {
                    $("#form-userid").val(response.data.authcode) ;
                });
            } else {
                Swal.fire({
                    icon: "error",
                    title: response.message,
                    showConfirmButton: true,
                    timer: 5000
                });
            }   
                  
        }).fail(function(response){
            Swal.fire({
                icon: "error",
                title: "internal error !\n",
                showConfirmButton: true,
                timer: 5000
            });
        });
    });

    $("#button-add-delegation").click(function(){
        $(".invalid-feedback").hide();
        $(".is-invalid").removeClass('is-invalid');

        var data = new Object(); 

        $(".form-control").each(function(){
            data[ $(this).attr('name') ] = $(this).val() ; 
        });

        data['_token'] = $('meta[name="csrf-token"]').attr('content') ; 

        $.ajax({
            method:"POST",
            url:'api/storedelegation',
            data: data , 
        }).done(function(response){
            if(response.success == true){
                Swal.fire({
                    icon: response.type,
                    title: response.message,
                    showConfirmButton: true,
                    timer: 5000
                }).then(function(result) {
                    
                    if( response.outputType == 'validation' ){
                        for( field in response.data.validationFields ) {
                            $("#form-"+field).addClass('is-invalid');
                            $("#form-alert-"+field).show();
                            $("#form-alert-text-"+field).html(response.data.validationFields[field]);
                        }
                    }  
                    $(".is-invalid:first").each(function(){
                        $(this).focus(); 
                    }) ;     
                    
                    if( response.type == 'success' ) {
                        window.location.href = "/" ;
                    }                    
                });
            } else {
                Swal.fire({
                    icon: "error",
                    title: response.message,
                    showConfirmButton: true,
                    timer: 5000
                });
            } 
        }).fail(function(response){
            Swal.fire({
                icon: "error",
                title: "internal error !\n",
                showConfirmButton: true,
                timer: 5000
            });
        });
    });
});