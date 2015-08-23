<?php

/* Peachtree 
 * User Index Contoller Action
 * @author Chamara Bandara
 * @copyright Copyright &copy; 2014 Allion Technologies (Pvt) Ltd
 */

class IndexAction extends CAction {

    public function run() {
        $controller = $this->getController();
        $users = new User();
        $params = array(
            'users' => $users
        );
        $controller->render('index', $params);
    }

}
