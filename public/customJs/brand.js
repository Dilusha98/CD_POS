
$(document).ready(function() {

    $('.dropify').dropify({
        messages: {
            'default': 'Select an image',
            'replace': 'Drag and drop or click to replace',
            'remove':  'Remove',
            'error':   'Oops, something wrong happened.'
        },
        error: {
            'fileSize': 'The file size is too big (2MB max).',
            'imageFormat': 'The image format is not allowed (only JPG, PNG, GIF).'
        },
        maxFileSize: '2M',
    });


    $('#BrandListTbl').DataTable({
        dom: 'Bfrtip',
        buttons: [
            'excelHtml5',
            'pdfHtml5',
            'print'
        ],
        pageLength:10,
        responsive: true,
        lengthChange: false,
        autoWidth: false,
        paging: true,
        searching: true,
        ordering: true,
        info: true
    });


    if ($("#brandForm").length > 0) {

        $('#brandForm').validate({
            errorPlacement: function(error, element) {
                var name = element.attr('name');
                $('#' + name + 'Error').html(error);
            },
            rules: {
                name: {
                    required: true,
                    minlength: 2
                },
                logo: {
                    required: true,
                },
                status: {
                    required: true,
                }
            },
            messages: {
                name: {
                    required: "Please enter a brand name",
                    minlength: "Brand name must be at least 2 characters long"
                },
                logo: {
                    required: "Please upload a logo",
                },
                status: {
                    required: "Please select a status"
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
                        loadBrandData();
                        Swal.fire({
                            icon: 'success',
                            title: 'Brand Added',
                            text: response.message,
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

});


function loadBrandData() {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        url: '/get-brand-data',
        method: 'GET',
        success: function(response) {

            $('#BrandListTbl tbody').empty();
            $.each(response.brands, function(index, brand) {

                var statusBadge = brand.status == 1 ?
                    '<span class="badge badge-success">Active</span>' :
                    '<span class="badge badge-warning">Inactive</span>';

                var created_by = brand.created_by ? brand.created_by.name : 'N/A';

                $('#BrandListTbl tbody').append(
                    '<tr>' +
                        '<td>' + brand.name + '</td>' +
                        '<td>' + statusBadge + '</td>' +
                        '<td>' + created_by + '</td>' +
                        '<td>' + brand.created_at + '</td>' +
                        '<td class="text-center">' +
                            '<div class="dropdown open d-inline-block">' +
                                '<button class="btn btn-primary btn-xs dropdown-toggle" type="button" id="actionDropdown' + brand.id + '" data-toggle="dropdown">' +
                                    '<i class="fas fa-edit"></i>' +
                                '</button>' +
                                '<div class="dropdown-menu">' +
                                    '<a class="dropdown-item" onclick="editBrand(' + brand.id + ')">Edit</a>' +
                                    '<br>' +
                                    '<a class="dropdown-item" onclick="deleteBrand(' + brand.id + ')">Delete</a>' +
                                '</div>' +
                            '</div>' +
                        '</td>' +
                    '</tr>'
                );
            });
        },
        error: function(xhr, status, error) {
            console.error('Failed to load brand data:', error);
        }
    });
}
