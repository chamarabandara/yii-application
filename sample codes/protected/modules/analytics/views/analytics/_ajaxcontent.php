<?php 

?>
<div class="analytics-wrapper">
    <div class="analytics-left-wrapper">
        <ul>
            <li><strong>Number of impressions:</strong><?php echo (!empty($impressionCount)) ? ' '.$impressionCount : ' 0'; ?></li>
            <li><strong>Number of touch-through's to the detail:</strong><?php echo (!empty($$detailCount))? ' '.$detailCount :' 0'; ?></li>
            <li><strong>Number of times the web site link:</strong><?php echo (!empty($$webCount))? ' '.$webCount : ' 0'; ?></li>
            <li><strong>Number of times the Twitter icon was touched :</strong><?php echo (!empty($$twitterCount))? ' '.$twitterCount :' 0'; ?></li>
        </ul>
    </div> 

    <div class="analytics-right-wrapper">
        <ul>
            <li><strong>Total impression time:</strong><?php echo (!empty($$impressionTime))?' '.$impressionTime . " Seconds" : " 0 Seconds"; ?></li>
            <li><strong>Number of times the Map:</strong><?php echo (!empty($$mapCount))?' '.$mapCount : ' 0'; ?></li>
            <li><strong>Number of times the Phone number was touched:</strong><?php echo (!empty($$callCount))? ' '.$callCount :' 0'; ?></li>
            <li><strong>Number of times the Facebook icon was touched:</strong><?php echo (!empty($$fbCount))? ' '.$fbCount : ' 0'; ?></li>
        </ul>
    </div>
</div>
<div class="clear-both"></div>
