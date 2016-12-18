<?php
/**
 * Class RoleController
 */

namespace app\controllers;


use app\controllers\common\BaseController;
use app\models\Role;

class RoleController extends  BaseController {
	//角色列表页面
	public function actionIndex(){
		$list = Role::find()->orderBy([ 'id' => SORT_DESC ])->all();

		return $this->render("index",[
			'list' => $list
		]);
	}

	public function actionAdd(){

	}

	public function actionEdit(){

	}
	/*
	 * 添加或者编辑角色页面
	 * get 展示页面
	 * post 处理添加或者编辑动作
	 */
	public function actionSet(){
		if( \Yii::$app->request->isGet ){
			$id = $this->get("id",0);
			$info = [];
			if( $id ){
				$info = Role::find()->where([ 'id' => $id ])->one();
			}
			return $this->render("set",[
				"info" => $info
			]);
		}

		$id = $this->post("id",0);
		$name = $this->post("name","");
		$date_now = date("Y-m-d H:i:s");
		if( !$name ){
			return $this->renderJSON([],"请输入合法的角色名称~~",-1);
		}
		//查询是否存在角色名相等的记录
		$role_info = Role::find()
			->where([ 'name' => $name ])->andWhere([ '!=','id',$id ])
			->one();
		if( $role_info ){
			return $this->renderJSON([],"该角色名称已存在，请输入其他的角色名称~~",-1);
		}

		$info = Role::find()->where([ 'id' => $id ])->one();
		if( $info ){//编辑动作
			$role_model = $info;
		}else{//添加动作
			$role_model = new Role();
			$role_model->created_time = $date_now;
		}
		$role_model->name = $name;
		$role_model->updated_time = $date_now;

		$role_model->save(0);
		return $this->renderJSON([],"操作成功~~",200);
	}
}