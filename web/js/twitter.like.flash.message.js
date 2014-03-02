//Provide a variable to hold the callback function
var notifyCallBack;

function showNotification(message, type, callback) {

    notifyCallBack = callback;

    var notification = $("#notification");
    notification.removeClass("success notice error");
    notification.addClass(type);

    //Make sure it's visible even when top of the page not visible
    notification.css("width", notification.parent().width());

    $("#notification-text").html(message);

    //show the notification
    $("#notification").slideDown("slow", function() {
        setTimeout(hideNotification,
            7000 // 7 seconds
            );
    });
}

function hideNotification() {
    $("#notification").slideUp("slow", function() {
        if (null != notifyCallBack && (typeof notifyCallBack == "function")) {
            notifyCallBack();
        }
        //reset the callback variable
        notifyCallBack = null;
    });
}
