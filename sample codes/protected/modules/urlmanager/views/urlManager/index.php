<!--
Peachtree 
URL grid view
@author Chamara Bandara
@copyright Copyright &copy; 2014 Allion Technologies (Pvt) Ltd
-->

<?php
//Advance search for URL
Yii::app()->clientScript->registerScript('search', "
$('#search-form').submit(function(){
   $.fn.yiiGridView.update('url-grid', {
        data: $(this).serialize()
    });
    return false;
});
");
?>

<!--refresh URL grid-->
<script>
    $('#update-grid-button').live('click', function()
    {
        // var inputSelector=$('#Advertisement_status').val('');
        var id = 'url-grid';
        var inputSelector = '#Url_name,' + '#Url_created_date,' + '#Url_created_by,' + '#Url_status';

        console.log(inputSelector);
        $(inputSelector).each(function(i, o) {
            $(o).val('');
        });
        var data = $.param($(inputSelector));

        $.fn.yiiGridView.update(id, {data: data});
        return false;
    });
</script>

<div class="tab-border tab-border-paddin-bottom-0">
    <?php $this->renderPartial('_search', array('model' => $model, 'users' => $users)); ?>
    <div>
        <div>
            <div class="grid-title">
                <div class="inner-bdr"> <span class="float-left bold-text">Url List</span>
                    <div class="clear-both"></div>
                </div>
                <div class="grid-bg">
                    <div class="grid-bg-inner-bdr">
                        <?php echo $this->renderPartial('grid', array('model' => $model)); ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="">
            <input type="button" onclick="goTo('<?php echo $this->createUrl('urlManager/create') ?>')" class="btn hor-bg btn-margin" value="Add New Url" />
        </div>

    </div>
</div>
