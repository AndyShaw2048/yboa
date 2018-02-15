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

editor.customConfig.emotions = [
        {
            // tab 的标题
            title: '默认',
            // type -> 'emoji' / 'image'
            type: 'image',
            // content -> 数组
            content: [
                {
                    alt: '[坏笑]',
                    src: 'https://img.t.sinajs.cn/t4/appstyle/expression/ext/normal/50/pcmoren_huaixiao_org.png'
                },
                {
                    alt: '[舔屏]',
                    src: 'https://img.t.sinajs.cn/t4/appstyle/expression/ext/normal/40/pcmoren_tian_org.png'
                },
                {
                    alt: '[污]',
                    src: 'https://img.t.sinajs.cn/t4/appstyle/expression/ext/normal/3c/pcmoren_wu_org.png'
                },
                {
                    alt: '[允悲]',
                    src: 'https://img.t.sinajs.cn/t4/appstyle/expression/ext/normal/2c/moren_yunbei_org.png'
                },
                {
                    alt: '[笑而不语]',
                    src: 'https://img.t.sinajs.cn/t4/appstyle/expression/ext/normal/3a/moren_xiaoerbuyu_org.png'
                },
                {
                    alt: '[费解]',
                    src: 'https://img.t.sinajs.cn/t4/appstyle/expression/ext/normal/3c/moren_feijie_org.png'
                },
                {
                    alt: '[憧憬]',
                    src: 'https://img.t.sinajs.cn/t4/appstyle/expression/ext/normal/37/moren_chongjing_org.png'
                },
                {
                    alt: '[并不简单]',
                    src: 'https://img.t.sinajs.cn/t4/appstyle/expression/ext/normal/fc/moren_bbjdnew_org.png'
                },
                {
                    alt: '[微笑]',
                    src: 'https://img.t.sinajs.cn/t4/appstyle/expression/ext/normal/5c/huanglianwx_org.gif'
                },
                {
                    alt: '[酷]',
                    src: 'https://img.t.sinajs.cn/t4/appstyle/expression/ext/normal/8a/pcmoren_cool2017_org.png'
                },
                {
                    alt: '[嘻嘻]',
                    src: 'https://img.t.sinajs.cn/t4/appstyle/expression/ext/normal/0b/tootha_org.gif'
                },
                {
                    alt: '[哈哈]',
                    src: 'https://img.t.sinajs.cn/t4/appstyle/expression/ext/normal/6a/laugh.gif'
                },
                {
                    alt: '[可爱]',
                    src: 'https://img.t.sinajs.cn/t4/appstyle/expression/ext/normal/14/tza_org.gif'
                },
                {
                    alt: '[可怜]',
                    src: 'https://img.t.sinajs.cn/t4/appstyle/expression/ext/normal/af/kl_org.gif'
                },
                {
                    alt: '[挖鼻]',
                    src: 'https://img.t.sinajs.cn/t4/appstyle/expression/ext/normal/0b/wabi_org.gif'
                },
                {
                    alt: '[吃惊]',
                    src: 'https://img.t.sinajs.cn/t4/appstyle/expression/ext/normal/f4/cj_org.gif'
                },
                {
                    alt: '[害羞]',
                    src: 'https://img.t.sinajs.cn/t4/appstyle/expression/ext/normal/6e/shamea_org.gif'
                },
                {
                    alt: '[挤眼]',
                    src: 'https://img.t.sinajs.cn/t4/appstyle/expression/ext/normal/c3/zy_org.gif'
                },
                {
                    alt: '[闭嘴]',
                    src: 'https://img.t.sinajs.cn/t4/appstyle/expression/ext/normal/29/bz_org.gif'
                },
                {
                    alt: '[鄙视]',
                    src: 'https://img.t.sinajs.cn/t4/appstyle/expression/ext/normal/71/bs2_org.gif'
                },
                {
                    alt: '[爱你]',
                    src: 'https://img.t.sinajs.cn/t4/appstyle/expression/ext/normal/6d/lovea_org.gif'
                },
                {
                    alt: '[泪]',
                    src: 'https://img.t.sinajs.cn/t4/appstyle/expression/ext/normal/9d/sada_org.gif'
                },
                {
                    alt: '[偷笑]',
                    src: 'https://img.t.sinajs.cn/t4/appstyle/expression/ext/normal/19/heia_org.gif'
                },
                {
                    alt: '[亲亲]',
                    src: 'https://img.t.sinajs.cn/t4/appstyle/expression/ext/normal/8f/qq_org.gif'
                },
                {
                    alt: '[生病]',
                    src: 'https://img.t.sinajs.cn/t4/appstyle/expression/ext/normal/b6/sb_org.gif'
                },
                {
                    alt: '[太开心]',
                    src: 'https://img.t.sinajs.cn/t4/appstyle/expression/ext/normal/58/mb_org.gif'
                },
                {
                    alt: '[白眼]',
                    src: 'https://img.t.sinajs.cn/t4/appstyle/expression/ext/normal/d9/landeln_org.gif'
                },
                {
                    alt: '[右哼哼]',
                    src: 'https://img.t.sinajs.cn/t4/appstyle/expression/ext/normal/98/yhh_org.gif'
                },
                {
                    alt: '[左哼哼]',
                    src: 'https://img.t.sinajs.cn/t4/appstyle/expression/ext/normal/6d/zhh_org.gif'
                },
                {
                    alt: '[嘘]',
                    src: 'https://img.t.sinajs.cn/t4/appstyle/expression/ext/normal/a6/x_org.gif'
                },
                {
                    alt: '[衰]',
                    src: 'https://img.t.sinajs.cn/t4/appstyle/expression/ext/normal/af/cry.gif'
                }
            ]
        },
        {
            // tab 的标题
            title: '新浪',
            // type -> 'emoji' / 'image'
            type: 'image',
            // content -> 数组
            content: [
                {
                    src: 'https://img.t.sinajs.cn/t35/style/images/common/face/ext/normal/7a/shenshou_thumb.gif',
                    alt: '[草泥马]'
                },
                {
                    src: 'https://img.t.sinajs.cn/t35/style/images/common/face/ext/normal/60/horse2_thumb.gif',
                    alt: '[神马]'
                },
                {
                    src: 'https://img.t.sinajs.cn/t35/style/images/common/face/ext/normal/bc/fuyun_thumb.gif',
                    alt: '[浮云]'
                },
                {
                    src: 'https://img.t.sinajs.cn/t35/style/images/common/face/ext/normal/c9/geili_thumb.gif',
                    alt: '[给力]'
                },
                {
                    src: 'https://img.t.sinajs.cn/t35/style/images/common/face/ext/normal/f2/wg_thumb.gif',
                    alt: '[围观]'
                },
                {
                    src: 'https://img.t.sinajs.cn/t35/style/images/common/face/ext/normal/70/vw_thumb.gif',
                    alt: '[威武]'
                },
                {
                    src: 'https://img.t.sinajs.cn/t35/style/images/common/face/ext/normal/6e/panda_thumb.gif',
                    alt: '[熊猫]'
                },
                {
                    src: 'https://img.t.sinajs.cn/t35/style/images/common/face/ext/normal/81/rabbit_thumb.gif',
                    alt: '[兔子]'
                },
                {
                    src: 'https://img.t.sinajs.cn/t35/style/images/common/face/ext/normal/bc/otm_thumb.gif',
                    alt: '[奥特曼]'
                },
                {
                    src: 'https://img.t.sinajs.cn/t35/style/images/common/face/ext/normal/15/j_thumb.gif',
                    alt: '[囧]'
                },
                {
                    src: 'https://img.t.sinajs.cn/t35/style/images/common/face/ext/normal/89/hufen_thumb.gif',
                    alt: '[互粉]'
                },
                {
                    src: 'https://img.t.sinajs.cn/t35/style/images/common/face/ext/normal/c4/liwu_thumb.gif',
                    alt: '[礼物]'
                }
            ]
        }
    ]

editor.create();

EOT;
        return parent::render();
    }
}