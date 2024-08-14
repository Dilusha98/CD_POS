$(function () {

    //form submit
    if ($("#userCreateForm").length > 0) {

        $('#userCreateForm').validate({
            errorPlacement: function(error, element) {
                var name = element.attr('name');
                $('#' + name + 'Error').html(error);
            },
            rules: {
                firatName: {
                    required: true,
                    minlength: 2,
                    maxlength: 50
                },
                LastName: {
                    required: true,
                    minlength: 2,
                    maxlength: 50
                },
                phoneNo: {
                    required: true,
                    phoneNumber: true,
                },
                userEmail: {
                    required: true,
                    email: true,
                    maxlength: 50
                }
            },
            messages: {
                firatName: {
                    required: "Please enter a first name",
                    minlength: "First name must be at least 2 characters long",
                    maxlength: "First name must be no more than 50 characters long"
                },
                LastName: {
                    required: "Please enter a last name",
                    minlength: "Last name must be at least 2 characters long",
                    maxlength: "Last name must be no more than 50 characters long"
                },
                phoneNo: {
                    required: "Please enter your phone number.",
                    phoneNumber: "Please enter a valid phone number."
                },
                userEmail: {
                    required: "Please enter your email address",
                    email: "Please enter a valid email address",
                    maxlength: "Email must not exceed 50 characters"
                }
            },
            submitHandler: function(form, event) {
                event.preventDefault();

                // var formData = new FormData(form);
                var formData = new FormData(document.getElementById('brandForm'));

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url:'/add-brand',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Brand Added',
                            text: 'The brand has been successfully added!',
                            confirmButtonText: 'OK'
                        });
                        $('#brandAddModal').modal('hide');
                        form.reset();
                        $('.dropify-clear').click();
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
                                text: 'There was an error adding the brand. Please try again.',
                                confirmButtonText: 'OK'
                            });
                        }
                    }
                });
            }
        });
    }


    // Add event for counting characters for first name
    var maxChars = 50;
    var $firatName = $('#firatName');
    var $firatNamecharCount = $('#firatNamecharCount');
    $firatName.on('input', function() {
        var remaining = maxChars - $(this).val().length;
        $firatNamecharCount.text(remaining + ' characters left');
    });

    // Add event for counting characters for last name
    var $LastName = $('#LastName');
    var $lastNamecharCount = $('#lastNamecharCount');
    $LastName.on('input', function() {
        var remaining = maxChars - $(this).val().length;
        $lastNamecharCount.text(remaining + ' characters left');
    });

    //phone number validation
    /*$.validator.addMethod("phoneNumber", function(value, element) {
        return this.optional(element) || /^(\+\d{1,3}[- ]?)?\d{10,15}$/.test(value);
    }, "Please enter a valid phone number.");*/
    $.validator.addMethod("phoneNumber", function(phone_number, element) {
        phone_number = phone_number.replace(/\s+/g, "");
        var isValid = false;
        
        // India: +91 followed by 10 digits
        var indiaRegex = /^(\+91|0)?[6789]\d{9}$/;
        
        // China: +86 followed by 11 digits
        var chinaRegex = /^(\+86|0)?1[3456789]\d{9}$/;
        
        // Japan: +81 followed by 10 digits (excluding first 0)
        var japanRegex = /^(\+81|0)\d{9,10}$/;
        
        // South Korea: +82 followed by 9-10 digits
        var southKoreaRegex = /^(\+82|0)?1[0-9]{7,8}$/;
        
        // Singapore: +65 followed by 8 digits
        var singaporeRegex = /^(\+65|0)?[89]\d{7}$/;

        // Sri Lanka: +94 followed by 9 digits
        var sriLankaRegex = /^(\+94|0)?[1-9]\d{8}$/;
        
        // Check if the number matches any of the country formats
        isValid = indiaRegex.test(phone_number) ||
                  chinaRegex.test(phone_number) ||
                  japanRegex.test(phone_number) ||
                  southKoreaRegex.test(phone_number) ||
                  singaporeRegex.test(phone_number) ||
                  sriLankaRegex.test(phone_number);
        
        return this.optional(element) || isValid;
    }, "Please enter a valid phone number");

    // Add event for counting characters for email
    var $userEmail = $('#userEmail');
    var $userEmailCount = $('#userEmailCount');
    $userEmail.on('input', function() {
        var remaining = maxChars - $(this).val().length;
        $userEmailCount.text(remaining + ' characters left');
    });
});