(function ($) {
    "use strict";

    if (!$) {
        return;
    }

    var $popup = $(".popup_wrapper");

    if (!$popup.length) {
        return;
    }

    function closePopup() {
        $popup.fadeOut(300);
        $.cookie("cookie_popup", "monster", { path: "/" });
    }

    setTimeout(function () {
        $popup.css("opacity", "1");
    }, 500);

    $popup.on("click", ".popup_close", function () {
        closePopup();
    });

    $popup.on("click", function (event) {
        if ($(event.target).is(".popup_wrapper")) {
            closePopup();
        }
    });

    $(document).on("keyup", function (event) {
        if (event.key === "Escape" && $popup.is(":visible")) {
            closePopup();
        }
    });
})(window.jQuery);
