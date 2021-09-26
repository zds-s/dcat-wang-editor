<?php
/**
 * @author    : Death-Satan
 * @date      : 2021/9/25
 * @createTime: 22:52
 * @company   : Death撒旦
 * @link      https://www.cnblogs.com/death-satan
 */

namespace SaTan\Dcat\Extensions\WangEditor\Form;

use Dcat\Admin\Support\Helper;
use Dcat\Admin\Support\JavaScript;
use Illuminate\Support\Str;
use Throwable;

class WangEditor extends \Dcat\Admin\Form\Field
{
    /**
     * 编辑器配置
     * @var array
     */
    protected $options = [
        'height'=>500,
        'zIndex'=>10000,
        'placeholder'=>'',
        'focus'=>true,
        //二选一
        'menus'=>[
            'head',
            'bold',
            'fontSize',
            'fontName',
            'italic',
            'underline',
            'strikeThrough',
            'indent',
            'lineHeight',
            'foreColor',
            'backColor',
            'link',
            'list',
            'todo',
            'justify',
            'quote',
            'emoticon',
            'image',
            'video',
            'table',
            'code',
            'splitLine',
            'undo',
            'redo',
        ],
        'excludeMenus'=>[],

        'emotions'=>[
            [
                'title'=>'emoji',
                'type'=>'emoji',
                'content'=>[
                    '😀','😀','😃', '😄', '😁', '😆', '😅', '😂', '😊', '😇', '🙂', '🙃', '😉', '😓', '😪', '😴', '🙄', '🤔', '😬', '🤐'
                ]
            ]
        ],
        'languageType'=>[
            'Bash',
            'C',
            'C#',
            'C++',
            'CSS',
            'Java',
            'JavaScript',
            'JSON',
            'TypeScript',
            'Plain text',
            'Html',
            'XML',
            'SQL',
            'Go',
            'Kotlin',
            'Lua',
            'Markdown',
            'PHP',
            'Python',
            'Shell Session',
            'Ruby',
        ],
        'showFullScreen'=>true,
        'showMenuTooltips'=>true,
        'menuTooltipPosition'=>'up',
        'pasteFilterStyle'=>true,
        'pasteIgnoreImg'=>false,
        'name'=>'',
        'uploadVideoName'=>'file',
        'lang'=>'zh-CN',
        'uploadFileName'=>'file'
    ];

    /**
     * 视图
     * @var string
     */
    protected $view = 'death_satan.dcat-wang-editor::wang-editor';

    /**
     * Css required by this field.
     *
     * @var array
     */
    protected static $css = [
        '@extension/death_satan/dcat-wang-editor/css/styles/dark.css',
    ];


    /**
     * Js required by this field.
     *
     * @var array
     */
    protected static $js = [
        '@extension/death_satan/dcat-wang-editor/js/wangEditor.min.js',
        '@extension/death_satan/dcat-wang-editor/js/highlight.min.js',
    ];

    /**
     * 驱动
     * @var string
     */
    protected string $disk = 'local';

    /**
     * 图片上传文件路径
     * @var string
     */
    protected string $imgUploadDirectory = 'satan/wang-editor/video';

    /**
     * 视频上传地址
     * @var string
     */
    protected string $videoUploadDirectory = 'satan/wang-editor/video';

    /**
     * 定义显示哪些菜单和菜单的顺序
     * @link https://www.wangeditor.com/doc/pages/03-%E9%85%8D%E7%BD%AE%E8%8F%9C%E5%8D%95/01-%E8%87%AA%E5%AE%9A%E4%B9%89%E8%8F%9C%E5%8D%95.html
     * @param array $data
     * @return $this
     */
    public function Menu(array $data):WangEditor
    {
        $this->options['menus'] = $data;
        //避免menus,excludeMenus同时使用
        unset($this->options['excludeMenus']);

        return $this;
    }

    /**
     * 剔除少数菜单
     * @param array $data
     * @link https://www.wangeditor.com/doc/pages/03-%E9%85%8D%E7%BD%AE%E8%8F%9C%E5%8D%95/01-%E8%87%AA%E5%AE%9A%E4%B9%89%E8%8F%9C%E5%8D%95.html
     * @return $this
     */
    public function ExcludeMenus(array $data):WangEditor
    {
        $this->options['excludeMenus'] = $data;
        //避免menus,excludeMenus同时使用
        unset($this->options['menus']);
        return $this;
    }

    /**
     * 配置颜色（文字颜色、背景色）
     * @link https://www.wangeditor.com/doc/pages/03-%E9%85%8D%E7%BD%AE%E8%8F%9C%E5%8D%95/02-%E9%85%8D%E7%BD%AE%E9%A2%9C%E8%89%B2.html
     * @param array $colors
     * @return $this
     */
    public function colors(array $colors):WangEditor
    {
        $this->options['colors'] = $colors;
        return $this;
    }

    /**
     * 设置编辑器容器高度
     * @param int $height
     * @return WangEditor
     */
    public function height(int $height):WangEditor
    {
        $this->options['height'] = $height;
        return $this;
    }

