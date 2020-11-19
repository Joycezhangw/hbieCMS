$(function () {
    layui.use(['form','upload'], function () {
        var form = layui.form,upload = layui.upload;
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
            },
            title: function (value) {
                if (value.length >6) {
                    return '标题最多不能超过6个字符~';
                }
            },
        });
        //普通图片上传
        upload.render({
            elem: '#imgUploadCover',
            url: HB_UPLOAD_URL,
            accept: 'image',
            acceptMime: 'image/png',
            exts:'PNG|png',
            data: {
                file_type: 'image',
                folder: 'pages',
                _token: CSRF_TOKEN
            },
            done: function (res) {
                console.log(res)
                if (res.code === 200) {
                    $("#imgUploadCover").html("<img src=" + res.data.file_path_url + " >");
                    $("input[name='page_icon']").val(res.data.file_path);
                }
                return layer.msg(res.message);
            }
        });
        //监听提交
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
    });
});
function back() {
    location.href = INDEX_URL;
}
