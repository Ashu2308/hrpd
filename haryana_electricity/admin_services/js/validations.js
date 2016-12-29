var selectorId = 'editComplainSubmit';
$().ready(function () {
    $('.alert').on('click', '.close', function () {
        $(this).closest('.alert').slideUp();
    });
    $.validator.addMethod("checkUniquePhone",
            function (value, element) {
                var result = false;
                $.ajax({
                    type: "POST",
                    async: false,
                    url: "ajax-process.php?action=checkUniquePhone", // script to validate in server side
                    data: {phone: value},
                    success: function (data) {
                        if (data == 'true')
                        {
                            result = true;
                        } else
                        {
                            result = false;
                        }
                    }
                });
                // return true if username is exist in database
                return result;
            },
            "This phone is already taken!"
            );

    $.validator.addMethod("checkUniqueComplaintNumber",
            function (value, element) {
                var result = false;
                var complaint_date = $('#complainDate').val()
                $.ajax({
                    type: "POST",
                    async: false,
                    url: "ajax-process.php?action=checkUniqueComplaintNumber", // script to validate in server side
                    data: {complaint_number: value, complaint_date: complaint_date},
                    success: function (data) {
                        if (data == 'true')
                        {
                            result = true;
                        } else
                        {
                            result = false;
                        }
                    }
                });
                // return true if username is exist in database
                return result;
            },
            "This complaint number is already taken! Try another."
            );

    $.validator.addMethod("checkUniqueArea",
            function (value, element) {
                var result = false;

                $.ajax({
                    type: "POST",
                    async: false,
                    url: "ajax-process.php?action=checkUniqueArea", // script to validate in server side
                    data: {area: value},
                    success: function (data) {
                        if (data == 'true')
                        {
                            result = true;
                        } else
                        {
                            result = false;
                        }
                    }
                });
                // return true if username is exist in database
                return result;
            },
            "This division is already taken!"
            );

    $.validator.addMethod("checkUniqueDivisionCode",
            function (value, element) {
                var result = false;

                $.ajax({
                    type: "POST",
                    async: false,
                    url: "ajax-process.php?action=checkUniqueDivisionCode", // script to validate in server side
                    data: {division_code: value},
                    success: function (data) {
                        if (data == 'true')
                        {
                            result = true;
                        } else
                        {
                            result = false;
                        }
                    }
                });
                // return true if username is exist in database
                return result;
            },
            "This division code is already taken!"
            );

    $.validator.addMethod("checkUniqueSubdivision",
            function (value, element) {
                var result = false;

                $.ajax({
                    type: "POST",
                    async: false,
                    url: "ajax-process.php?action=checkUniqueSubdivision", // script to validate in server side
                    data: {subdivision: value},
                    success: function (data) {
                        if (data == 'true')
                        {
                            result = true;
                        } else
                        {
                            result = false;
                        }
                    }
                });
                // return true if username is exist in database
                return result;
            },
            "This subdivision is already taken!"
            );

    $.validator.addMethod("checkUniqueComplainCategory",
            function (value, element) {
                var result = false;

                $.ajax({
                    type: "POST",
                    async: false,
                    url: "ajax-process.php?action=checkUniqueComplainCategory", // script to validate in server side
                    data: {complain_cat: value},
                    success: function (data) {
                        if (data == 'true')
                        {
                            result = true;
                        } else
                        {
                            result = false;
                        }
                    }
                });
                // return true if username is exist in database
                return result;
            },
            "This complain category is already taken! Try another."
            );

    // check validation for future date
    $.validator.addMethod("checkFutureDate",
            function (value, element) {
                var result = false;

                var fullDate = new Date();
                var twoDigitMonth = (fullDate.getMonth() + 1) + "";
                if (twoDigitMonth.length == 1)
                    twoDigitMonth = "0" + twoDigitMonth;
                var twoDigitDate = fullDate.getDate() + "";
                if (twoDigitDate.length == 1)
                    twoDigitDate = "0" + twoDigitDate;

                var currentDate = twoDigitDate + "/" + twoDigitMonth + "/" + fullDate.getFullYear();
                var enteredDate = value;

                var dateParts = enteredDate.split("/");
                var dateParts1 = currentDate.split("/");

                var enteredDate = new Date(dateParts[2], dateParts[1] - 1, dateParts[0]);
                var currentDate = new Date(dateParts1[2], dateParts1[1] - 1, dateParts1[0]);

//                var currentDate = new Date(currentDate);
//                var enteredDate = new Date(enteredDate);
//                alert(currentDate);
//                alert(enteredDate);

                if (currentDate >= enteredDate)
                {
                    var result = true;
                }
                // return true if username is exist in database
                return result;
            },
            "Future date not allowed!"
            );

    // check validation for future date
    $.validator.addMethod("checkFutureTime",
            function (value, element) {
                var result = false;
                
               
                return true;
            },
            "Future time not allowed!"
            );

    jQuery.validator.addMethod("lettersonly", function (value, element) {
        return this.optional(element) || /^[a-z]+$/i.test(value);
    }, "Letters only please");

    $.validator.addMethod("validateEmail", function (value) {
        var emailReg = /^\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i;
        return emailReg.test($('#email').val());
    });

    $("#editCategoryForm").validate({
        rules: {
            name: {
                required: true,
            },
            status: {
                required: true,
            },
        },
        submitHandler: function (form) {
            var postData = $('#editCategoryForm').serializeArray();
            var formURL = $('#editCategoryForm').attr("action");
            var status = checkSession();
            if (status) {
                $.ajax({
                    url: formURL,
                    type: "POST",
                    data: postData,
                    success: function (result) {
                        if (result == 'true') {
                            $('#complainModal').modal('hide');
                            var msg = '<a href="#" class="close"  aria-label="close">&times;</a><strong>Success!</strong> Complaint category updated successfully.';
                            $("html, body").animate({scrollTop: 0}, "slow");
                            $('.alert-success').html('');
                            $('.alert-success').html(msg);
                            $('.alert-success').slideDown();
                            document.getElementById("editCategoryForm").reset();
                            getAllComplainCategory();
                        } else {
                            $('#complainModal').modal('hide');
                            var msg = '<a href="#" class="close"  aria-label="close">&times;</a><strong>Error!</strong> Category not updated. Something goes wrong';
                            $("html, body").animate({scrollTop: 0}, "slow");
                            $('.alert-danger').html('');
                            $('.alert-danger').html(msg);
                            $('.alert-danger').slideDown();
                        }
                    },
                    error: function (error) {
                        alert('error; ' + eval(error));
                    }
                });
            }
        },
        messages: {
        }
    });

    $("#addNewCategory").validate({
        rules: {
            name: {
                required: true,
                checkUniqueComplainCategory: true
            },
            status: {
                required: true,
            },
        },
        submitHandler: function (form) {
            var postData = $('#addNewCategory').serializeArray();
            var formURL = $('#addNewCategory').attr("action");
            var status = checkSession();
            if (status) {
                $.ajax({
                    url: formURL,
                    type: "POST",
                    data: postData,
                    success: function (result) {
                        if (result == 'true') {
                            $('#complainCategoryAddModal').modal('hide');
                            var msg = '<a href="#" class="close"  aria-label="close">&times;</a><strong>Success!</strong> A new complaint category added successfully.';
                            $("html, body").animate({scrollTop: 0}, "slow");
                            $('.alert-success').html('');
                            $('.alert-success').html(msg);
                            $('.alert-success').slideDown();
                            document.getElementById("addNewCategory").reset();
                            getAllComplainCategory();
                        } else {
                            $('#complainCategoryAddModal').modal('hide');
                            var msg = '<a href="#" class="close"  aria-label="close">&times;</a><strong>Error!</strong> Category not added. Something goes wrong';
                            $("html, body").animate({scrollTop: 0}, "slow");
                            $('.alert-danger').html('');
                            $('.alert-danger').html(msg);
                            $('.alert-danger').slideDown();
                        }
                    },
                    error: function (error) {
                        alert('error; ' + eval(error));
                    }
                });
            }
        },
        messages: {
        }
    });

    $("#addNewUserForm").validate({
        rules: {
            name: {
                required: true,
            },
            phone: {
                required: true,
                checkUniquePhone: true,
                number: true,
                maxlength: 10,
                minlength: 10
            },
            role: {
                required: true,
            },
            password: {
                required: true,
            },
            subdivision: {
                required: true,
            },
            area: {
                required: true,
            },
        },
        submitHandler: function (form) {
            var postData = $('#addNewUserForm').serializeArray();
            var formURL = $('#addNewUserForm').attr("action");
            var status = checkSession();
            if (status) {
                $.ajax({
                    url: formURL,
                    type: "POST",
                    cache: false,
                    data: postData,
                    success: function (result)
                    {
                        $('#AddUserModal').modal('hide');
                        var msg = '<a href="#" class="close"  aria-label="close">&times;</a><strong>Success!</strong> New user added successfully.';
                        $("html, body").animate({scrollTop: 0}, "slow");
                        $('.alert-success').html('');
                        $('.alert-success').html(msg);
                        $('.alert-success').slideDown();
                        document.getElementById("addNewUserForm").reset();
                        getAllUser();

                    },
                    error: function (error)
                    {
                        $('#AddUserModal').modal('hide');
                        var msg = '<a href="#" class="close"  aria-label="close">&times;</a><strong>Error!</strong> User not added. Something goes wrong';
                        $("html, body").animate({scrollTop: 0}, "slow");
                        $('.alert-danger').html('');
                        $('.alert-danger').html(msg);
                        $('.alert-danger').slideDown();
                    }
                });
            }
        },
        messages: {
            email: "Please enter a valid email",
        }
    });

    $("#registerNewComplain").validate({
        rules: {
            customer_id: {
                //required: true,
            },
            complaint_number: {
                required: true,
                maxlength: 11,
                minlength: 11,
                checkUniqueComplaintNumber: true
            },
            name: {
                required: true,
            },
            phone: {
                //required: true,
                number: true,
                maxlength: 10,
                minlength: 10
            },
            subdivision_lineman: {
                //required: true,
            },
            lineman: {
                //required: true,
            },
            address: {
                //required: true,
            },
            complian_date: {
                required: true,
                checkFutureDate: true
            },
            complian_time: {
                required: true,
                //checkFutureTime: true
            },
        },
        submitHandler: function (form) {
            var postData = $('#registerNewComplain').serializeArray();
            var formURL = $('#registerNewComplain').attr("action");

            var status = checkSession();
            if (status) {
                $.ajax({
                    url: formURL,
                    type: "POST",
                    cache: false,
                    data: postData,
                    success: function (result)
                    {
                        //$('#AddUserModal').modal('hide');
                        var msg = '<a href="#" class="close"  aria-label="close">&times;</a><strong>Success!</strong> Complaint register successfully.';
                        $("html, body").animate({scrollTop: 0}, "slow");
                        $('.alert-success').html('');
                        $('.alert-success').html(msg);
                        $('.alert-success').slideDown();
                        document.getElementById("registerNewComplain").reset();
                        var generated_complaint_number = getCurrentComplaintNumber();
//                        alert(generated_complaint_number);
//                        $('#auto_complaint_number').val(generated_complaint_number);
//                        $('#hidden_complaint_number').val(generated_complaint_number);

                    },
                    error: function (error)
                    {
                        //$('#AddUserModal').modal('hide');
                        var msg = '<a href="#" class="close"  aria-label="close">&times;</a><strong>Error!</strong> Complaint not register. Something goes wrong';
                        $("html, body").animate({scrollTop: 0}, "slow");
                        $('.alert-danger').html('');
                        $('.alert-danger').html(msg);
                        $('.alert-danger').slideDown();
                    }
                });
            }
        },
        messages: {
            //email: "Please enter a valid email",
        }
    });

//    $("#editComplains").validate({
//        rules: {
//            complain_category: {
//               // required: true,
//            },
//            complian_date: {
//                //required: true,
//            },
//            complian_time: {
//               // required: true,
//            },
//        },
//        submitHandler: function (form) {
//            var postData = $('#editComplains').serializeArray();
//            var formURL = $('#editComplains').attr("action");
//            var status = checkSession();
//            if (status) {
//                $.ajax({
//                    url: formURL,
//                    type: "POST",
//                    data: postData,
//                    success: function (result) {
//                        if (result == 'true') {
//                            $('#complainModal').modal('hide');
//                            var msg = '<a href="#" class="close"  aria-label="close">&times;</a><strong>Success!</strong> Complain resolved  successfully.';
//                            $("html, body").animate({scrollTop: 0}, "slow");
//                            $('.alert-success').html('');
//                            $('.alert-success').html(msg);
//                            $('.alert-success').slideDown();
//                            document.getElementById("editComplains").reset();
//                            getAllPendingComplain();
//                        } else {
//                            $('#complainModal').modal('hide');
//                            var msg = '<a href="#" class="close"   aria-label="close">&times;</a><strong>Error!</strong> Complain not resolved. Something goes wrong';
//                            $("html, body").animate({scrollTop: 0}, "slow");
//                            $('.alert-danger').html('');
//                            $('.alert-danger').html(msg);
//                            $('.alert-danger').slideDown();
//                        }
//                    },
//                    error: function (error) {
//                        alert('error; ' + eval(error));
//                    }
//                });
//            }
//        },
//        messages: {
//        }
//    });

    // Add new area
    $("#addNewArea").validate({
        rules: {
            area_name: {
                required: true,
                checkUniqueArea: true
            },
            division_code: {
                required: true,
                checkUniqueDivisionCode: true,
                maxlength: 3,
                minlength: 3
            },
            status: {
                required: true,
            },
        },
        submitHandler: function (form) {
            var postData = $('#addNewArea').serializeArray();
            var formURL = $('#addNewArea').attr("action");
            var status = checkSession();
            if (status) {
                $.ajax({
                    url: formURL,
                    type: "POST",
                    data: postData,
                    success: function (result) {
                        if (result == 'true') {
                            $('#AddAreaModal').modal('hide');
                            var msg = '<a href="#" class="close"   aria-label="close">&times;</a><strong>Success!</strong> Division added successfully.';
                            $("html, body").animate({scrollTop: 0}, "slow");
                            $('.alert-success').html('');

                            $('.alert-success').html(msg);
                            $('.alert-success').slideDown();
                            document.getElementById("addNewArea").reset();
                            getAllArea();
                        } else {
                            $('#AddAreaModal').modal('hide');
                            var msg = '<a href="#" class="close"   aria-label="close">&times;</a><strong>Error!</strong> Division not added. Something goes wrong';
                            $("html, body").animate({scrollTop: 0}, "slow");
                            $('.alert-danger').html('');
                            $('.alert-danger').html(msg);
                            $('.alert-danger').slideDown();
                        }
                    },
                    error: function (error) {
                        alert('error; ' + eval(error));
                    }
                });
            }
        },
        messages: {
        }
    });

    // Add new Subdivision
    $("#addNewSubdivision").validate({
        rules: {
            subdivision_name: {
                required: true,
                checkUniqueSubdivision: true
            },
            area_id: {
                required: true,
            },
            status: {
                required: true,
            },
        },
        submitHandler: function (form) {
            var postData = $('#addNewSubdivision').serializeArray();
            var formURL = $('#addNewSubdivision').attr("action");
            var status = checkSession();
            if (status) {
                $.ajax({
                    url: formURL,
                    type: "POST",
                    data: postData,
                    success: function (result) {
                        if (result == 'true') {
                            $('#AddSubdivisionModal').modal('hide');
                            var msg = '<a href="#" class="close"   aria-label="close">&times;</a><strong>Success!</strong> Subdivision added successfully.';
                            $("html, body").animate({scrollTop: 0}, "slow");
                            $('.alert-success').html('');
                            $('.alert-success').html(msg);
                            $('.alert-success').slideDown();
                            document.getElementById("addNewSubdivision").reset();
                            getAllSubdivisionWithArea();
                        } else {
                            $('#AddSubdivisionModal').modal('hide');
                            var msg = '<a href="#" class="close"   aria-label="close">&times;</a><strong>Error!</strong> Subdivision not added. Something goes wrong';
                            $("html, body").animate({scrollTop: 0}, "slow");
                            $('.alert-danger').html('');
                            $('.alert-danger').html(msg);
                            $('.alert-danger').slideDown();
                        }
                    },
                    error: function (error) {
                        alert('error; ' + eval(error));
                    }
                });
            }
        },
        messages: {
        }
    });

    // Edit subdivision

    $("#editSubdivision").validate({
        rules: {
            subdivision_name: {
                required: true,
            },
            area_id: {
                required: true,
            },
            status: {
                required: true,
            },
        },
        submitHandler: function (form) {
            var postData = $('#editSubdivision').serializeArray();
            var formURL = $('#editSubdivision').attr("action");
            var status = checkSession();
            if (status) {
                $.ajax({
                    url: formURL,
                    type: "POST",
                    data: postData,
                    success: function (result) {
                        if (result == 'true') {
                            $('#EditSubdivisionModal').modal('hide');
                            var msg = '<a href="#" class="close" aria-label="close">&times;</a><strong>Success!</strong> Subdivision updated  successfully.';
                            $("html, body").animate({scrollTop: 0}, "slow");
                            $('.alert-success').html(msg).slideDown();

                            document.getElementById("editSubdivision").reset();
                            getAllSubdivisionWithArea();
                        } else {
                            $('#EditSubdivisionModal').modal('hide');
                            var msg = '<a href="#" class="close"  aria-label="close">&times;</a><strong>Error!</strong> Subdivision not updated. Something goes wrong';
                            $("html, body").animate({scrollTop: 0}, "slow");
                            $('.alert-danger').html('');
                            $('.alert-danger').html(msg);
                            $('.alert-danger').slideDown();
                        }
                    },
                    error: function (error) {
                        alert('error; ' + eval(error));
                    }
                });
            }
        },
        messages: {
        }
    });

    // Edit Area

    $("#editArea").validate({
        rules: {
            area_name: {
                required: true,
            },
            division_code: {
                required: true,
                //checkUniqueDivisionCode: true
                maxlength: 3,
                minlength: 3
            },
            status: {
                required: true,
            },
        },
        submitHandler: function (form) {
            var postData = $('#editArea').serializeArray();
            var formURL = $('#editArea').attr("action");
            var status = checkSession();
            if (status) {
                $.ajax({
                    url: formURL,
                    type: "POST",
                    data: postData,
                    success: function (result) {
                        if (result == 'true') {
                            $('#EditAreaModal').modal('hide');
                            var msg = '<a href="#" class="close"  aria-label="close">&times;</a><strong>Success!</strong> Division updated  successfully.';
                            $("html, body").animate({scrollTop: 0}, "slow");
                            $('.alert-success').html('');
                            $('.alert-success').html(msg);
                            $('.alert-success').slideDown();
                            document.getElementById("editArea").reset();
                            getAllArea();
                        } else {
                            $('#EditAreaModal').modal('hide');
                            var msg = '<a href="#" class="close"  aria-label="close">&times;</a><strong>Error!</strong> Division not updated. Something goes wrong';
                            $("html, body").animate({scrollTop: 0}, "slow");
                            $('.alert-danger').html('');
                            $('.alert-danger').html(msg);
                            $('.alert-danger').slideDown();
                        }
                    },
                    error: function (error) {
                        alert('error; ' + eval(error));
                    }
                });
            }
        },
        messages: {
        }
    });

    // Change password

    $("#changePassword").validate({
        rules: {
            old_password: {
                required: true,
            },
            new_password: {
                required: true,
            },
            confirm_password: {
                required: true,
                equalTo: "#password"
            },
        },
        submitHandler: function (form) {
            var postData = $('#changePassword').serializeArray();
            var formURL = $('#changePassword').attr("action");
            var status = checkSession();
            if (status) {
                $.ajax({
                    url: formURL,
                    type: "POST",
                    data: postData,
                    success: function (result) {
                        if (result == 'true') {
                            var msg = '<a href="#" class="close"  aria-label="close">&times;</a><strong>Success!</strong> Password Changed  successfully.';
                            $('.alert-success').hide();
                            $('.alert-danger').hide();
                            $('.alert-success').html(msg);
                            $('.alert-success').slideDown();
                            document.getElementById("changePassword").reset();
                            getAllArea();
                        } else if (result == 'notmatch') {
                            var msg = '<a href="#" class="close"  aria-label="close">&times;</a><strong>Error!</strong> Old password does not match!!';
                            $("html, body").animate({scrollTop: 0}, "slow");
                            $('.alert-success').hide();
                            $('.alert-danger').hide();
                            $('.alert-danger').html(msg);
                            $('.alert-danger').slideDown();
                        } else {
                            var msg = '<a href="#" class="close"  aria-label="close">&times;</a><strong>Error!</strong> Password not changed. Something goes wrong';
                            $("html, body").animate({scrollTop: 0}, "slow");
                            $('.alert-danger').html('');
                            $('.alert-danger').html(msg);
                            $('.alert-danger').slideDown();
                        }
                    },
                    error: function (error) {
                        alert('error; ' + eval(error));
                    }
                });
            }
        },
        messages: {
            equalTo: "Password not match!!"
        }
    });


    // edit complain
//$(document).on("click","#editComplainSubmit",function() {
    $('#editComplainSubmit').on('click', function (e) {
        selectorId = 'editComplainSubmit';
        $('#editComplains').data('validator', null);
        $("#editComplains").unbind('validate');
        $("#editComplains").unbind('submitHandler');
        // $('#resolveComplainSubmit').off('click', null);
        // $('#resolveComplainSubmit').unbind('click');

        $("#editComplains").validate({
            rules: {
                complain_category: {
                    //required: true,
                },
                complian_date: {
                    //required: true,
                    checkFutureDate: true
                },        
                complian_date1: {
                    //required: true,
                    checkFutureDate: true
                },
                complian_time: {
                    // required: true,
                },
                customer_name: {
                    required: true,
                },
                customer_mobile: {
                    //required: true,
                    number: true,
                    maxlength: 10,
                    minlength: 10
                },
            },
            submitHandler: function (form) {
                if (selectorId == 'resolveComplainSubmit') {
                    return;
                }
                var postData = $('#editComplains').serializeArray();
                var formURL = $('#editComplains').attr("action");
                var status = checkSession();
                if (status) {
                    $.ajax({
                        url: formURL,
                        type: "POST",
                        data: postData,
                        success: function (result) {
                            if (result != 'false') {
                                $('#complainModal').modal('hide');
                                var msg = '<a href="#" class="close"  aria-label="close">&times;</a><strong>Success!</strong> Complaint updated  successfully.';
                                $("html, body").animate({scrollTop: 0}, "slow");
                                $('.alert-success').html('');
                                $('.alert-success').html(msg);
                                $('.alert-success').slideDown();
                                document.getElementById("editComplains").reset();
                                getAllPendingComplain();
                            } else {
                                $('#complainModal').modal('hide');
                                var msg = '<a href="#" class="close"   aria-label="close">&times;</a><strong>Error!</strong> Complaint not updated. Something goes wrong';
                                $("html, body").animate({scrollTop: 0}, "slow");
                                $('.alert-danger').html('');
                                $('.alert-danger').html(msg);
                                $('.alert-danger').slideDown();
                            }
                        },
                        error: function (error) {
                            alert('error; ' + eval(error));
                        }
                    });
                }
            },
            messages: {
            }
        });
    });

//resolve compolain
    // $(document).on("click", "#resolveComplainSubmit", function () {
    $('#resolveComplainSubmit').on('click', function (e) {
        selectorId = 'resolveComplainSubmit';
        // $('#editComplainSubmit').off('click', null);
        //$('#editComplainSubmit').unbind('click');
        $('#editComplains').data('validator', null);
        $("#editComplains").unbind('validate');
        $("#editComplains").unbind('submitHandler');


        $("#editComplains").validate({
            rules: {
                complain_category: {
                    required: true,
                },
                complian_date: {
                    required: true,
                    checkFutureDate: true
                },
                complian_time: {
                    required: true,
                },
                complian_date1: {
                    required: true,
                    checkFutureDate: true
                },
                complian_time1: {
                    required: true,
                },
                customer_name: {
                    required: true,
                },
                customer_address: {
                    required: true,
                },
                customer_mobile: {
                    //required: true,
                    number: true,
                    maxlength: 10,
                    minlength: 10
                },
                subdivision_lineman: {
                    required: true,
                },
            },
            submitHandler: function (form) {
                if (selectorId == 'editComplainSubmit') {
                    return;
                }
                var postData = $('#editComplains').serializeArray();
                var formURL = $('#editComplains').attr("action");
                var status = checkSession();
                if (status) {
                    $.ajax({
                        url: "ajax-process.php?action=resolveComplains",
                        type: "POST",
                        data: postData,
                        success: function (result) {
                            if (result != 'false') {
                                $('#complainModal').modal('hide');
                                var msg = '<a href="#" class="close"  aria-label="close">&times;</a><strong>Success!</strong> Complaint resolved  successfully.';
                                $("html, body").animate({scrollTop: 0}, "slow");
                                $('.alert-success').html('');
                                $('.alert-success').html(msg);
                                $('.alert-success').slideDown();
                                document.getElementById("editComplains").reset();
                                getCountPendingComplain();
                                getAllPendingComplain();
                            } else {
                                $('#complainModal').modal('hide');
                                var msg = '<a href="#" class="close"   aria-label="close">&times;</a><strong>Error!</strong> Complaint not resolved. Something goes wrong';
                                $("html, body").animate({scrollTop: 0}, "slow");
                                $('.alert-danger').html('');
                                $('.alert-danger').html(msg);
                                $('.alert-danger').slideDown();
                            }
                        },
                        error: function (error) {
                            alert('error; ' + eval(error));
                        }
                    });
                }
            },
            messages: {
            }
        });
    });

    // Reopen complaints

    $("#reopenComplains").validate({
        rules: {
        },
        submitHandler: function (form) {
            var postData = $('#reopenComplains').serializeArray();
            var formURL = $('#reopenComplains').attr("action");
            var status = checkSession();
            if (status) {
                $.ajax({
                    url: formURL,
                    type: "POST",
                    data: postData,
                    success: function (result) {
                        if (result == 'true') {
                            $('#resolveModal').modal('hide');
                            var msg = '<a href="#" class="close" aria-label="close">&times;</a><strong>Success!</strong> This complaint reopened successfully.';
                            $("html, body").animate({scrollTop: 0}, "slow");
                            $('.alert-success').html(msg).slideDown();

                            // document.getElementById("editSubdivision").reset();
                            getCountResolvedComplain();
                            getAllResolveComplain();
                        } else {
                            $('#resolveModal').modal('hide');
                            var msg = '<a href="#" class="close"  aria-label="close">&times;</a><strong>Error!</strong> Complaint could not reopened. Something goes wrong';
                            $("html, body").animate({scrollTop: 0}, "slow");
                            $('.alert-danger').html('');
                            $('.alert-danger').html(msg);
                            $('.alert-danger').slideDown();
                        }
                    },
                    error: function (error) {
                        alert('error; ' + eval(error));
                    }
                });
            }
        },
        messages: {
        }
    });

    // Reopen complaints

    $("#editUser").validate({
        rules: {
            name: {
                required: true,
            },
            password: {
                required: true,
            },
        },
        submitHandler: function (form) {
            var postData = $('#editUser').serializeArray();
            var formURL = $('#editUser').attr("action");
            var status = checkSession();
            if (status) {
                $.ajax({
                    url: formURL,
                    type: "POST",
                    data: postData,
                    success: function (result) {
                        if (result == 'true') {
                            $('#EditUserModel').modal('hide');
                            var msg = '<a href="#" class="close" aria-label="close">&times;</a><strong>Success!</strong> User updated successfully.';
                            $("html, body").animate({scrollTop: 0}, "slow");
                            $('.alert-success').html(msg).slideDown();

                            // document.getElementById("editSubdivision").reset();
                            getAllUser();
                        } else {
                            $('#EditUserModel').modal('hide');
                            var msg = '<a href="#" class="close"  aria-label="close">&times;</a><strong>Error!</strong> User could not updated. Something goes wrong';
                            $("html, body").animate({scrollTop: 0}, "slow");
                            $('.alert-danger').html('');
                            $('.alert-danger').html(msg);
                            $('.alert-danger').slideDown();
                        }
                    },
                    error: function (error) {
                        alert('error; ' + eval(error));
                    }
                });
            }
        },
        messages: {
        }
    });



    function checkSession() {
        var succeed = false;

        $.ajax({
            async: false,
            url: "ajax-process.php?action=checkSession",
            type: "POST",
            data: {userIdString: $('#loggedInUserId').val()},
            success: function (result) {
                //alert(result);
                if (result != '1') {
                    window.location.href = "login.php";
                    // xhr.abort();
                    succeed = false;
                } else {
                    succeed = true;
                }
            },
            error: function (error) {
                //alert('error; ' + eval(error));
            }
        });
        return succeed;
    }

    function getCurrentComplaintNumber() {

        $.ajax({
            async: false,
            url: "ajax-process.php?action=getCurrentComplaintNumber",
            type: "POST",
            // data: {userIdString: $('#loggedInUserId').val()},
            success: function (result) {
                $('#auto_complaint_number').val(result);
                $('#hidden_complaint_number').val(result);
            },
            error: function (error) {
                //alert('error; ' + eval(error));
            }
        });
    }

});