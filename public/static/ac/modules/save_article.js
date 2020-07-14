$(function(){
    layui.config({
        base: '/static/ac/lib/layui/inputtag/',
    }).use(['inputTags'], function () {
        var inputTags = layui.inputTags;
        inputTags.render({
            elem: '#inputTags', //定义输入框input对象
            content: HB_TAGS, //默认标签
            done: function (value) { //回车后的回调
                // HB_TAGS.push(value)
            }
        })
    });
    layui.use(['form', 'upload', 'layedit'], function () {
        var form = layui.form, upload = layui.upload, layedit = layui.layedit,
            repeat_flag = false;//防重复标识
        layedit.set({
            uploadImage: {
                url: HB_UPLOAD_URL,
                data: {
                    file_type: 'image',
                    folder: 'article',
                    _token: CSRF_TOKEN
                }
            }
        });
        //建立编辑器
        var layeditIndex = layedit.build('post_content', {
            tool: [
                'strong', 'italic', 'underline', 'del', '|', 'left', 'center', 'right', 'image'
            ]
        });
        //普通图片上传
        upload.render({
            elem: '#imgUploadCover',
            url: HB_UPLOAD_URL,
            data: {
                file_type: 'image',
                folder: 'article',
                _token: CSRF_TOKEN
            },
            done: function (res) {
                console.log(res)
                if (res.code === 200) {
                    $("#imgUploadCover").html("<img src=" + res.data.file_url + " >");
                    $("input[name='post_pic']").val(res.data.file_path);
                }
                return layer.msg(res.message);
            }
        });
        //自定义验证规则
        form.verify({
            title: function (value) {
                if (value.length < 5) {
                    return '内容标题至少得5个字符啊~';
                }
            },
            channel: function (value) {
                if (parseInt(value) <= 1) {
                    return '请选择内容所在栏目'
                }
            },
            post_pic: function (value) {
                if (value.length < 1) {
                    return '请上传内容封面图';
                }
            },
            post_desc: function (value) {
                if (value.length < 20) {
                    return '内容描述至少得20个字符~'
                }
            },
            post_content: function (value) {
                var content = layedit.getContent(layeditIndex)
                if (content.length < 1) {
                    return '请填写详细内容~';
                }
            }
        });
        form.on('submit(save)', function (data) {
            data.field.post_tags = HB_TAGS;
            data.field.content = layedit.getContent(layeditIndex);
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
