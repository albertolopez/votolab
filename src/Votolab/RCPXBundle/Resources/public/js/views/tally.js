$(function () {
    $('.percentage').each(function(index, value) {
        $(value).jqbar({ value: $(value).data('percentage'), barColor: '#D64747', orientation: 'h', barWidth: 30 });
    })
});
