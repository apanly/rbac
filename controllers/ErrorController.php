<?php

namespace app\controllers;

use app\controllers\common\BaseController;

class ErrorController extends BaseController {

	//无权限访问页面
    public function actionForbidden(){
    	return $this->render("forbidden");
	}
}

