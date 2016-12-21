<?php
/**
 * Class RoleController
 */

namespace app\controllers;


use app\controllers\common\BaseController;
use app\models\Access;
use app\models\Role;
use app\models\RoleAccess;
use app\services\UrlService;

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

	//设置角色和权限的关系逻辑
	public function actionAccess(){
		//http get 请求 展示页面
		if( \Yii::$app->request->isGet ){
			$id = $this->get("id",0);
			$reback_url =  UrlService::buildUrl("/role/index");
			if( !$id ){
				return $this->redirect( $reback_url );
			}
			$info = Role::find()->where([ 'id' => $id ])->one();
			if( !$info ){
				return $this->redirect( $reback_url );
			}

			//取出所有的权限
			$access_list = Access::find()->where([ 'status' => 1 ])->orderBy( [ 'id' => SORT_DESC ])->all();

			//取出所有已分配的权限
			$role_access_list = RoleAccess::find()->where([ 'role_id' => $id ])->asArray()->all();
			$access_ids = array_column( $role_access_list,"access_id" );
			return $this->render("access",[
				"info" => $info,
				'access_list' => $access_list,
				"access_ids" => $access_ids
			]);
		}
		//实现保存选中权限的逻辑
		$id = $this->post("id",0);
		$access_ids = $this->post("access_ids",[]);

		if( !$id ){
			return $this->renderJSON([],"您指定的角色不存在",-1);
		}

		$info = Role::find()->where([ 'id' => $id ])->one();
		if( !$info ){
			return $this->renderJSON([],"您指定的角色不存在",-1);
		}

		//取出所有已分配给指定角色的权限
		$role_access_list = RoleAccess::find()->where([ 'role_id' => $id ])->asArray()->all();
		$assign_access_ids = array_column( $role_access_list,'access_id' );
		/**
		 * 找出删除的权限
		 * 假如已有的权限集合是A，界面传递过得权限集合是B
		 * 权限集合A当中的某个权限不在权限集合B当中，就应该删除
		 * 使用 array_diff() 计算补集
		 */
		$delete_access_ids = array_diff( $assign_access_ids,$access_ids );
		if( $delete_access_ids ){
			RoleAccess::deleteAll([ 'role_id' => $id,'access_id' => $delete_access_ids ]);
		}

		/**
		 * 找出添加的权限
		 * 假如已有的权限集合是A，界面传递过得权限集合是B
		 * 权限集合B当中的某个权限不在权限集合A当中，就应该添加
		 * 使用 array_diff() 计算补集
		 */
		$new_access_ids = array_diff( $access_ids,$assign_access_ids );
		if( $new_access_ids ){
			foreach( $new_access_ids as $_access_id  ){
				$tmp_model_role_access = new RoleAccess();
				$tmp_model_role_access->role_id = $id;
				$tmp_model_role_access->access_id = $_access_id;
				$tmp_model_role_access->created_time = date("Y-m-d H:i:s");
				$tmp_model_role_access->save( 0 );
			}
		}
		return $this->renderJSON([],"操作成功~~",200 );
	}
}