<?php
/**
 * Class UrlService
 */

namespace app\services;


use yii\helpers\Url;

//统一管理链接 并规范书写
class UrlService{
	//返回一个 内部链接
	public static function buildUrl( $uri,$params = [] ){
		return Url::toRoute( array_merge( [ $uri ] ,$params) );
	}

	//返回一个空链接
	public static function buildNullUrl(){
		return "javascript:void(0);";
	}
}