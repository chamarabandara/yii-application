/* 
 * js file for vendor index
 * Chamara Bandara
 */


$('#form-reset-button').live('click', function()
{
    var id = 'vendor-grid';
    var inputSelector = '#' + id + ' .filters input, ' + '#' + id + ' .filters select';
    $(inputSelector).each(function(i, o) {
        $(o).val('');
    });

    var data = $.param($(inputSelector));
    $.fn.yiiGridView.update(id, {data: data});
    return false;
});