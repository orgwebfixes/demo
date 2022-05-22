{{-- Country Model--}}
<div class="modal fade" id="new_country_modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

        </div>
    </div>
</div>
{{-- State Model--}}
<div class="modal fade" id="new_state_modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

        </div>
    </div>
</div>

@push('scripts')
<script type="text/javascript">

    jQuery(document).on("change","#country_id",function() {
        jQuery("#state_id").select2("val",null);
        setdisable();
    });
    setdisable();
    function setdisable () {
        if (jQuery('#country_id').val() == "") {
            jQuery(".new_state_popup").css("opacity", "0.3");
        }else {
            jQuery(".new_state_popup").css("opacity", "1");
        }
    }

    /*jQuery('.new_country_popup').on('click', function (e) {
        e.preventDefault();
        var ext_url = "&lang=en";
        if (jQuery('#lang').val() != "") {
            jQuery.get('{--!!route("countries.create",array("download"=>"yes"))!!--}' + ext_url, function (html) {
                jQuery('#new_country_modal .modal-content').html(html);
                jQuery('#new_country_modal').modal('show', {backdrop: 'static'});
                countrySubmitDynamic();
            });
        }
    });*/
    function countrySubmitDynamic() {
        jQuery('#countries_create_form input[type="submit"]').on('click submit', function (e) {
            var $form = jQuery('#countries_create_form');
            jQuery.ajax({
                type: $form.attr('method'),
                url: $form.attr('action'),
                data: $form.serialize(),
                success: function (response, status) {
                    console.log(response);
                    jQuery("select[name='country_id']").append('<option value="' + response.data.id + '">' + response.data.country + '</option>');
                    jQuery("select[name='country_id']").val(response.data.id);
                    jQuery("select[name='country_id']").trigger('change');
                    jQuery('#new_country_modal').modal('hide');
                },
                error: function (xhr, textStatus, errorThrown) {
                    associate_errors(xhr.responseJSON, $form);
                }
            });
            e.preventDefault();
        });
        jQuery('#countries_create_form a.cancel,.close').on('click', function (e) {
            e.preventDefault();
            jQuery('#new_country_modal').modal('hide');
        });
    }

    //state model

    /*jQuery('.new_state_popup').on('click', function (e) {
        e.preventDefault();
        var ext_url = "&lang=en";
        if (jQuery("#country_id").val()) {
            ext_url+='&country_id=' + jQuery("#country_id").val();
        }
        if (jQuery('#country_id').val() != "" && jQuery("#lang").val() != "") {
            jQuery.get('{--!!route("states.create",array("download"=>"yes"))!!--}' + ext_url, function (html) {
                jQuery('#new_state_modal .modal-content').html(html);
                jQuery('#new_state_modal').modal('show', {backdrop: 'static'});
                stateSubmitDynamic();
            });
        }
    });*/

    function stateSubmitDynamic() {
        jQuery('#state_create_form input[type="submit"]').on('click submit', function (e) {
            var $form = jQuery('#state_create_form');
            jQuery.ajax({
                type: $form.attr('method'),
                url: $form.attr('action'),
                data: $form.serialize(),
                success: function (response, status) {
                    console.log(response);
                    jQuery("select[name='state_id']").append('<option value="' + response.data.id + '">' + response.data.state + '</option>');
                    jQuery("select[name='state_id']").val(response.data.id);
                    jQuery("select[name='state_id']").trigger('change');
                    jQuery('#new_state_modal').modal('hide');
                },
                error: function (xhr, textStatus, errorThrown) {
                    associate_errors(xhr.responseJSON, $form);
                }
            });
            e.preventDefault();
        });
        jQuery('#state_create_form a.cancel,.close').on('click', function (e) {
            e.preventDefault();
            jQuery('#new_state_modal').modal('hide');
        });
    }
</script>
@endpush