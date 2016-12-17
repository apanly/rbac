<?php
/**
 * Class BaseController
 */

namespace app\controllers\common;


use yii\web\Controller;
use Yii;
//是以后所有控制器的基类，并且集成常用公用方法
class BaseController extends  Controller{

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
	protected function renderJSON($data=[], $msg ="ok", $code = 200){
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