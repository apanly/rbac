<?php
/**
 * Class DefaultController
 */

namespace app\controllers;

use app\controllers\common\BaseController;

class DefaultController extends  BaseController {
	//我才是默认首页
	public function actionIndex(){
		return $this->render("index");
	}
}