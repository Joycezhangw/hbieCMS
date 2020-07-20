$(function () {
    layui.use('form', function () {
        var form = layui.form;
        var repeat_flag = false;//防重复标识
        /**
         * 表单验证
         */
        form.verify({
            title: function (value) {
                if (value.length < 2) {
                    return '角色名称至少得2个字符啊~';
                }
            },
        });

        //监听提交
        form.on('submit(save)', function (data) {
            var obj = $("#tree_box input:checked"),
                group_array = [];
            for (var i = 0; i < obj.length; i++) {
                group_array.push(obj.eq(i).val());
            }
            data.field.rules = group_array;
            if (repeat_flag) return false;
            repeat_flag = true;
            $.ajax({
                url: saveUrl,
                data: data.field,
                dataType: 'json',
                type: 'post',
                success: function (data) {
                    layer.msg(data.message);
                    if (data.code === 200) {
                        location.href = indexUrl;
                    } else {
                        repeat_flag = false;
                    }
                }, error(err) {
                    repeat_flag = false;
                }
            });
            return false;
        });
    });
});

function back() {
    location.href = indexUrl;
}
