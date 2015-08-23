/* 
 * advertisement js
 * Chamara Bandara
 */

//intialize sub category droup down 
function initialize_dropdown() {
    options = $('#Advertisement_category_id').html();
    $('#Advertisement_category_id').remove();
    $('#cat-list').html('<select data-placeholder="- - Select - -" class="txt-common" id="Advertisement_category_id" name="Advertisement[category_id][]" style="display: none;"></select>');
    $('#Advertisement_category_id').html(options);
}


$(document).ready(function() {
//sub categry add
    $('#add_cat').live('click', function(event) {

        event.preventDefault();
        $('#pop-sure').hide();
        $('#pop_sub_category_name').attr('disabled', false);
        var check_cat_id = $('#Advertisement_category_id option:selected').val();
        var baseURL = $(".baseUrl").val();
        if (check_cat_id != '') {
            jQuery.fn.extend({
                propAttr: $.fn.prop || $.fn.attr
            });
            $('#pop_category_dialog').dialog({
                autoOpen: false,
                title: 'Add Sub Category',
                width: 400,
                height: 170,
                modal: true,
                buttons: {
                    "Save": function() {
                        var sub_cat = $('#pop_sub_category_name').val();
                        $.ajax({
                            type: 'POST',
                            url: baseURL + '/advertisements/advertisement/SubCategory',
                            data: {
                                sub_cat: sub_cat,
                                cat_id: check_cat_id
                            },
                            success: function(data) {

                                item = jQuery.parseJSON(data);
                                if (item == "saved") {
                                    $('.success-text').show();
                                    $(".success-text").text("Sub category added successfully");

                                } else if (item == "exists") {
                                    $('.success-text').show();
                                    $(".success-text").text("Sub category already exists");

                                } else {
                                    $('.error-text').show();
                                    $(".error-text").text("Errors.. try again !!");
                                }
                                $('#pop_category_dialog').dialog('close');
                            },
                            error: function(data) {
                            },
                            dataType: 'html'
                        });




                    },
                    "Close": function()
                    {
                        $(this).dialog('destroy');
                    }
                }
            });
        }
        else {
            alert('select a category');
        }


        $('#pop_category_dialog').dialog('open');
        return false;

    });
    //end add sub category

//sub category edit
    $('#edit_cat').live('click', function(event) {
        event.preventDefault();
        $('#pop-sure').hide();
        $('#pop_sub_category_name').val($('#Advertisement_sub_category_id option:selected').text());
        $('#pop_sub_category_name').attr('disabled', false);
        var check_cat_id_1 = $('#Advertisement_category_id option:selected').val();
        var baseURL = $(".baseUrl").val();
        if (check_cat_id_1 != '') {
            var sub_cat_id_1 = $('#Advertisement_sub_category_id option:selected').val();
            if (sub_cat_id_1 != '') {

                jQuery.fn.extend({
                    propAttr: $.fn.prop || $.fn.attr
                });
                $('#pop_category_dialog').dialog({
                    autoOpen: false,
                    title: 'Add Sub Category',
                    width: 400,
                    height: 170,
                    modal: true,
                    buttons: {
                        "Save": function() {
                            var sub_cat = $('#pop_sub_category_name').val();
                            var sub_id = $('#Advertisement_sub_category_id').val();
                            $.ajax({
                                type: 'POST',
                                url: baseURL + '/advertisements/advertisement/EditSubCategory',
                                data: {
                                    sub_cat: sub_cat,
                                    cat_id: check_cat_id_1,
                                    sub_id: sub_id
                                },
                                success: function(data) {

                                    item = jQuery.parseJSON(data);
                                    if (item == "saved") {
                                        $('.success-text').show();
                                        $(".success-text").text("Sub category updated successfully");

                                    } else if (item == "exists") {
                                        $('.success-text').show();
                                        $(".success-text").text("Sub category already exists");

                                    } else {
                                        $('.error-text').show();
                                        $(".error-text").text("Errors.. try again !!");
                                    }
                                    $('#pop_category_dialog').dialog('close');
                                },
                                error: function(data) {
                                },
                                dataType: 'html'
                            });




                        },
                        "Close": function()
                        {
                            $(this).dialog('destroy');
                        }
                    }
                });
            }
            else {
                alert('select a sub category');
            }

        }
        else {
            alert('select a category');
        }

        $('#pop_category_dialog').dialog('open');
        return false;

    });
//sub category edit end

//delete sub category



    $('#del_cat').live('click', function(event) {
        $('#pop-sure').show();
        $('#pop_sub_category_name').val($('#Advertisement_sub_category_id option:selected').text());
        $('#pop_sub_category_name').attr('disabled', true);
        var baseURL = $(".baseUrl").val();
        var check_cat_id_2 = $('#Advertisement_category_id option:selected').val();
        if (check_cat_id_2 != '') {
            var sub_cat_id_2 = $('#Advertisement_sub_category_id option:selected').val();
            if (sub_cat_id_2 != '') {

                jQuery.fn.extend({
                    propAttr: $.fn.prop || $.fn.attr
                });
                $('#pop_category_dialog').dialog({
                    autoOpen: false,
                    title: 'Add Sub Category',
                    width: 400,
                    height: 170,
                    modal: true,
                    buttons: {
                        "Save": function() {
                            var sub_id = $('#Advertisement_sub_category_id').val();
                            $.ajax({
                                type: 'POST',
                                url: baseURL + '/advertisements/advertisement/DeleteSubCategory',
                                data: {
                                    sub_id: sub_id
                                },
                                success: function(data) {

                                    item = jQuery.parseJSON(data);
                                    if (item == "saved") {
                                        $('.success-text').show();
                                        $(".success-text").text("Sub category deleted successfully");

                                    } else if (item == "exists") {
                                        $('.success-text').show();
                                        $(".success-text").text("Can\'t delete. Advertisement Exist for this sub category");

                                    } else {
                                        $('.error-text').show();
                                        $(".error-text").text("Errors.. try again !!");
                                    }
                                    $('#pop_category_dialog').dialog('close');
                                },
                                error: function(data) {
                                },
                                dataType: 'html'
                            });




                        },
                        "Close": function()
                        {
                            $(this).dialog('destroy');
                        }
                    }
                });
            }
            else {
                alert('select a sub category');
            }

        }
        else {
            alert('select a category');
        }


        $('#pop_category_dialog').dialog('open');
        return false;

    });
//delete sub category end
    $("#Advertisement_is_featured").live('change', function(e) {

        var featuredType = $(this).val();
        if (featuredType == '1') {

            var getId = $("#getId").val();

            if (getId == 0) {
                initialize_dropdown();
                $('#Advertisement_category_id').attr({
                    'multiple': true
                });
                $('#Advertisement_category_id').change(function() {
                    $('#Advertisement_category_id').trigger('chosen:updated');
                });
                $('#Advertisement_category_id').chosen({width: '300px'});
            }
            if (getId == 1) {
                initialize_dropdown();
                $('#Advertisement_category_id').chosen({width: '300px'});
            }


            $("#Advertisement_sub_category_id option[value='main sponser']").attr("selected", "selected");
            $('.large_image_hint').text("(Upload image size for Category Featured Advertisement 600px X 260px)");
            $('.thumb_image_hint').text("(Upload image size for Category Featured Advertisement 540px X 136px)");
            $('#Advertisement_lag_text').val("(Upload image size for Category Featured Advertisement 600px X 260px)");
            $('#Advertisement_tumb_text').val("(Upload image size for Category Featured Advertisement 540px X 136px)");
            $(".hide-sub-cat").hide();

            e.preventDefault();
        }
        if (featuredType == '2') {
            initialize_dropdown();
            $('#Advertisement_category_id').chosen({width: '300px'});
            $("#Advertisement_sub_category_id").attr("disabled");
            $('.large_image_hint').text("(Upload image size for Sub Category Featured Advertisement 260px X 260px)");
            $('.thumb_image_hint').text("(Upload image size for Sub Category Featured Advertisement 136px X 136px)");
            $('#Advertisement_lag_text').val("(Upload image size for Sub Category Featured Advertisement 260px X 260px)");
            $('#Advertisement_tumb_text').val("(Upload image size for Sub Category Featured Advertisement 136px X 136px)");

            var baseurl = $("#hdnBaseUrl").val();
            var categoryId = $('#Advertisement_category_id').val();
            var couponId = $("#hdnCouponId").val();
            $.ajax({
                type: "POST",
                url: baseurl,
                data: "cat_id=" + categoryId + "&coupon_id=" + couponId,
                success: function(data) {
                    console.log(data);
                    $("#sub_cat_td").empty();
                    $("#sub_cat_td").append(data);

                }
            });
            $(".hide-sub-cat").show();
        }
        if (featuredType == '0') {
            initialize_dropdown();
            $('#Advertisement_category_id').chosen({width: '300px', });
            $("#Advertisement_sub_category_id").attr("disabled");
            $('.large_image_hint').text("(Upload image size for Normal Advertisement 260px X 260px)");
            $('.thumb_image_hint').text("(Upload image size for Normal Advertisement 136px X 136px)");
            $('#Advertisement_lag_text').val("(Upload image size for Normal Advertisement 260px X 260px)");
            $('#Advertisement_tumb_text').val("(Upload image size for Normal Advertisement 136px X 136px)");

            var baseurl = $("#hdnBaseUrl").val();
            var categoryId = $('#Advertisement_category_id').val();
            var couponId = $("#hdnCouponId").val();
            $.ajax({
                type: "POST",
                url: baseurl,
                data: "cat_id=" + categoryId + "&coupon_id=" + couponId,
                success: function(data) {
                    console.log(data);
                    $("#sub_cat_td").empty();
                    $("#sub_cat_td").append(data);

                }
            });
            $(".hide-sub-cat").show();
        }
        e.preventDefault();

    });


//load sub category by category

    $("#Advertisement_category_id").live('change', function(e) {

        var baseurl = $("#hdnBaseUrl").val();
        var categoryId = $(this).val();
        var couponId = $("#hdnCouponId").val();
        $.ajax({
            type: "POST",
            url: baseurl,
            data: "cat_id=" + categoryId + "&coupon_id=" + couponId,
            success: function(data) {
                console.log(data);
                $("#sub_cat_td").empty();
                $("#sub_cat_td").append(data);
            }
        });
        e.preventDefault();

    });

    $(function() {
        $('#coupon-create').submit(function(e) {

            $('#loader-wraper').fadeIn();
            var height = $(document).height();
            $('#loader-wraper').css('height', height);
            $('#loader').fadeIn();
            $(this).submit();

        });
    });


    $(function() {
        $('#Advertisement_category_id').chosen({width: '300px', });
    });

});


function showInAir(checkInAir) {
    if (checkInAir == '1') {
        $('#tr1').show();
        $('#tr2').hide();
        $('#tr3').show();
        $('#trTerminalMap').show();
    } else if (checkInAir == '0') {
        $('#tr1').hide();
        $('#tr2').show();
        $('#tr3').hide();
        $('#trTerminalMap').hide();
    } else {
        $('#tr1').hide();
        $('#tr2').hide();
        $('#tr3').hide();
        $('#trTerminalMap').hide();
    }
}