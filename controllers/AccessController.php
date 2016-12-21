<?php

namespace app\controllers;

use app\controllers\common\BaseController;
use app\models\Access;

class AccessController extends BaseController {

	//权限列表
    public function actionIndex(){
		$access_list = Access::find()->where([ 'status' => 1 ])->orderBy([ 'id' => SORT_DESC ])->all();
		return $this->render('index',[
			'list' => $access_list
		]);
    }

	/*
	 * 添加或者编辑权限
	 * get 展示页面
	 * post 处理添加或者编辑权限
	 */
    public function actionSet(){
		//如果是get请求则演示页面
		if( \Yii::$app->request->isGet ){
			$id = $this->get("id",0);
			$info = [];
			if( $id ){
				$info = Access::find()->where([ 'status' => 1 ,'id' => $id ])->one();
			}
			return $this->render('set',[
				'info' => $info
			]);
		}

		$id = intval( $this->post("id",0) );
		$title = trim( $this->post("title","") );
		$urls = trim( $this->post("urls","") );
		$date_now = date("Y-m-d H:i:s");
		if( mb_strlen($title,"utf-8") < 1 || mb_strlen($title,"utf-8") > 20 ){
			return $this->renderJSON([],'请输入合法的权限标题~~',-1);
		}

		if( !$urls ){
			return $this->renderJSON([],'请输入合法的Urls~~',-1);
		}

		$urls = explode("\n",$urls);
		if( !$urls ){
			return $this->renderJSON([],'请输入合法的Urls~~',-1);
		}

		//查询同一标题的是否存在
		$has_in = Access::find()->where([ 'title' => $title ])->andWhere([ '!=','id',$id ])->count();
		if( $has_in ){
			return $this->renderJSON([],'该权限标题已存在~~',-1);
		}

		//查询指定id的权限
		$info = Access::find()->where([ 'id' => $id ])->one();
		if( $info ){//如果存在则是编辑
			$model_access = $info;
		}else{//不存在就是添加
			$model_access = new Access();
			$model_access->status = 1;
			$model_access->created_time =  $date_now;
		}
		$model_access->title = $title;
		$model_access->urls = json_encode( $urls );//json格式保存的
		$model_access->updated_time = $date_now;
		$model_access->save(0);

		return $this->renderJSON([],'操作成功~~');
	}
}
