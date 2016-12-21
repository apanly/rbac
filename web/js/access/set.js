;
var access_set_ops = {
    init:function(){//初始化
        this.eventBind();
    },
    eventBind:function(){//事件绑定
        $(".access_set_wrap .save").click( function(){
            var btn_target = $(this);
            if( btn_target.hasClass("disabled") ){
                alert("正在处理，请不要重复提交~~");
                return false;
            }

            var title = $(".access_set_wrap input[name='title']").val();
            var urls = $(".access_set_wrap textarea[name='urls']").val();

            if( title.length < 1 ){
                alert("请输入合法的权限标题~~");
                return false;
            }

            if( urls.length < 1 ){
                alert("请输入合法的Urls~~");
                return false;
            }

            btn_target.addClass("disabled");
            $.ajax({
                url:'/access/set',
                type:'POST',
                data:{
                    id:$(".access_set_wrap input[name='id']").val(),
                    title:title,
                    urls:urls
                },
                dataType:'json',
                success:function( res ){
                    btn_target.removeClass("disabled");
                    alert( res.msg );
                    if( res.code == 200 ){
                        window.location.href = "/access/index";
                    }
                }
            });
        });
    }
};

$(document).ready( function() {
    access_set_ops.init();
});
