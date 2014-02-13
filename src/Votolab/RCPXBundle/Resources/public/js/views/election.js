(function ($, B) {
    $(function () {
        B.core.namespace('Views.Election', {
            init: function () {
                $('[data-candidate]').on('click', function (event) {
                    event.preventDefault();
                    var $this = $(event.currentTarget), target = $this.find('[data-panel]');
                    if (target.is(':visible')) {
                        target.slideUp(function () {
                        });
                    } else {
                        target.slideDown(function () {
                        });
                    }
                });
                $('[data-rating]').barrating('show', {
                    showSelectedRating: true,
                    onSelect: function (value, text) {
                    }
                });
            }
        });
    });
})(jQuery, barlovento);