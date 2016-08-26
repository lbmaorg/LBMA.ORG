jQuery(function($){
    if($("#rsvp_form").length > 0)
    {
        jQuery('#rsvp_form #back').hide();
        jQuery('#rsvp_form #first').css("opacity",1);
        jQuery('#rsvp_form #same_info').click(function($){
                
            if(jQuery(this).is(':checked'))
            {
                jQuery('#rsvp_billing_first_name').val(jQuery('#rsvp_first_name').val());
                jQuery('#rsvp_billing_last_name').val(jQuery('#rsvp_last_name').val());
                jQuery('#rsvp_billing_address_1').val(jQuery('#rsvp_address_1').val());
                jQuery('#rsvp_billing_address_2').val(jQuery('#rsvp_address_2').val());
                jQuery('#rsvp_billing_city').val(jQuery('#rsvp_city').val());
                jQuery('#rsvp_billing_state').val(jQuery('#rsvp_state').val());
                jQuery('#rsvp_billing_postcode').val(jQuery('#rsvp_postcode').val());
            }else{
                jQuery('#rsvp_billing_first_name').val("");
                jQuery('#rsvp_billing_last_name').val("");
                jQuery('#rsvp_billing_address_1').val("");
                jQuery('#rsvp_billing_address_2').val("");
                jQuery('#rsvp_billing_city').val("");
                jQuery('#rsvp_billing_state').val("");
                jQuery('#rsvp_billing_postcode').val("");
            }
        });
        $("#rsvp_form").bind("step_shown", function(event, data){
            if(data.isFirstStep)
            {
                jQuery('#back').hide();
                jQuery('#back').addClass('ui-state-disabled');
            }else{
                jQuery('#back').show();
                jQuery('#back').removeClass('ui-state-disabled');
            }
        });
        $("#rsvp_form").formwizard({ 
            formPluginEnabled: true,
            validationEnabled: true,
            focusFirstInput : true,
            disableUIStyles: true,
            textNext: "Next:Billing Info",
            formOptions :{
                success: function(data){
                   $("#rsvp_form").hide();
                    $("div.grid-bg").append("<h3 style='min-height:708px;text-align:center;'>Your event request updated successfully. Our support team will keep you in touch.</h3>")
                    $.unblockUI();
                },
                beforeSubmit: function(data){
                    $("#data").html("data sent to the server: " + $.param(data));
                     $.blockUI({
                        message:"Please wait..."
                    })
                },
                dataType: 'json',
                resetForm: true
            }	
        });
    }    
});