"use strict";

// Class Definition
var KTLoginGeneral = function(token) {

    var login = $('#kt_login');

    var showErrorMsg = function(form, type, msg) {
        var alert = $('<div class="kt-alert kt-alert--outline alert alert-' + type + ' alert-dismissible" role="alert">\
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>\
			<span></span>\
		</div>');

        form.find('.alert').remove();
        alert.prependTo(form);
        //alert.animateClass('fadeIn animated');
        KTUtil.animateClass(alert[0], 'fadeIn animated');
        alert.find('span').html(msg);
    }

    var handleSignInFormSubmit = function(token) {
        $('#kt_login_signin_submit').click(function(e) {
            e.preventDefault();
            var btn = $(this);
            var form = $(this).closest('form');           

            form.validate({
                rules: {
                    username: {
                        required: true,
                    },
                    password: {
                        required: true
                    }
                },
                messages : {
                    username : {
                        required : 'Harap masukan username'
                    },
                    password : {
                        required : 'Harap masukan password'
                    },
                }
            });

            if (!form.valid()) {
                return;
            }

            btn.addClass('kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light').attr('disabled', true);

            form.ajaxSubmit({
                url: '',
                dataType : 'json',
                headers: {
                    'X-CSRF-Token': token
                },
                success: function(response, status, xhr, $form) {
                    btn.removeClass('kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light').attr('disabled', false);
                    if(response.code == 200){
                        showErrorMsg(form, 'success', response.message);
                        setTimeout(function() {
                            document.location.href = response.url;
                        }, 2000);
                    }else{
                        btn.removeClass('kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light').attr('disabled', false);
                        setTimeout(function() {
                            showErrorMsg(form, 'danger', response.message);
                        }, 2000);
                    }
                },
                error : function(e){
                    btn.removeClass('kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light').attr('disabled', false);
                    setTimeout(function() {
                        showErrorMsg(form, 'danger', 'Terjadi kesalahan pada server.');
                    }, 2000);
                }
            });
        });
    }


    // Public Functions
    return {
        // public functions
        init: function(token) {
            handleSignInFormSubmit(token);
        }
    };
}();
