<?php

/* Peachtree 
 * User Update Action 
 * @author Chamara Bandara
 * @copyright Copyright &copy; 2014 Allion Technologies (Pvt) Ltd
 */

class UpdateAction extends CAction {

    public function run() {
        $controller = $this->getController();
        //load model action
        $id = ($_GET['id'])?$_GET['id']:'';
        $model=$this->loadModel($id);
        $model->password = '';
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if(isset($_POST['Save']))
        {
              $model->attributes=$_POST['User'];
            if($model->save())
                $this->redirect(array('view','id'=>$model->id));
        }

         if (isset($_POST['Delete'])) {
            $model->delete();
            Yii::app()->user->setFlash('success', 'User deleted successfully');
          
        }
        
        $controller->render('update',array(
            'model'=>$model,
        ));
     
  
      
    }
    
    
    //load user model
    public function loadModel($id)
    {
        $model=User::model()->findByPk($id);
        if($model===null)
            throw new CHttpException(404,'The requested page does not exist.');
        return $model;
    }

}