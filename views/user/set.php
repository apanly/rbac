<?php
use \app\services\DataHelper;
use \app\services\UrlService;
use \app\services\StaticService;
StaticService::includeAppJsStatic("/js/user/set.js",\app\assets\AppAsset::className());
?>
<div class="row">
	<div class="col-xs-9 col-sm-9 col-md-9  col-lg-9">
		<h5>新增用户</h5>
	</div>
</div>
<hr/>
<div class="row">
	<div class="form-horizontal user_set_wrap" role="form">
		<div class="form-group">
			<label class="col-xs-2 col-sm-2 col-md-2 col-lg-2 control-label">姓名</label>
			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
				<input type="text" class="form-control" name="name" placeholder="请输入姓名" value="<?=$info?$info['name']:'';?>">
			</div>
		</div>
		<div class="form-group">
			<label class="col-xs-2 col-sm-2 col-md-2 col-lg-2 control-label" >邮箱</label>
			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
				<input type="text" class="form-control" name="email" placeholder="请输入邮箱" value="<?=$info?$info['email']:'';?>">
			</div>
		</div>
        
        <!--所属角色-->
        <div class="form-group">
            <label class="col-xs-2 col-sm-2 col-md-2 col-lg-2 control-label" >所属角色</label>
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
				<?php if( $role_list ):?>
					<?php foreach( $role_list as $_role_item ):?>
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="role_ids[]" value="<?=$_role_item['id'];?>"
                                <?php if( in_array( $_role_item['id'] ,$related_role_ids ) ):?> checked <?php endif;?>
                                />
								<?=$_role_item['name'];?>
                            </label>
                        </div>
					<?php endforeach;?>
				<?php endif;?>
            </div>
        </div>
        
		<div class="col-xs-6 col-xs-offset-2 col-sm-6 col-sm-offset-2 col-md-6  col-md-offset-2 col-lg-6 col-sm-lg-2 ">
            <input type="hidden" name="id"  value="<?=$info?$info['id']:0;?>">
			<button type="button" class="btn btn-primary pull-right  save">确定</button>
		</div>
	</div>
</div>