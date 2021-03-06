$(function () {
    $('img').sleepyHead();
    $('iframe').sleepyHead();

    $('[data-criterion]').barrating('show', {
        showSelectedRating: true,
        onSelect: function (value, text) {
            $(this).siblings('.br-current-rating').addClass('br-current-rating-active');
        }
    });
    $("button.submitVote").on('click', function (event) {
        event.preventDefault();

        var candidate = $(this).parents('[data-candidate]').data('candidate');
        $('#valueCandidateSuccess-' + candidate).addClass('hide');
        $('[data-candidate="' + candidate + '"]').css('background-color', '#F5F5F5');

        var valid = true;
        $.each($(this).parents('form').find('[data-criterion]'), function () {
            var criterion = $(this).parent('.form-group');
            if (!$(this).val()) {
                criterion.addClass('has-error');
                criterion.find('.input-error').removeClass('hide');
                valid = false;
            } else {
                criterion.find('.input-error').addClass('hide');
            }
        });
        if (!$('#valueCandidateError-' + candidate).hasClass('hide')) {
            $('#valueCandidateError-' + candidate).addClass('hide');
        }
        if (valid === true) {
            var ratings = [];
            $.each($(this).parents('form').find('[data-criterion]'), function (index, value) {
                var criterionVote = {};
                criterionVote.index = $(this).attr('name');
                criterionVote.value = $(this).val();
                ratings.push(criterionVote);
            });

            var btn = $(this);
            btn.button('loading');
            $.ajax({
                type: "POST",
                url: Routing.generate('votolab_vote', {slug: $('[data-election]').data('election')}),
                data: {
                    ratings: ratings,
                    candidateId: candidate
                },
                success: function (data) {
                    data = $.parseJSON(data);
                    if (data.error === true) {
                        $('#valueCandidateError-' + candidate).removeClass('hide');
                    } else {
                        $('#valueCandidateSuccess-' + candidate).removeClass('hide');
                        $('[data-candidate="' + candidate + '"]').css('background-color', '#DFF0D8');
                    }

                }
            }).always(function () {
                btn.button('reset');
            });
        }
    });
});
