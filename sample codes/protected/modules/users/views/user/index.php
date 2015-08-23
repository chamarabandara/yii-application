<!-- 
Peachtree 
Vendor Controller
@author Chamara Bandara
@copyright Copyright &copy; 2014 Allion Technologies (Pvt) Ltd
-->         
<div class="tab-border tab-border-paddin-bottom-0">

    <div>
        <div class="grid-title">
            <div class="inner-bdr"> <span class="float-left bold-text">User List</span>
                <div class="clear-both"></div>
            </div>
            <div class="grid-bg">
                <div class="grid-bg-inner-bdr">
                    <?php echo $this->renderPartial('grid', array('users' => $users)); ?>
                </div>
            </div>
        </div>
    </div>
    <div class="">
        <input type="button" onclick="goTo('<?php echo $this->createUrl('user/create') ?>')" class="btn hor-bg btn-margin" value="Add New User" />
    </div>

</div>
