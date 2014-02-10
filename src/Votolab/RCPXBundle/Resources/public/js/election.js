$(function () {
    $('li.candidate').on('click', function (event) {
        event.preventDefault();
        $(this).find('.moreInfo').toggle('slow','swing');
    })
});
