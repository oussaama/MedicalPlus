$(function(){
var urlWS = "http://localhost:81/medical/web/app_dev.php/fr/nbr";
var urlWss = "http://localhost:81/medical/web/app_dev.php/fr/not";
var message = "http://localhost:81/medical/web/app_dev.php/message/panel";
var book = "http://localhost:81/medical/web/app_dev.php/fr/book";
var nbBookNotifications = function () {
    $.ajax({
        type: "POST",
        url: book,
        success: function (result) {
            $('#book').attr("data-count", result.mb[1]);
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
            $("#m").html(result.nb[1]);
            $('#message').attr("data-count", result.nb[1]);
            console.log(result.nb[1]);
        },
        error: function (e) {
            console.log(e);
        }
    });
}
var notification = function () {
    $.ajax({
        type: "POST",
        url: urlWss,
        success: function (result) {
            $('#not').attr("data-count", result.not[1]);
        },
        error: function (e) {
            console.log(e);
        }
    });
}





/*var messagePanel = function () {
 $.ajax({
 type: "POST",
 url: message,
 success: function (result) {
 $("#messagePanel").html('<ul class="cart_list product_list_widget"></ul>');
 $.each(result.message[0],function(){
 $("#messagePanel>ul").append(
 '<li>' +
 '<a href="#">' +
 '<img width="90" height="90" src="{{ asset("uploads/~' + result.message[0].picture + ') }}" class="attachment-shop_thumbnail" alt="img4">' + result.message[0].firstnameCont + " " + result.message[0].lastnameCont +
 '<span class="quantity">' + result.message[0].subjectCont + '<span class="amount">' +  + '</span></span>' +
 '</a></li>');
 });
 },
 error: function (e) {
 console.log(e);
 }
 });
 }*/
setInterval(nbBookNotifications, 2000);
setInterval(nbNewNotifications, 2000);
setInterval(notification, 2000);
//setInterval(messagePanel, 2000);

});


