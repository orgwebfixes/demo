jQuery('form').on('focus', 'input[type=number]', function (e) {
    jQuery(this).on('wheel.disableScroll', function (error) {
        error.preventDefault();
    });
});

jQuery('form').on('blur', 'input[type=number]', function (e) {
    jQuery(this).off('wheel.disableScroll');
});

function hideshow(value) {
    if (value != '') {
        jQuery('#proof_view').removeClass('hide');
    } else {
        jQuery('#proof_view').addClass('hide');
    }
}

function openmodal(value) {
    if (value != '') {
        jQuery('#modal_theme_primary').modal({
            show: true
        });
    }
}
//for empty otp textbox
jQuery(document).on("click", ".resend_value", function () {
    jQuery('#otp_value').val('');
});
jQuery(document).ready(function () {
    jQuery('[data-toggle="tooltip"]').tooltip();
});

jQuery("#name").on('keyup', function () {
    var Text = jQuery(this).val();
    Text = Text.toLowerCase();
    Text = Text.replace(/[^a-zA-Z0-9]+/g, '-');
    jQuery("#slug").val(Text);
});

/* DatePicker Code */
jQuery(".datepicker").datetimepicker({
    format: 'd-m-Y',
    allowBlank: true,
    timepicker: false,
    mask: false,
    validateOnBlur: true,
    showOn: "button",
    scrollInput: false,
    scrollMonth: false
});
/* DateTimePicker */
jQuery(".datetimepicker").datetimepicker({
    format: 'd-m-Y H:i:s',
    allowBlank: true,
    timepicker: true,
    mask: false,
    validateOnBlur: true,
    showOn: "button"
});

/* Prevent Form Submit */

/* Add Active Class */
jQuery(function () {
    var pgurl = window.location.href;
    jQuery(".navigation li a").each(function () {
        if (jQuery(this).attr("href") == pgurl) {
            jQuery(this).parent().addClass('active');
        }
    });
});
/* For Image Lightbox */
jQuery('[data-popup="lightbox"]').fancybox({
    padding: 3,
    beforeShow: function () {
        this.title = $(this.element).attr('data-title');
    }
});

/* Function Used In Set Error in Modal */
function associate_errors(errors, $form) {
    //remove existing error classes and error messages from form groups
    $form.find('.form-group').removeClass('has-error').find('.help-block').text('');
    jQuery("form").find('.help-block').text('');
    jQuery.each(errors, function (index, value) {
        //find each form group, which is given a unique id based on the form field's name
        var $group = $form.find('#' + index).parents('.form-group');
        if ($group.addClass('has-error').find('.help-block').length == 0) {
            $group.find('.form-control').parent('div').append("<span class='help-block'></span>");
        }
        //add the error class and set the error text
        $group.addClass('has-error').find('.help-block').text(value);
    });
}
//Method for Add more validation message while ajax
function associate_errors_multi(errors, $form) {
    //remove existing error classes and error messages from form groups
    jQuery(".dynamic").find('.error').removeClass('errors')
    jQuery(".dynamic").find('.error').text('')
    jQuery.each(errors, function (index, value) {
        if (index.indexOf("ajax_file") >= 0) {
            index = index.replace("ajax_file", "value");
        }
        var group = jQuery("div").find("[data-tdname='" + index + "']");
        if (group.addClass('has-error').find('.help-block').length == 0) {
            group.find('.control').parent('div').append("<span class='help-block'></span>");
        }
        group.addClass('has-error').find('.help-block').text(value['0']);
    });
}

