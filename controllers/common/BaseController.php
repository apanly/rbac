<?php
/**
 * Class BaseController
 */

namespace app\controllers\common;


use app\models\User;
use app\services\UrlService;
use yii\web\Controller;
use Yii;
//是以后所有控制器的基类，并且集成常用公用方法
class BaseController extends  Controller{

	protected $auth_cookie_name = "imguowei_888";
	protected $current_user = null;//当前登录人信息
	protected $allowAllAction = [
		'user/login',
		'user/vlogin'
	];

	//本系统所有页面都是需要登录之后才能访问的，  在框架中加入统一验证方法
	public function beforeAction($action) {
		$login_status = $this->checkLoginStatus();
		if ( !$login_status && !in_array( $action->uniqueId,$this->allowAllAction )  ) {
			if(Yii::$app->request->isAjax){
				$this->renderJSON([],"未登录,请返回用户中心",-302);
			}else{
				$this->redirect( UrlService::buildUrl("/user/login") );//返回到登录页面
			}
			return false;
		}
		return true;
	}


	//验证登录是否有效，返回 true or  false
	protected function checkLoginStatus(){
		$request = Yii::$app->request;
		$cookies = $request->cookies;
		$auth_cookie = $cookies->get($this->auth_cookie_name);
		if(!$auth_cookie){
			return false;
		}
		list($auth_token,$uid) = explode("#",$auth_cookie);

		if(!$auth_token || !$uid){
			return false;
		}

		if( $uid && preg_match("/^\d+$/",$uid) ){
			$userinfo = User::findOne([ 'id' => $uid ]);
			if(!$userinfo){
				return false;
			}
			//校验码
			if($auth_token != $this->createAuthToken($userinfo['id'],$userinfo['name'],$userinfo['email'],$_SERVER['HTTP_USER_AGENT'])){
				return false;
			}
			$this->current_user = $userinfo;
			$view = Yii::$app->view;
			$view->params['current_user'] = $userinfo;
			return true;
		}
		return false;
	}

	//设置登录态cookie
	public  function createLoginStatus($userinfo){
		$auth_token = $this->createAuthToken($userinfo['id'],$userinfo['name'],$userinfo['email'],$_SERVER['HTTP_USER_AGENT']);
		$cookies = Yii::$app->response->cookies;
		$cookies->add(new \yii\web\Cookie([
			'name' => $this->auth_cookie_name,
			'value' => $auth_token."#".$userinfo['id'],
		]));
	}

	//用户相关信息生成加密校验码函数
	public function createAuthToken($uid,$name,$email,$user_agent){
		return md5($uid.$name.$email.$user_agent);
	}

	//统一获取post参数的方法
	public function post($key, $default = "") {
		return Yii::$app->request->post($key, $default);
	}

	//统一获取get参数的方法
	public function get($key, $default = "") {
		return Yii::$app->request->get($key, $default);
	}

	/*
	 * 封装json返回值，主要用于js ajax 和 后端交互返回格式
	 * data:数据区 数组
	 * msg: 此次操作简单提示信息
	 * code: 状态码 200 表示成功，http 请求成功 状态码也是200
	 */
	public function renderJSON($data=[], $msg ="ok", $code = 200){
		header('Content-type: application/json');//设置头部内容格式
		echo json_encode([
			"code" => $code,
			"msg"   =>  $msg,
			"data"  =>  $data,
			"req_id" =>  uniqid(),
		]);
		return Yii::$app->end();//终止请求直接返回
	}
}