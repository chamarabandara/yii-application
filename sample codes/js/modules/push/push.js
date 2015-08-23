/**
 * Javascript module related to Push nortification module.
 * Please note that some codes are moved from the view files to this JS file.
 * 
 * The JS file is registered in the layout file. If this file is already located
 * inside an asset folder, in "app/assets/.." path, chances are the new modification
 * to this file will not be applied to the asset file. Therefore remove the relavent
 * asset folder, and re-run the applicaiton.
 
 */

function initPushNortificationForm(datePickerImgUrl, vendorUrl) {

    $("#PushNotification_country").change(function(e) {
        var cityUrl = $("#hdnCityUrl").val();
        var countryId = $(this).val();
        $.ajax({
            type: "POST",
            url: cityUrl,
            data: "country_id=" + countryId,
            dataType: "json",
            success: function(data) {
                $('#PushNotification_city').html('').append('<option value="">- - Select - -</option>');
                $.each(data, function(i, v) {
                    $('#PushNotification_city').append('<option value="' + v.id + '">' + v.name + '</option>');
                });
            }
        });
    });


    //time picker
    $('#txt_start_time').timepicker({
        ampm: true,
        timeFormat: 'h:mm TT'
    });

    //time picker
    $('#txt_end_time').timepicker({
        ampm: true,
        timeFormat: 'h:mm TT'
    });

    // Distance slider
    $('#PushNotification_distance_slider').slider({
        'min': 1,
        'max': 160,
        'step': 0.10,
        'z-index': 1,
        'value': jQuery('#PushNotification_distance').val(),
        'slide': function(event, ui) {
            jQuery('#PushNotification_distance').val(ui.value);
        }
    });

    var d = new Date()
    var n = -d.getTimezoneOffset() / 60;
    $('#timezoneoffset').val(n);
    loadFilterdForm();
    chkMessage();

    $('#PushNotification_merchant').change(function(e) {
        $('#PushNotification_is_logo').attr('checked', false);
        $("#hidden_url").hide();
        var couponUrl = $("#hdnCouponLoadUrl").val();
        var merchantId = $(this).val();
        $.ajax({
            type: "POST",
            url: couponUrl,
            data: "vendor_id=" + merchantId,
            dataType: "json",
            success: function(data) {
                $('#PushNotification_offer').html('').append('<option value="">- - Select - -</option>');
                $.each(data, function(i, v) {
                    $('#PushNotification_offer').append('<option value="' + v.id + '">' + v.name + '</option>');
                });
            }
        });
    });

    $('#PushNotification_is_offer_title').change(function() {
        if (this.checked) {
            if ($("#PushNotification_offer").val() != '') {
                var couponUrl = $("#hdnCouponDescUrl").val();
                var OfferId = $("#PushNotification_offer").val();
                $.ajax({
                    type: "POST",
                    url: couponUrl,
                    data: "coupon_id=" + OfferId,
                    dataType: "json",
                    success: function(data) {
                        $.each(data, function(i, v) {
                            $("#PushNotification_message").val(v.name);


                        });
                    }
                });
            }
            else {
                alert('Offer not selected.');
                $('#PushNotification_is_offer_title').attr('checked', false);
            }
        }
        else {
            $("#PushNotification_message").attr("readonly", false);
            $("#PushNotification_message").val("");
        }

    });

    $('#PushNotification_is_logo').change(function() {
        if (this.checked) {
            if ($("#PushNotification_merchant").val() != '') {

                var merchantLogoUrl = $("#hdnMerchantLogoUrl").val();

                var MerchantId = $("#PushNotification_merchant").val();
                $("#hidden_url a").attr('href', vendorUrl + MerchantId);
                $("#hidden_url").hide();
                $.ajax({
                    type: "POST",
                    url: merchantLogoUrl,
                    data: "vendor_id=" + MerchantId,
                    dataType: "html",
                    success: function(data) {

                        if (data == "") {
                            alert("Merchant doese not have a Logo, Please Click the link to Upload a Logo");
                            $("#hidden_url").show();
                            $('#PushNotification_is_logo').attr('checked', false);
                        }
                    }
                });
            }
            else {
                alert('Merchant not selected.');
                $('#PushNotification_is_logo').attr('checked', false);
            }
        } else {
            $("#hidden_url").hide();
        }
    });

    $('#PushNotification_method').change(function(e) {
        if ($('#PushNotification_method').val() == '' || $('#PushNotification_method').val() == '1') {
            $('#e-card').hide();
            $('#country').hide();
            $('#city').hide();
            $('#location').hide();
            $('#favourite').hide();
            $('#gender').hide();
        }
        else if ($('#PushNotification_method').val() == '2') { //ecard
            $('#e-card').show();
            $('#country').hide();
            $('#city').hide();
            $('#location').hide();
            $('#favourite').hide();
            $('#gender').hide();
        }
        else if ($('#PushNotification_method').val() == '3') { //place
            $('#e-card').hide();
            $('#country').show();
            $('#city').show();
            $('#location').hide();
            $('#favourite').show();
            $('#gender').show();
        }
        else if ($('#PushNotification_method').val() == '4') { //distance
            $('#e-card').hide();
            $('#country').hide();
            $('#city').hide();
            $('#location').show();
            $('#favourite').show();
            $('#gender').show();
        }
    });


    function loadFilterdForm() {
        if ($('#PushNotification_method').val() == '' || $('#PushNotification_method').val() == '1') {
            $('#e-card').hide();
            $('#country').hide();
            $('#city').hide();
            $('#location').hide();
            $('#favourite').hide();
            $('#gender').hide();
        }
        else if ($('#PushNotification_method').val() == '2') { //ecard
            $('#e-card').show();
            $('#country').hide();
            $('#city').hide();
            $('#location').hide();
            $('#favourite').hide();
            $('#gender').hide();
        }
        else if ($('#PushNotification_method').val() == '3') { //place
            $('#e-card').hide();
            $('#country').show();
            $('#city').show();
            $('#location').hide();
            $('#favourite').show();
            $('#gender').show();

        }
        else if ($('#PushNotification_method').val() == '4') { //distance
            $('#e-card').hide();
            $('#country').hide();
            $('#city').hide();
            $('#location').show();
            $('#favourite').show();
            $('#gender').show();
        }
    }

    function chkMessage() {
        if ($('#PushNotification_is_offer_title').is(':checked')) {
            $("#PushNotification_message").attr("readonly", false);
        }
    }
}

