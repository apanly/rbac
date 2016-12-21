<?php
/**
 * Class TestController
 */

namespace app\controllers;


use app\controllers\common\BaseController;

class TestController extends  BaseController {
	public function actionPage1(){
		return $this->render("page1");
	}

	public function actionPage2(){
		return $this->render("page2");
	}

	public function actionPage3(){
		return $this->render("page3");
	}

	public function actionPage4(){
		return $this->render("page4");
	}

	public function actionPage5(){
		return $this->render("page5");
	}
}