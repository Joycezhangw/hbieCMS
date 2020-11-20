$(function () {
    layui.use(['form'], function () {
        var form = layui.form, repeat_flag = false;//防重复标识

        //自定义验证规则
        form.verify({
            username: function (value) {
                if (value.length < 5) {
                    return '用户名至少得5个字符啊~';
                }
                if (!HBIE.string.isUserName(value)) {
                    return '用户名格式必须为字母、数字、下划线，5-16位组成。'
                }
            },
            realname: function (value) {
                if (parseInt(value) < 3) {
                    return '真实姓名至少得3个字符~'
                }
                if (!HBIE.string.isRealName(value)) {
                    return '真实姓名只能是中文或者英文'
                }
            }
        });
        form.on('submit(save)', function (data) {
            if (repeat_flag) return false;
            repeat_flag = true;
            $.ajax({
                url: SAVE_URL,
                data: data.field,
                dataType: 'json',
                type: 'post',
                success: function (data) {
                    layer.msg(data.message);
                    if (data.code === 200) {
                        location.href = INDEX_URL;
                    } else {
                        repeat_flag = false;
                    }
                }, error(err) {
                    repeat_flag = false;
                }
            });
            return false;
        });
    })
})
function back() {
    location.href = INDEX_URL;
}
