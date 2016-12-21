;
var role_access_set_ops = {
    init: function () {//初始化方法
        this.eventBind();
    },
    eventBind: function () {//事件绑定
        $(".role_access_set_wrap .save").click( function(){
            var btn_target = $(this);
            if( btn_target.hasClass("disabled") ){
                alert("正在处理，请不要重复提交~~");
                return false;
            }

            var access_ids = [];
            $(".role_access_set_wrap input[name='access_ids[]']").each(function () {
                if ($(this).prop("checked")) {
                    access_ids.push( $(this).val() );
                }
            });

            btn_target.addClass("disabled");
            $.ajax({
                url:'/role/access',
                type:'POST',
                data:{
                    id:$(".role_access_set_wrap input[name=id]").val(),
                    access_ids:access_ids
                },
                dataType:'json',
                success:function( res ){
                    btn_target.removeClass("disabled");
                    alert( res.msg );
                    if( res.code == 200 ){
                        window.location.href = "/role/index";
                    }
                }
            });
        });
    }
};

$(document).ready( function() {
    role_access_set_ops.init();
});