    /**
     * 配置表情图标
     * @param array $emotions
     * @link https://www.wangeditor.com/doc/pages/03-%E9%85%8D%E7%BD%AE%E8%8F%9C%E5%8D%95/06-%E9%85%8D%E7%BD%AE%E8%A1%A8%E6%83%85%E5%9B%BE%E6%A0%87.html
     * @return WangEditor
     * @throws Throwable
     */
    public function emotions(array $emotions):WangEditor
    {
        throw_if(empty($emotions['title']),(new \Exception('emotions not set title')));
        throw_if(empty($emotions['type']) || !in_array($emotions['type'],['image','emoji']),(new \Exception('emotions type not ')));

        $titles = array_column($this->options['emotions'],'title');

        if (in_array($emotions['title'],$titles))
        {
            foreach ($this->options['emotions'] as $index => $emotion)
                if ($emotion['title'] === $emotions['title'])
                {
                    //合并
                    $this->options['emotions'][$index]=
                        array_merge($emotion,$emotions);
                }

        }else{
            $this->options['emotions'][] = $emotions;
        }

        return  $this;
    }

    /**
     * 配置 z-index
     * @param int $zIndex
     * @return $this
     */
    public function zIndex(int $zIndex):WangEditor
    {
        $this->options['zIndex'] = $zIndex;
        return $this;
    }

    /**
     * 自动 focus
     * @link https://www.wangeditor.com/doc/pages/01-%E5%BC%80%E5%A7%8B%E4%BD%BF%E7%94%A8/08-%E8%87%AA%E5%8A%A8focus.html
     * @param bool $focus
     * @return WangEditor
     */
    public function focus(bool $focus=false):WangEditor
    {
        $this->options['focus'] = $focus;
        return $this;
    }

    /**
     * 配置全屏功能
     * @param bool $show
     * @return WangEditor
     */
    public function showFullScreen(bool $show=false):WangEditor
    {
        $this->options['showFullScreen'] = $show;
        return $this;
    }

    /**
     * 设置菜单栏提示
     * @param bool $show
     * @return WangEditor
     */
    public function showMenuTooltips(bool $show=false):WangEditor
    {
        $this->options['showMenuTooltips'] = $show;
        return $this;
    }

    /**
     * 设置菜单栏提示为下标
     * @param string $position
     * @return WangEditor
     */
    public function menuTooltipPosition(string $position = 'down'):WangEditor
    {
        $this->options['menuTooltipPosition'] = $position;
        return $this;
    }

    /**
     * 关闭粘贴样式的过滤
     * @param bool $state
     * @return $this
     */
    public function pasteFilterStyle(bool $state = false):WangEditor
    {
        $this->options['pasteFilterStyle'] = $state;
        return $this;
    }

    /**
     * 忽略粘贴内容中的图片
     * @param bool $ignore
     * @return WangEditor
     */
    public function pasteIgnoreImg(bool $ignore=true):WangEditor
    {
        $this->options['pasteIgnoreImg'] = $ignore;
        return $this;
    }

    /**
     * 获取图片默认上传地址
     * @return string
     */
    protected function defaultImgUploadUrl():string
    {
        return $this->formatUrl(route(admin_api_route_name('satan-wang-editor.upload.img')),'img');
    }

    /**
     * 获取视频默认上传地址
     * @return string
     */
    protected function defaultVideoUploadUrl():string
    {
        return $this->formatUrl(route(admin_api_route_name('satan-wang-editor.upload.video')));
    }

    /**
     * 设置文件驱动
     * @param string $disk
     * @return $this
     */
    public function disk(string $disk = 'local'):WangEditor
    {
        $this->disk = $disk;
        return $this;
    }

    /**
     * 格式化url
     * @param string $url
     * @param string $type
     * @return string
     */
    protected function formatUrl(string $url,string $type='video'): string
    {
        return Helper::urlWithQuery($url, [
            'disk' => $this->disk,
            'dir' => $type==='video'?$this->videoUploadDirectory:$this->imgUploadDirectory,
        ]);
    }

    /**
     * 设置图片上传路径
     * @param string $path
     * @return $this
     */
    protected function ImgDirectory(string $path):WangEditor
    {
        $this->imgUploadDirectory = $path;
        return $this;
    }

    /**
     * 设置视频上传路径
     * @param string $path
     * @return $this
     */
    protected function VideoDirectory(string $path):WangEditor
    {
        $this->videoUploadDirectory = $path;
        return $this;
    }

    /**
     * 设置highlight css
     * @param string $css
     */
    public static function setCss(string $css): void
    {
        self::$css[0] = '@extension/death_satan/dcat-wang-editor/css/styles/'.$css.'.css';
    }

    /**
     * 生成id
     * @return string
     */
    protected function generateId():string
    {
        return 'wang-editor-'.Str::random(8);
    }

    /**
     * 设置语言
     * @param string $lang
     * @return $this
     */
    public function lang(string $lang='en'):WangEditor
    {
        $this->options['lang'] = $lang;
        return $this;
    }

    public function render()
    {
        $this->options['name'] = $this->column;
        $this->addVariables(['name'=>$this->column]);
        $this->options['placeholder'] = $this->placeholder();

        //设置图片上传地址
        empty($this->options['uploadImgServer']) && $this->options['uploadImgServer'] = $this->defaultImgUploadUrl();
        //设置视频上传地址
        empty($this->options['uploadVideoServer']) && $this->options['uploadVideoServer'] = $this->defaultImgUploadUrl();

        $this->attribute('id', $id = $this->generateId());
        $this->options['id'] = $id;

        $this->addVariables(['options'=>JavaScript::format($this->options)]);

        return parent::render();
    }
}
