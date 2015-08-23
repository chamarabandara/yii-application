<?php

/**
 * MainMenu is a widget displaying main menu items.
 */
class MainMenu extends CWidget {

    public $items = array();
    public $active = '';
    public $subActive = '';
    public $activeMap = array(
        'Advertisements' => array(
            array('value' => 'advertisements/advertisement/index'),
            array('value' => 'advertisements/advertisement/create'),
            array('value' => 'advertisements/advertisement/review'),
            array('value' => 'advertisements/advertisement//index'),
            array('value' => 'advertisements/advertisement/addanalytics'),
            array('value' => 'advertisements/advertisement/sequence'),
             array('value' => 'advertisements/advertisement/categorylist'),
            
            array('subItems' => array(
                    'Manage Advertisements' => array(
                        array('value' => 'advertisements/advertisement/index')
                    ),
                    'Manage Main Category Advertisements' => array(
                        array('value' => 'advertisements/advertisement/create')
                    ),
                    'Category Advertisements order' => array(
                        array('value' => '/admin/advertiser/index')
                    ),
                )
            ),
        ),
        'Vendor' => array(
            array('value' => 'vendor/vendor/index'),
            array('value' => 'vendor/vendor/create')
        ),
        'Manage Users' => array(
            array('value' => 'users/user/index'),
            array('value' => 'users/user/create')
        ),
        'Url Manager' => array(
            array('value' => 'urlmanager/urlManager/index'),
            array('value' => 'urlmanager/urlManager/create'),
            array('value' => 'urlmanager/urlManager/update'),
            array('value' => 'urlmanager/urlManager/delete')
        ),
        'Push Notification' => array(
            array('value' => 'pushnotifications/push/index'),
            array('value' => 'pushnotifications/push/create'),
        ),
        'Analytics' => array(
            array('value' => 'analytics/analytics/index'),
        ),
    );

    public function determineActive() {

        $controller = $this->controller;
        $controllerName = $controller->id . '/';
        $module = $controller->module === null ? '' : $controller->module->id . '/';
        $action = $controller->action->id;
        $path = strtolower($module . $controllerName . $action);
        $i = 0;
        foreach ($this->activeMap as $key => $listUrls) {
          
            foreach ($listUrls as $k => $list) {
                   
                $tmp = $path;
                if (isset($list['params'])) {

                    foreach ($list['params'] as $param) {
                        $value = TK::get($param);

                        if ($value)
                            $tmp .= '/' . $param . '/' . $value;
                    }
                }

        // $lsiVal = ($list['value'])?$list['value']:'';
                if (isset($list) && isset($list['value'])&& strtolower($tmp) === strtolower($list['value'])) {

                    $this->active = $key;
                    return;
                }
            }
        
            $i++;
                }
    }

    public function run() {
        if (!Yii::app()->user->isGuest) {


            if (count($this->items) > 0) {
                $html = $this->renderMenu($this->items);

                echo $html;
            }
        }
    }

      public function checkSubLink() {
        return $addverArray = array(
            'index', 'create', 'review'
        );
    }

    protected function renderMenu($items) {
        $html = '<ul id="nav">';
        foreach ($items as $item) {
            $this->active = '';
            $this->determineActive();
            // print_r($item);exit;

            if ($item['label'] == $this->active) {
                $html.='
            <li>
             <div class="tab-pane active float-left">
        <div style="width:100%;" class="float-left div-inner">
          <div class="tab-left static-bg float-left"></div>
          <div class="tab-bg hor-bg float-left"><a href="' . Yii::app()->createUrl($item['url']) . '">' . $item['label'] . '</a></div>
          <div class="tab-right  static-bg float-left"></div>
        </div>
      </div>';

                if (isset($item['items']) && !is_null($item['items']) && !empty($item['items'])) {

                    $html .='<ul class="inner-links">';
                    foreach ($item['items'] as $itemsVal) {
                        $controller = $this->controller;

                        if ($controller->action->id == 'categorylist' && $itemsVal['label'] == 'Manage Main Category Advertisements') {
                            $html .='<li>';
                            $html .='<div class="tab-pane active float-left">';


                            $html .='<div style="width:100%;" class="float-left div-inner">
                                <div class="tab-left static-bg float-left"></div>
                                <div class="tab-bg hor-bg float-left"><a href="' . Yii::app()->createUrl($itemsVal['url']) . '">' . $itemsVal['label'] . '</a></div>
                                <div class="tab-right  static-bg float-left"></div>
                              </div>
                            </div>
                            </li>';
                        } elseif ($controller->action->id == 'sequence' && $itemsVal['label'] == 'Category Advertisements Order') {
                            $html .='<li>';
                            $html .='<div class="tab-pane active float-left">';


                            $html .='<div style="width:100%;" class="float-left div-inner">
                                <div class="tab-left static-bg float-left"></div>
                                <div class="tab-bg hor-bg float-left"><a href="' . Yii::app()->createUrl($itemsVal['url']) . '">' . $itemsVal['label'] . '</a></div>
                                <div class="tab-right  static-bg float-left"></div>
                              </div>
                            </div>
                            </li>';
                        } elseif (in_array($controller->action->id, $this->checkSubLink()) && $itemsVal['label'] == 'Manage Advertisements') {
                            $html .='<li>';
                            $html .='<div class="tab-pane active float-left">';


                            $html .='<div style="width:100%;" class="float-left div-inner">
                                <div class="tab-left static-bg float-left"></div>
                                <div class="tab-bg hor-bg float-left"><a href="' . Yii::app()->createUrl($itemsVal['url']) . '">' . $itemsVal['label'] . '</a></div>
                                <div class="tab-right  static-bg float-left"></div>
                              </div>
                            </div>
                            </li>';
                        } else {
                            $html .='<li>';
                            $html .='<div class="tab-pane in-active float-left">';


                            $html .='<div style="width:100%;" class="float-left div-inner">
            <div class="tab-left static-bg float-left"></div>
            <div class="tab-bg hor-bg float-left"><a href="' . Yii::app()->createUrl($itemsVal['url']) . '">' . $itemsVal['label'] . '</a></div>
            <div class="tab-right  static-bg float-left"></div>
          </div>
        </div>
        </li>';
                        }
                    }
                    $html .='</ul>';
                }
                $html .='</li>';
            } else {
                $html.='
  <li>
      <div class="tab-pane in-active float-left">
        <div style="width:100%;" class="float-left div-inner">
          <div class="tab-left static-bg float-left"></div>
          <div class="tab-bg hor-bg float-left"><a href="' . Yii::app()->createUrl($item['url']) . '">' . $item['label'] . '</a></div>
          <div class="tab-right  static-bg float-left"></div>
        </div>
      </div></li>';
            }
        }
        $html.='</ul>';
        return $html;
    }

}
