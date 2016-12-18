<?php
namespace app\services;
use app\models\AppAccessLog;
use  yii\helpers\Html;

class DataHelper {

    public static function encode($dispaly_text){
        return  Html::encode($dispaly_text);
    }

	public static function getIP(){
		if ( !empty($_SERVER["HTTP_X_FORWARDED_FOR"]) ){
			return $_SERVER["HTTP_X_FORWARDED_FOR"];
		}
		return isset($_SERVER["REMOTE_ADDR"]) ? $_SERVER["REMOTE_ADDR"]:'';
	}

	public static function addAppAccessLog( $params = [] ){
		if( !$params ){
			return false;
		}

		$get_params = \Yii::$app->request->get();
		$post_params = \Yii::$app->request->post();
		$target_url = isset($_SERVER['REQUEST_URI'])?$_SERVER['REQUEST_URI']:'';

		$model_log = new AppAccessLog();
		$model_log->uid = $params['uid'];
		$model_log->ua = isset( $_SERVER['HTTP_USER_AGENT'] )?$_SERVER['HTTP_USER_AGENT']:'';
		$model_log->target_url = $target_url;
		$model_log->query_params = json_encode( array_merge($get_params,$post_params) );
		$model_log->ip = self::getIP();
		$model_log->created_time = date("Y-m-d H:i:s");
		$model_log->save(0);
		return true;
	}
}
