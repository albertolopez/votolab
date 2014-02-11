(function ($, B) {
    $(function () {
        B.core.namespace('Views.Election', {
            init: function () {
                console.log("HHH", Math.random());
                $('li.candidate').on('click', function (event) {
                    event.preventDefault();
                    var $this = $(event.currentTarget), target = $this.find('[data-panel]');
                    if (target.is(':visible')) {
                        target.slideUp(function () {
                        });
                    } else {
                        target.slideDown(function () {
                        });
                    }
                })
            }
        });
    });
})(jQuery, barlovento);