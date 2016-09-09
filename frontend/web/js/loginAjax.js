$(function () {
    var url = window.location.href;
    $('#login-class').click(function(){
        if($('#login-modal').size() > 0){
            $('.theme-popover-mask').fadeIn(100);
            $('#login-modal').slideDown(250);
            return true;
        }else {
            $.ajax({
                type : 'post',
                dataType : 'json',
                url : '/site/login-view',
                data : {backurl : url},
                success:function(data){
                    if(data){
                        $('body').append(data.loginView);
                        $(document).on('#login-modal',function(){
                            alert(1);
                        });
                        $('.theme-popover-mask').fadeIn(100);
                        $('#login-modal').slideDown(250);
                    }
                },
                error: function () {
                    alert('失败');
                }
            });
        }
    });
});