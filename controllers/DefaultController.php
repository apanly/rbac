<?php
/**
 * Class DefaultController
 */

namespace app\controllers;

use app\controllers\common\BaseController;

class DefaultController extends  BaseController {
	public function actionIndex(){
		return $this->render("index");
	}
}