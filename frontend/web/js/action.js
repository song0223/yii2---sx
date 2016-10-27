/**
 * Created by Administrator on 2016/10/24.
 */
$(document).on('click', '[data-do]' ,function(e){
    var _this = $(this);
        _id = _this.data('id');
        _do = _this.data('do');
        _type = _this.data('type');
    $.ajax({
        'url': '/index/' + [_type].join('/'),
        //'type': 'post',
        'dataType': 'json',
        'data':{do:_do ,id: _id,type:_type},
        success :function(data){
            if(data.type != 'success'){
                return alert(data.message);
            }
            var num = _this.find('span'),
                numValue = parseInt(num.html()),
                active = _this.hasClass('active');
            _this.toggleClass('active');
            if (num.length) {
                num.html(numValue + (active ? -1 : 1));
            }
        }
    });
});