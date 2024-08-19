
$(function () {

    $('#passwordConfirmBtn').on('click', function(e) {
       // e.preventDefault();
        changeUserPassword();
    });
   
    var maxCharsPass = 20;
    var $newPassowrd = $('#newPassowrd');
    var $newPassowrdCount = $('#newPassowrdCount');
    $newPassowrd.on('input', function() {
        var remaining = maxCharsPass - $(this).val().length;
        $newPassowrdCount.text(remaining + ' characters left');
    });
    

});


function changeUserPassword() {
    
    //form submit
    if ($("#passwordResetForm").length > 0) {
        $('#passwordResetForm').validate({
            errorPlacement: function(error, element) {
                var name = element.attr('name');
                $('#' + name + 'Error').html(error);
            },
            rules: {
                currentPassword: {
                    required: true,
                    cpcValidation: true
                },
                newPassword: {
                    required: {
                        depends: function(element) {
                            return $("#currentPassword").val().length > 0;
                        }
                    },
                    minlength: 8,  // Minimum length
                    maxlength: 20, // Maximum length
                    pwcheck: true  // Custom validation rule (optional)
                }
            },
            messages: {
                currentPassword: {
                    required: "Please enter a current password",
                },
                newPassowrd: {
                    required: "Please enter a password",
                    minlength: "Password must be at least 8 characters long",
                    maxlength: "Password must be no more than 20 characters long",
                    pwcheck: "Password must contain at least one letter, one number, and one special character"
                },
            },
            submitHandler: function(form, event) {
                event.preventDefault();

                // var formData = new FormData(form);
                var formData = new FormData(document.getElementById('passwordResetForm'));
                

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url:'/SaveResetPassword',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Reset Password',
                            text: 'The password reset is successfully!',
                            confirmButtonText: 'OK'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = '/'; // Redirect to the login page
                            }
                        });

                        $('#passowrdResetMdl').modal('hide');
                        form.reset();
                    },
                    error: function(response) {
                        if (response.status === 422) {
                            var errors = response.responseJSON.errors;
                            $.each(errors, function(key, error) {
                                $('#' + key + 'Error').html(error[0]);
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'There was an error resetting the password. Please try again!',
                                confirmButtonText: 'OK'
                            });
                        }
                    }
                });
            }
        });
    }
}

// Custom password validation rule (optional)
$.validator.addMethod("pwcheck", function(value) {
    return /[A-Za-z]/.test(value) // has a letter
        && /[0-9]/.test(value) // has a digit
        && /[^A-Za-z0-9]/.test(value); // has a special character
});


/* current password check validation */
$.validator.addMethod(
    "cpcValidation",
    function(value, element) {
        return new Promise(function(resolve) {
            $.ajax({
                type: "GET",
                url: '/current-password-match-validation',
                data: {
                    value: value,
                    id: $("#hideUserId").val(),
                },
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
                success: function(status) {
                    resolve(status);
                },
                error: function() {
                    resolve(false);
                },
            });
        });
    },
    'The current password does not match!'
);