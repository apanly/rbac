<?php
/**
 * Class UserController
 */

namespace app\controllers;


use app\controllers\common\BaseController;
use app\models\Role;
use app\models\User;
use app\models\UserRole;
use app\services\UrlService;

class UserController extends  BaseController{

	//用户列表
	public function actionIndex(){
		//查询所有用户
		$user_list = User::find()->where([ 'status' => 1 ])->orderBy([ 'id' => SORT_DESC ])->all();
		//判断当前用户时候有访问添加或编辑用户的权限
		$set_flag = $this->checkPrivilege( "user/set" );
		return $this->render('index',[
			'list' => $user_list,
			'set_flag' => $set_flag
		]);
	}

	/*
	 * 添加或者编辑用户页面
	 * get 展示页面
	 * post 处理添加或者编辑用户
	 */
	public function actionSet(){
		//如果是get请求则演示页面
		if( \Yii::$app->request->isGet ){
			$id = $this->get("id",0);
			$info = [];
			if( $id ){
				$info = User::find()->where([ 'status' => 1 ,'id' => $id ])->one();
			}
			//取出所有的角色
			$role_list = Role::find()->orderBy( [ 'id' => SORT_DESC ])->all();
			//取出所有的已分配角色
			$user_role_list = UserRole::find()->where([ 'uid' => $id ])->asArray()->all();
			$related_role_ids = array_column($user_role_list,"role_id");
			return $this->render('set',[
				'info' => $info,
				'role_list' => $role_list,
				"related_role_ids" => $related_role_ids
			]);
		}

		$id = intval( $this->post("id",0) );
		$name = trim( $this->post("name","") );
		$email = trim( $this->post("email","") );
		$role_ids = $this->post("role_ids",[]);//选中的角色id
		$date_now = date("Y-m-d H:i:s");

		if( mb_strlen($name,"utf-8") < 1 || mb_strlen($name,"utf-8") > 20 ){
			return $this->renderJSON([],'请输入合法的姓名~~',-1);
		}

		if( !filter_var( $email , FILTER_VALIDATE_EMAIL) ){
			return $this->renderJSON([],'请输入合法的邮箱~~',-1);
		}

		//查询该邮箱是否已经存在
		$has_in = User::find()->where([ 'email' => $email ])->andWhere([ '!=','id',$id ])->count();
		if( $has_in ){
			return $this->renderJSON([],'该邮箱已存在~~',-1);
		}
		
		$info = User::find()->where([ 'id' => $id ])->one();
		if( $info ){//如果存在则是编辑
			$model_user = $info;
		}else{//不存在就是添加
			$model_user = new User();
			$model_user->status = 1;
			$model_user->created_time =  $date_now;
		}
		$model_user->name = $name;
		$model_user->email = $email;
		$model_user->updated_time = date("Y-m-d H:i:s");
		if( $model_user->save(0) ){//如果用户信息保存成功，接下来保存用户和角色之间的关系
			/**
			 * 找出删除的角色
			 * 假如已有的角色集合是A，界面传递过得角色集合是B
			 * 角色集合A当中的某个角色不在角色集合B当中，就应该删除
			 * array_diff();计算补集
			 */
			$user_role_list = UserRole::find()->where([ 'uid' => $model_user->id ])->all();
			$related_role_ids = [];
			if( $user_role_list ){
				foreach( $user_role_list as $_item ){
					$related_role_ids[] = $_item['role_id'];
					if( !in_array( $_item['role_id'],$role_ids ) ){
						$_item->delete();
					}
				}
			}
			/**
			 * 找出添加的角色
			 * 假如已有的角色集合是A，界面传递过得角色集合是B
			 * 角色集合B当中的某个角色不在角色集合A当中，就应该添加
			 */

			if ( $role_ids ){
				foreach( $role_ids as $_role_id ){
					if( !in_array( $_role_id ,$related_role_ids ) ){
						$model_user_role = new UserRole();
						$model_user_role->uid = $model_user->id;
						$model_user_role->role_id = $_role_id;
						$model_user_role->created_time = $date_now;
						$model_user_role->save(0);
					}
				}
			}
		}
		return $this->renderJSON([],'操作成功~~');
	}




	//用户登录页面
	public function actionLogin(){
		return $this->render("login",[
			'host' => $_SERVER['HTTP_HOST']
		]);
	}

	//伪登录业务方法,所以伪登录功能也是需要有auth_token
	public function actionVlogin(){
		$uid = $this->get("uid",0);
		$reback_url = UrlService::buildUrl("/");
		if( !$uid ){
			return $this->redirect( $reback_url );
		}
		$user_info = User::find()->where([ 'id' => $uid ])->one();
		if( !$user_info ){
			return $this->redirect( $reback_url );
		}
		//cookie保存用户的登录态,所以cookie值需要加密，规则：user_auth_token + "#" + uid
		$this->createLoginStatus( $user_info );
		return $this->redirect( $reback_url );
	}
}
