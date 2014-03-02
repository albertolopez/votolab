$(function () {
    $('[data-rating]').barrating('show', {
        showSelectedRating: true,
        onSelect: function (value, text) {
            $(this).siblings('.br-current-rating').addClass('br-current-rating-active');
        }
    });
    $("button#submitVote").click(function () {
        var valid = true;
        $.each($(this).parents('form').find('[data-rating]'), function () {
            var criterion = $(this).parent('.form-group');
            if (!$(this).val()) {
                criterion.addClass('has-error');
                criterion.find('.input-error').removeClass('hide');
                valid = false;
            } else {
                criterion.find('.input-error').addClass('hide');
            }
        })
        if (valid === true) {
            var candidate = $(this).parents('[data-candidate]').data('candidate');
            var ratings = $(this).parents('[data-ratings]').data('rating');
            console.log( $( this ).parents('form').serialize() );
            $.ajax({
                type: "POST",
                url: Routing.generate('votolab_vote', {slug: $('[data-election]').data('election')}),
                data: {
                    candidate: candidate,
                    ratings: ratings
                }
            })
        }
    });
});
