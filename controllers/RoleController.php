<?php
/**
 * Class RoleController
 */

namespace app\controllers;


use app\controllers\common\BaseController;

class RoleController extends  BaseController {
	//角色列表页面
	public function actionIndex(){
		return $this->render("index");
	}

	/**
	 * 添加角色
	 * get 请求 展示页面
	 * post 保存 添加动作数据
	 */
	public function actionSet(){
		if( \Yii::$app->request->isGet ){
			return $this->render("set");
		}
	}
}