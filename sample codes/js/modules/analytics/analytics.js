/* 
 * ajax load filtered data analytics
 * Chamara Bandara
 */

$('#analytics-search').live('click', function(event) {
    event.preventDefault();

    var startDate = $("#Analytic_startDate").val();
    var endDate = $("#Analytic_endDate").val();
    var adId = $("#Analytic_advertisement_id").val();
    var adTitle = $("#Analytic_advertisementTitle").val();
    var baseURl = $("#hdnBaseUrl").val();
            $.ajax({
                type: "POST",
                url: baseURl,
                data: "startDate=" + startDate + "&endDate=" + endDate + "&advertisemntId=" + adId + "&adTitle=" + adTitle,
                success: function(data) {
                    console.log(data);
                    $(".analytics-wrapper").empty();
                    $(".analytics-wrapper").append(data);
                }
            });


});