$(function () {
    layui.use(['form'], function () {
        var form = layui.form;
        var repeat_flag = false;//防重复标识
        /**
         * 表单验证
         */
        form.verify({
            num: function (value) {
                if (value === '') {
                    return;
                }
                if (value % 1 !== 0) {
                    return '排序数值必须为整数';
                }
                if (value < 0) {
                    return '排序数值必须为大于0';
                }
            }
        });

        //监听提交
        form.on('submit(save)', function (data) {
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
                }
            });
            return false;
        });

    });
});
function back() {
    location.href = indexUrl;
}
