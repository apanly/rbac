;//是因为多个js文件压缩合并的时候，可能和上一个js文件代码相冲
var role_set_ops = {
    init:function(){//初始化方法
        this.eventBind();
    },
    eventBind:function(){//事件绑定
        $(".role_set_wrap .save").click( function(){
            var name = $(".role_set_wrap input[name='name']").val();
            if( name.length < 1 ){
                alert("请输入合法的角色名称~~");
                return false;
            }

            $.ajax({
                url:'/role/set',
                type:'POST',
                data:{
                    id:$(".role_set_wrap input[name='id']").val(),
                    name:name
                },
                dataType:'json',
                success:function( res ){
                    alert( res.msg );
                    if( res.code == 200 ){
                        window.location.href = "/role/index";
                    }
                }
            });
        });
    }
};

//页面加载完成之后
$(document).ready(function(){
    role_set_ops.init();
});

