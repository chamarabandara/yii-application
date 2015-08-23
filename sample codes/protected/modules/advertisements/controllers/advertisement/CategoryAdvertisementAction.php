<?php


class CategoryAdvertisementAction extends CAction {

    public function run() {
        $controller = $this->getController();
        $categoryId = 7;
        //create models for view
        $category = new Category();

        $catogaries = CHtml::listData(Category::model()->findAll(), 'id', // values
                        'name'    // captions
        );
        $advertisement = Advertisement::model()->getAdvertisementByCategory(FALSE);
        if (!empty($_GET) && !is_null($_GET)) {
            $catid = $_GET['id'];
            Advertisement::model()->unsetAttributes();
            $advertisement = Advertisement::model()->getAdvertisementByCategory($catid);
        }

        $params = array(
            'category' => $catogaries,
            'categoryList' => $advertisement,
        );
        $controller->render('categorylist', $params);
    }

}
