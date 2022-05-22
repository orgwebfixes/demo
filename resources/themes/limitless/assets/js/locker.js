jQuery("#document_id").on("change", function (event) {
    add_locker_data(jQuery(this).val().trim());
});
if(jQuery('#document_id').is(':disabled')){
    add_locker_data(jQuery("#document_id option:selected").val().trim());
}
function add_locker_data (document_id) {
    var csrf_token = jQuery('meta[name="csrf-token"]').attr('content');
    if(document_id !== "" && document_id !== null){
        console.log(document_id);
        var url = "/ajax/documentitems";
        jQuery.ajax({
            type:"post",
            url: "/ajax/documentitems",
            data:{
                _token : csrf_token,
                document_id:document_id
            },
            success:function(result){
                jQuery("div.locker-document").empty();
                jQuery.each(result, function(k, v) {
                    var hasstik = classname = spantag = '';
                    if (v.validation.indexOf("required") >= 0){
                        hasstik = '<span class="has-stik">*</span>';
                    }
                    if (v.field_type === 'text'){
                        classname = 'form-control control';
                    }else{
                        classname = 'file-upload control';
                        spantag = '<input class="items'+k+'" id="items'+k+'" value="" name="items['+k+'][ajax_file]" type="hidden">';
                    }
                    var table = jQuery('div.locker-document');
                    var append_data = '<div class="form-group dynamic" data-tdname="items.'+k+'.value">';
                    append_data += '<label for="'+v.label+'" class="text-capitalize col-sm-3 control-label">'+v.label+':'+hasstik+'</label>';
                    append_data += '<div class="col-sm-4">';
                    append_data += '<input autocomplete="off" class="'+classname+'" data-display="items'+k+'" id="items['+k+'][value]" name="items['+k+'][value]" accept="image/*" type="'+v.field_type+'">';
                    append_data += spantag;
                    append_data += '<input autocomplete="off" id="document_field_id" value="'+v.id+'" name="items['+k+'][document_field_id]" type="hidden">';
                    append_data += '<input id="document_field_id" value="'+v.field_type+'" name="items['+k+'][field_type]" type="hidden">';
                    append_data += '<input id="validation" value="'+v.validation+'" name="items['+k+'][validation]" type="hidden">';
                    append_data += '<input id="label" value="'+v.label+'" name="items['+k+'][label]" type="hidden">';
                    append_data += '</div>';
                    append_data += '<div class="col-sm-4">';
                    append_data += '<span class="items'+k+'"></span>';
                    append_data += '</div>';
                    append_data += '</div>';
                    jQuery("#locker-document").append(append_data);
                });
            }
        });
    }
}