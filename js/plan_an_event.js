jQuery(function($){
    if(jQuery("#plan_an_event").length == 1)
    {
        jQuery("#plan_an_event").validate({
            rules: {
                "plan_an_event[first_name]":
                {
                    required: true,
                    minlength: 2
                },
                "plan_an_event[last_name]": {
                    required: true,
                    minlength: 2
                },
                "plan_an_event[no_of_guests]": {
                    required: true
                },
                "plan_an_event[email]": {
                    required: true,
                    email: true
                },
                "plan_an_event[event_date]": {
                    required: true,
                    minlength: 10,
                    date: true
                },
                "plan_an_event[alternate_date]": {
                    required: true,
                    minlength: 10,
                    date: true
                }
            },
            beforeSubmit: function()
            {
                $.blockUI({
                    message:"Please wait..."
                })
            },
            submitHandler: function(form) {
                var str = $(form).serialize();
                $.ajax({
                    type: "POST",
                    url: "/wp-admin/admin-ajax.php?action=plan_an_event",
                    data: str,
                    success: function(msg) {
                        $("#plan_an_event").hide();
                        $("div.grid-bg").html("<h3 style='min-height:708px;text-align:center;'>Thanks for submitting your request. We will be in touch with you shortly.</h3>")
                        $.unblockUI();
                    }
                });
            }
        });
    }

    if(jQuery("#tour_form").length == 1)
    {
        jQuery("#tour_form").validate({
            rules: {
                "tour[name_first]":
                {
                    required: true,
                    minlength: 2
                },
                "tour[name_last]": {
                    required: true,
                    minlength: 2
                },
                "tour[phone]": {
                    required: true
                },
                "tour[email]": {
                    required: true,
                    email: true
                }
            },
            beforeSubmit: function()
            {
                $.blockUI({
                    message:"Please wait..."
                })
            },
            submitHandler: function(form) {
                var str = $(form).serialize();
                $.ajax({
                    type: "POST",
                    url: "/wp-admin/admin-ajax.php?action=tour_request",
                    data: str,
                    success: function(msg) {
                        $("#plan_an_event").hide();
                        $("div.grid-bg").html("<h3 style='min-height:708px;text-align:center;'>Thanks for submitting your request. We will be in touch with you shortly.</h3>")
                        $.unblockUI();
                    }
                });
            }
        });
    }
//    $("#plan_an_event").submit(function(e) {
//        e.preventDefault();
//        var str = $(this).serialize();
//        $.blockUI({
//            message:"Please wait..."
//        })
//
//        var str = $(this).serialize();
//        $.ajax({
//            type: "POST",
//            url: "/wp-admin/admin-ajax.php?action=plan_an_event",
//            data: str,
//            success: function(msg) {
//                $("#plan_an_event").hide();
//                $("div.grid-bg").html("<h3 style='min-height:708px;text-align:center;'>Thanks for submitting your request. We will be in touch with you shortly.</h3>")
//                $.unblockUI();
//            }
//        });
//        return false;
//    });
});

jQuery(function($){
    $("#snsf-form").submit(function(e) {
        $.blockUI({
                        message:"Please wait..."
                    })
        e.preventDefault();
        var str = $(this).serialize();
        $.ajax({
            type: "POST",
            url: "/wp-admin/admin-ajax.php?action=newsletter_subscription",
            data: str,
            success: function(msg) {
                    $("#snsf-form").hide();
                    $("#snsf-wrapper").html("<h3 style='min-height:708px;text-align:center;'>Thank you for your subscription...</h3>")

                $.unblockUI();
                
            }
        });
        return false;
    });
  $("#volunteer_form").submit(function(e) {
        $.blockUI({
                        message:"Please wait..."
                    })
        e.preventDefault();
        var str = $(this).serialize();
        $.ajax({
            type: "POST",
            url: "/wp-admin/admin-ajax.php?action=volunteer_subscription",
            data: str,
            success: function(msg) {
                    $("#volunteer_form").hide();
                    $("#volunteer_form_wrapper").html("<h3 style='min-height:708px;text-align:center;'>Thanks for submitting your request. We will be in touch with you shortly.</h3>")

                $.unblockUI();
                
            }
        });
        return false;
    });
    $("#TellAFriend_Form").submit(function(e) {
        $.blockUI({
                        message:"Please wait..."
                    })
        e.preventDefault();
        var str = $(this).serialize();
        $.ajax({
            type: "POST",
            url: "/wp-admin/admin-ajax.php?action=tell_a_friend",
            data: str,
            success: function(msg) {
                jQuery('form#TellAFriend_Form')[0].reset();
                    $("#TellAFriend_Form").hide();
                    $("#TellAFriend_BoxContainerBody_thaknyou").show();

                $.unblockUI();
                
            }
        });
        return false;
    });
});
