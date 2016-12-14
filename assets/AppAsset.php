<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use app\services\UrlService;
use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
//    public $css = [
//    	"/bootstrap/css/bootstrap.min.css?v=1.0"
//    ];
//    public $js = [
//    	"/jquery/jquery.min.js",
//		"/bootstrap/js/bootstrap.min.js"
//    ];

	public function registerAssetFiles( $view ){
		//加一个版本号,目的 ： 是浏览器获取最新的css 和 js 文件
		$release = "20161213";
		$this->css = [
			UrlService::buildUrl( "/bootstrap/css/bootstrap.min.css",[ 'v' => $release ] ),
			UrlService::buildUrl( "/css/app.css")
		];
		$this->js = [
			UrlService::buildUrl( "/jquery/jquery.min.js"),
			UrlService::buildUrl( "/bootstrap/js/bootstrap.min.js")
		];
		parent::registerAssetFiles( $view );
	}

}
