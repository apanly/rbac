<?php
/**
 * Class UserController
 */

namespace app\controllers;


use app\controllers\common\BaseController;
use app\models\User;
use app\services\UrlService;

class UserController extends  BaseController{
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