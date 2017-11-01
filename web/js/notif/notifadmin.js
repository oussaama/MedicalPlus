$(function () {
    var n = "http://localhost:81/medical/web/app_dev.php/admin/article/not";
    var urlWS = "http://localhost:81/medical/web/app_dev.php/fr/nbr";
    var notificationAdmin = function () {
        $.ajax({
            type: "POST",
            url: n,
            success: function (result) {
                if (result.not[1] > 0) {
                    $('.n').html(result.not[1]);
                }
            },
            error: function (e) {
                console.log(e);
            }
        });
    }
    var nbNewNotifications = function () {
        $.ajax({
            type: "POST",
            url: urlWS,
            success: function (result) {
                if (result.nb[1] > 0) {
                    $(".mes").html(result.nb[1]);
                }
            },
            error: function (e) {
                console.log(e);
            }
        });
    }
    setInterval(notificationAdmin, 2000);
    setInterval(nbNewNotifications, 2000);
});