<?php

namespace App\Admin\Extensions;

use Encore\Admin\Form\Field;

class WangEditor extends Field
{
    protected $view = 'admin.wang-editor';

    protected static $css = [
        '/vendor/wangEditor-3.0.16/release/wangEditor.min.css',
    ];

    protected static $js = [
        '/vendor/wangEditor-3.0.16/release/wangEditor.min.js',
    ];

    public function render()
    {
        $name = $this->formatName($this->column);

        $this->script = <<<EOT

var E = window.wangEditor
var editor = new E('#{$this->id}');
editor.customConfig.uploadFileName = 'photo';
editor.customConfig.uploadImgHeaders = {
    'X-CSRF-TOKEN': $('input[name="_token"]').val()
}
editor.customConfig.zIndex = 0;
// 上传路径
editor.customConfig.uploadImgServer = '/help/upload';
editor.customConfig.onchange = function (html) {
    $('input[name=$name]').val(html);
}
editor.create();

EOT;
        return parent::render();
    }
}