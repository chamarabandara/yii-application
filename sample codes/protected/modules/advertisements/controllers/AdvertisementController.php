<?php

class AdvertisementController extends Controller {

    public $layout;

    public function filters() {
        return array(
            'accessControl',
        );
    }

    public function accessRules() {

        if( Yii::app()->user->getState('roleId') == Yii::app()->params['system_user']){
               $arr =array('index', 'create', 'LoadSubCats','EditSubCategory','DeleteSubCategory','SubCategory', 'categorylist','review','LoadAdvertisement','loadcities','GetAdvertisementDescription','loadsubcategory','sequence');   // give all access to admin
          }else if(Yii::app()->user->getState('roleId') == Yii::app()->params['merchant_user']){
               $arr = array('index','create','review','SubCategory','EditSubCategory','DeleteSubCategory'); 
          }
          else{
            $arr = array('');          //  no access to other user
          }

        return array(
            array('allow',
                'actions' => $arr,
                'users' => array('@')),
            array('deny', 'users' => array('*')),
        );
    }

    /**
     * action to get subcategories drowpdons for catogary id
     */

    
    public function actionLoadsubcategory(){
         $categoryId = TK::post('cat_id');
        $subCategory = SubCategory::model()->findByAttributes(array('category_id' => $categoryId,'name'=>'main sponser'));           
       
        echo json_encode($subCategory);
        
    }
    public function actions() {
        return array(
            'index' => 'advertisements.controllers.advertisement.IndexAction',
            'create' => 'advertisements.controllers.advertisement.CreateAction',
            'review' => 'advertisements.controllers.advertisement.ReviewAction',
            'LoadSubCats' => 'advertisements.controllers.advertisement.LoadSubCatsAction',
            'LoadAdvertisement' => 'advertisements.controllers.advertisement.LoadAdvertisementAction',
            'loadcities'=>'advertisements.controllers.advertisement.LoadCitiesAction',
            'GetAdvertisementDescription'=>'advertisements.controllers.advertisement.GetAdvertisementDescriptionAction',
             'categorylist' => 'advertisements.controllers.advertisement.CategoryAdvertisementAction',
            'sequence' => 'advertisements.controllers.advertisement.SequenceAction',
             'SubCategory' => 'advertisements.controllers.advertisement.SubCategoryAction',
            'EditSubCategory' => 'advertisements.controllers.advertisement.EditSubCategoryAction',
            'DeleteSubCategory' => 'advertisements.controllers.advertisement.DeleteSubCategoryAction',
                );
    }

   
}