//Code for User view PopUp
(function () {
    var UserInfo = {
        initialize: function () {
            this.methodLinks = jQuery('body');
            this.registerEvents();
        },
        registerEvents: function () {
            this.methodLinks.on('click', 'a[data-user-show]', this.handleMethod);
        },
        handleMethod: function (e) {
            e.preventDefault();
            var user_id = jQuery(this).attr("data-user-show");
            var url = "/users/" + user_id + "?download=yes";
            jQuery.get(url, function (html) {
                jQuery('#show_user_modal .modal-content').html(html);
                jQuery('#show_user_modal').modal('show', {
                    backdrop: 'static'
                });
            });
        }
    };
    UserInfo.initialize();
})();
//Code for User view PopUp
(function () {
    var OrderInfo = {
        initialize: function () {
            this.methodLinks = jQuery('body');
            this.registerEvents();
        },
        registerEvents: function () {
            this.methodLinks.on('click', 'a[data-order-show]', this.handleMethod);
            this.methodLinks.on('click', '#show_user_modal .close', this.closeMethod);
        },
        handleMethod: function (e) {
            e.preventDefault();
            var user_id = jQuery(this).attr("data-order-show");
            var lang = jQuery(this).attr('data-lang');
            if (jQuery(this).attr("data-noActive")) {
                var noActive = jQuery(this).attr("data-order-show");
                var url = lang + "&flag=true";
            } else {
                var url = lang + "&download=yes";
            }
            jQuery.get(url, function (html) {
                jQuery('#show_user_modal .modal-body').html(html);
                jQuery('#show_user_modal').modal('show', {
                    backdrop: 'static'
                });
            });
        },
        closeMethod: function (e) {
            e.preventDefault();
            jQuery('#show_user_modal').modal('hide');
        }
    };
    OrderInfo.initialize();
})();
/* End Code for Order Show */
/* File Upload */
function singleFileUpload() {
    var file = $('.file-upload');
    //console.log(file);
    var form = $('form.form-locker');
    var textbox = file.data('display');
    //console.log(textbox);
    var uploadErrors = [];
    file.fileupload({
        url: '/ajax/uploadfile/',
        dataType: 'json',
        method: 'POST',
        autoUpload: false,
        //acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i,
        add: function (e, data) {
            $('.' + textbox).find('p').remove();
            $('#' + textbox).val('');
            $('.' + textbox).html('');
            var acceptFileTypes = /^image\/(jpe?g|png)$/i;
            if (!acceptFileTypes.test(data.originalFiles[0]['type'])) {
                uploadErrors.push('The file type allow only jpeg, jpg, png.');
            } else {
                data.submit();
            }
            if (uploadErrors.length > 0) {
                $('<p style="color: red;">Upload file error: ' + uploadErrors + '<i class="elusive-remove" style="padding-left:10px;"/></p>')
                    .appendTo('.' + textbox);
            }
        },
        done: function (e, data) {
            $('#' + textbox).val(data.files[0].name.toLowerCase());
            $('.' + textbox).html(data.files[0].name.toLowerCase());
        },
        progressall: function (e, data) {
            var progress = parseInt(data.loaded / data.total * 100, 10);
            $('#' + textbox).val(progress + '%');
            $('.' + textbox).html(progress + '%');
        },
        fail: function (e, data) {
            console.log(data);
            $.each(data.messages, function (index, error) {
                $('<p style="color: red;">Upload file error: ' + error + '<i class="elusive-remove" style="padding-left:10px;"/></p>')
                    .appendTo('#' + textbox);
            });
            $('#' + textbox).val(data.files[0].name.toLowerCase())
            $('.' + textbox).html(data.files[0].name.toLowerCase());
        }
    });
}
jQuery('body').on("focus", ".modal-dialog", function (e) {
    singleFileUpload();
});

// function to create slug from name
// @param nameFieldId -- id of the name field
// @param slugFieldId -- id of the slug field
function createSlug(nameFieldId, slugFieldId) {
    var Text = jQuery("#" + nameFieldId).val();
    Text = Text.toLowerCase();
    Text = Text.replace(/[^a-zA-Z0-9]+/g, '-');
    // alert(Text);
    jQuery("#" + slugFieldId).val(Text);
}

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

jQuery('.single-select').select2();
/* Delete Time Model Open Code */
(function () {
    var laravel = {
        initialize: function () {
            this.methodLinks = $('body');
            this.registerEvents();
        },
        registerEvents: function () {
            //this.methodLinks.on('click', this.handleMethod);
            this.methodLinks.on('click', 'a[data-method]', this.handleMethod);
        },
        handleMethod: function (e) {
            e.preventDefault();
            var link = $(this);
            var csrf_token = jQuery('meta[name="csrf-token"]').attr('content');
            var httpMethod = link.data('method').toUpperCase();
            var allowedMethods = ['PUT', 'DELETE', 'GET'];
            var extraMsg = link.data('modal-text');
            var reject = link.data('reject');
            if (reject) {
                var msg = '<i class="fa fa-exclamation-triangle fa-2x" style="vertical-align: middle; color:#f39c12;"></i>' + rejectStatus_msg + extraMsg;
            } else {
                var msg = '<i class="fa fa-exclamation-triangle fa-2x" style="vertical-align: middle; color:#f39c12;"></i>' + delete_msg + extraMsg;
            }

            // If the data-method attribute is not PUT or DELETE,
            // then we don't know what to do. Just ignore.
            if ($.inArray(httpMethod, allowedMethods) === -1) {
                return;
            }
            bootbox.dialog({
                message: msg,
                title: please_confirm,
                buttons: {
                    success: {
                        label: cancel_btn,
                        className: "btn-default",
                        callback: function () {}
                    },
                    danger: {
                        label: ok_btn,
                        className: "btn-success",
                        callback: function () {
                            var form = $('<form>', {
                                'method': 'POST',
                                'action': link.attr('href')
                            });
                            var hiddenInput = $('<input>', {
                                'name': '_method',
                                'type': 'hidden',
                                'value': link.data('method')
                            });
                            var tokenInput = $('<input>', {
                                'name': '_token',
                                'type': 'hidden',
                                'value': csrf_token
                            });
                            form.append(tokenInput);
                            form.append(hiddenInput).appendTo('body').submit();
                        }
                    }
                }
            });
        }
    };
    laravel.initialize();
})();