<?php
namespace app\services;

use Yii;

class StaticService{

	/*使用yii 统一方法加载js或者css*/
    public static function includeAppStatic($type, $path, $depend){
    	//版本号就是为了解决浏览器缓存的
        $release_version = defined("RELEASE_VERSION") ? RELEASE_VERSION : "20150731141600";
        if (stripos($path, "?") !== false) {
            $path = $path . "&version={$release_version}";
        } else {
            $path = $path . "?version={$release_version}";
        }

        if ($type == "css") {
            Yii::$app->getView()->registerCssFile($path, ['depends' => $depend]);
        } else {
            Yii::$app->getView()->registerJsFile($path, ['depends' => $depend]);
        }
    }

    /*引入js业务文件*/
    public static function includeAppJsStatic($path, $depend){
        self::includeAppStatic("js", $path, $depend);
    }

	/*引入css业务文件*/
    public static function includeAppCssStatic($path, $depend){
        self::includeAppStatic("css", $path, $depend);
    }
} 