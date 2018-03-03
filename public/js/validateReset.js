/**
 * Created by Hp on 1/13/2018.
 */
$.validator.addMethod('validPassword',
    function(value, element, param) {
        if (value != '') {
            if (value.match(/.*[a-z]+.*/i) == null) {
                return false;
            }
            if (value.match(/.*\d+.*/) == null) {
                return false;
            }
        }

        return true;
    },
    'Must contain at least one letter and one number'
);

$(document).ready(function() {

    /**
     * Validate the form
     */
    $('#formPassword').validate({
        rules: {
            password: {
                required: true,
                minlength: 6,
                validPassword: true
            },
//                password_confirmation: {
//                    equalTo: '#inputPassword'
//                }
        },
    });
    $('#inputPassword').hideShowPassword({
        show:false,
        innerToggle: 'focus'
    });
});