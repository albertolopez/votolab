$(function () {
    $('[data-rating]').barrating('show', {
        showSelectedRating: true,
        onSelect: function (value, text) {
            $(this).siblings('.br-current-rating').addClass('br-current-rating-active');
        }
    });
    $("button#submitVote").validate({

    });
});
