<div class="{{$viewClass['form-group']}}">

    <label class="{{$viewClass['label']}} control-label">{!! $label !!}</label>

    <div class="{{$viewClass['field']}}">

        @include('admin::form.error')

        <div class="{{$class}}" >
            <div id="hid-wang-editor-{{$name}}">
                {!!$value!!}
            </div>

            <input type="hidden" name="{{$name}}" {!! $attributes !!}  value="{!!$value!!}">
        </div>

        @include('admin::form.help-block')

    </div>
</div>

<script type="text/javascript" require="@death-satan.dcat-wang-editor">
    let options = {!! $options !!};
    const E = window.wangEditor;
    const id = '#'+options['id'];

    const editor = new E('#hid-wang-editor-{{$name}}');

    //合并配置
    editor.config = Object.assign(editor.config,options);

    //token验证
    editor.config.uploadImgParams = {
        _token:'{{csrf_token()}}'
    }
    // 挂载highlight插件
    editor.highlight = hljs

    editor.config.uploadVideoParams={
        _token:'{{csrf_token()}}'
    }

    //设置alert
    editor.config.customAlert = function (s, t) {
        switch (t) {
            case 'success':
                Dcat.success(s)
                break
            case 'info':
                Dcat.info(s)
                break
            case 'warning':
                Dcat.warning(s)
                break
            case 'error':
                Dcat.swal.error('editor error',s)
                break
            default:
                Dcat.info(s)
                break
        }
    }

    editor.config.uploadVideoHooks.customInsert = function(insertVideoFn, result) {
        return insertVideoFn(result.data[0])
    }

    //同步html
    editor.config.onchange = function (newHtml) {
        $(id).val(newHtml)
    }
    editor.create();
</script>
