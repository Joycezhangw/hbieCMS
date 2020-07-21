$(function () {
    layui.use(['form', 'upload'], function () {
        var form = layui.form, upload = layui.upload,
            repeat_flag = false;//防重复标识
        //普通图片上传
        upload.render({
            elem: '#imgUploadCover',
            url: HB_UPLOAD_URL,
            data: {
                file_type: 'image',
                folder: 'slide',
                _token: CSRF_TOKEN
            },
            done: function (res) {
                console.log(res)
                if (res.code === 200) {
                    $("#imgUploadCover").html("<img src=" + res.data.file_url + " >");
                    $("input[name='slide_pic']").val(res.data.file_path);
                }
                return layer.msg(res.message);
            }
        });
        //自定义验证规则
        form.verify({
            title: function (value) {
                if (value.length < 5) {
                    return '幻灯片名称至少得5个字符啊~';
                }
            },
            slide_pic: function (value) {
                if (value.length < 1) {
                    return '请上传展示图片';
                }
            },
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
                }
            });
            return false;
        });
    })
});
function back() {
    location.href = indexUrl;
}
