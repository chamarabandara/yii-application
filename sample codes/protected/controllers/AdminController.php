<?php

/* Peachtree 
 * Admin Controller
 * @author Chamara Bandara
 * @copyright Copyright &copy; 2014 Allion Technologies (Pvt) Ltd
 */

class AdminController extends Controller {

    public function actions() {
        return array();
    }

    //admin index action
    public function actionIndex() {
        $this->redirect('admin/login', array('model' => $model));
    }

    //login action
    public function actionLogin() {
        $this->layout = 'login';
        $model = new LoginForm;

        // if it is ajax validation request
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'login-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        // collect user input data
        if (isset($_POST['LoginForm'])) {
            $model->attributes = $_POST['LoginForm'];
            // validate user input and redirect to the previous page if valid
            if ($model->validate() && $model->login())
                $this->redirect(Yii::app()->params['hostname'] . '/advertisements/advertisement/index');
        }
        // display the login form
        $this->render('/admin/login', array('model' => $model));
    }

    /**
     * Logs out the current user and redirect to homepage.
     */
    public function actionLogout() {
        Yii::app()->user->logout();
        $this->redirect('login');
    }

    public function actionForgotPassword() {
        $this->layout = 'login';
        $user = new User();
        $user->setScenario('forgotpw');

        if (!Yii::app()->user->isGuest) {
            $this->redirect($controller->createUrl('/index'));
        }

        if (isset($_POST['Send'])) {

            $user->attributes = $_POST['User'];

            //recover password and send email
            if ($user->count('email = :email', array('email' => $user->email)) > 0) {
                $user = User::model()->findByAttributes(array('email' => $user->email));

                $passwordGen = new PasswordGenerator();
                $newPassword = $passwordGen->randomPassword();

                $emailContent = $this->renderPartial('forgotPasswordEmail', array('password' => $newPassword), true);

                $this->attachBehavior('email', 'EmailBehavior');

                if (!$this->sendEmail($user->email, 'Peachtree Admin Password', $emailContent, Yii::app()->params['mailer']['mail_from'], Yii::app()->params['mailer']['mail_reply'])) {
                    Yii::app()->user->setFlash('error', 'Error sending password.');
                    $this->render('fogotpw', array('user' => $user));
                } else {
                    $user->password = md5($newPassword);
                    $user->confPassword = $user->password;
                    //print_r($user->password);exit;
                    if (!$user->save())
                        ;
                    //  print_r ($user->getErrors ());exit;
                    $user = new User();
                    Yii::app()->user->setFlash('success', 'Password sent successfully.');
                    $this->render('fogotpw', array('user' => $user));
                }
            } else {
                Yii::app()->user->setFlash('error', 'Please insert a valid email address.');
                $this->render('fogotpw', array('user' => $user));
            }
        } else {
            $this->render('fogotpw', array('user' => $user));
        }
    }

    public function actionUpdate() {

        $user = User::model()->find('id=:id', array(':id' => Yii::app()->user->getState('loggedUserId')));

        if (isset($_POST['Save'])) {
            $isUpdate = true;
            $user->email = $_POST['User']['email'];

            if (trim($_POST['User']['oldPassword']) != '') {
                $oldPwd = md5(trim($_POST['User']['oldPassword']));
                if ($oldPwd == $user->password) {
                    $newPwd = trim($_POST['User']['password']);
                    $confPwd = trim($_POST['User']['confPassword']);
                    if (trim($_POST['User']['password']) != '' && $newPwd == $confPwd) {
                        $user->password = $newPwd;
                    } else {
                        $isUpdate = false;
                        Yii::app()->user->setFlash('error', 'Password and Confirm Password are incorrect');
                    }
                } else {
                    $isUpdate = false;
                    Yii::app()->user->setFlash('error', 'Old password is incorrect');
                }
            }
            if ($isUpdate) {
                if ($user->update()) {
                    Yii::app()->user->setFlash('success', 'Profile edited successfully');
                } else {
                    Yii::app()->user->setFlash('error', 'Error editing profile');
                }
            }
        }
        $user->password = '';
        $this->render('update', array('user' => $user));
    }

}