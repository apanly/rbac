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
		return $this->render('index',[
			'list' => $user_list
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

			return $this->render('set',[
				'info' => $info
			]);
		}

		$id = intval( $this->post("id",0) );
		$name = trim( $this->post("name","") );
		$email = trim( $this->post("email","") );
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
		$model_user->save(0);
		return $this->renderJSON([],'操作成功~~');
	}


	//用户登录页面
	public function actionLogin(){
		return $this->render("login");
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