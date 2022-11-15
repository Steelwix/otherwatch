$(".wrap-spell").click(function () {
    // Close all open windows
    $(".content").stop().slideUp(0);
    // Toggle this window open/close
    $(this).next(".content").stop().slideToggle(0);
});