$(document).ready(function() {
    /**
     * Change any element with 'utc-date' class into local datetime. 
     */
    $('.utc-date').each(function() {
        var dateTimeStr = $(this).html().replace(/-/g, "/"); // '-' replaced by '/'
        var dateObj = new Date(dateTimeStr + " UTC");// create a dateObj representing local datetime
        // 'UTC' is added to tell the time is in UTC timezone

        var localDateTimeString = dateObj.getFullYear() + "-"; // add year
        localDateTimeString += ("0" + (dateObj.getMonth() + 1)).slice(-2) + "-"; // add month
        localDateTimeString += ("0" + dateObj.getDate()).slice(-2) + " ";  // add month

        var hours = dateObj.getHours();
        if (hours >= 12) {
            hours = hours - 12;
        }

        if (hours == 0) {
            hours = 12;
        }

        localDateTimeString += hours + ":";
        localDateTimeString += ("0" + dateObj.getMinutes()).slice(-2) + " ";
        if (dateObj.getHours() < 12)
            localDateTimeString += "AM";
        else
            localDateTimeString += "PM";

        $(this).html(localDateTimeString);
    });
});

$(document).ready(function() {
    $('#PushNotification_is_offer_title').change(function() {

        if ($('#PushNotification_mobile_type').val() == 1 || $('#PushNotification_mobile_type').val() == 3) {
            $("#PushNotification_message").attr("readonly", false);
        } else {
            $("#PushNotification_message").attr("readonly", true);
        }
    });
});
