<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class FilterAnalyticsAction extends CAction {

    public function run() {
        $controller = $this->getController();
        if (Yii::app()->request->isAjaxRequest) {
            //set post value
            $startDate = ($_POST['startDate']) ? $_POST['startDate'] : null;
            $endDate = ($_POST['endDate']) ? $_POST['endDate'] : null;
            $addId = ($_POST['advertisemntId']) ? $_POST['advertisemntId'] : null;
            $AddTitle = ($_POST['adTitle']) ? $_POST['adTitle'] : null;
            //call filter function
            $dataList = Analytic::model()->getAnalyticsFlterDetails($startDate, $endDate, $addId, $AddTitle);
            $fbCount = 0;
            $twitterCount = 0;
            $webCount = 0;
            $callCount = 0;
            $detailCount = 0;
            $mapCount = 0;
            $impressionCount = 0;
            $impressionTime = 0;
            foreach ($dataList as $value) {
               // $impressionCount = $impressionCount + 1;
                if ($value['page'] == 'Detail: FB') {
                    $fbCount = $fbCount+1;
                    
                }
                if ($value['page'] == 'Detail: Twitter') {
                    $twitterCount = $twitterCount+1;
                    
                }
                if ($value['page'] == 'Detail: Call') {
                    $callCount = $callCount+1;
                    
                }
                if ($value['page'] == 'Detail: Website') {
                    $webCount = $webCount+1;
                    
                }
                if ($value['page'] == 'Detail') {
                    $detailCount = $detailCount+1;
                    
                }
                if ($value['page'] == 'Detail: Map') {
                    $mapCount = $mapCount+1;
                   
                }
                 if ($value['page'] == 'List:Category Sponsors') {
                    $impressionCount = $impressionCount + 1;
                    
                }
            }
            //time for one advertisement 7 secound
            $impressionTime = 7 * $impressionCount;
            $data = array(
                'fbCount' => $fbCount,
                'twitterCount' => $twitterCount,
                'webCount' => $webCount,
                'callCount' => $callCount,
                'detailCount' => $detailCount,
                'mapCount' => $mapCount,
                'impressionCount' => $impressionCount,
                'impressionTime' => $impressionTime
            );

            $controller->renderPartial('_ajaxcontent', $data, false, true);
        }
    }

}

?>
