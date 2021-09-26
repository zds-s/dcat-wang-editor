# emotions 使用方法
## 官方文档地址 <a href="https://www.wangeditor.com/doc/pages/03-%E9%85%8D%E7%BD%AE%E8%8F%9C%E5%8D%95/06-%E9%85%8D%E7%BD%AE%E8%A1%A8%E6%83%85%E5%9B%BE%E6%A0%87.html">配置表情图标</a>

## 扩展自带 `22`个 emoji 表情

## 向编辑器内新增一个 `emoji` 表情

---
```php
/**
* @var $form \Dcat\Admin\Form
 */
$form->wangEditor('column')
    ->emotions([
        'title'=>'emoji',//tab 标题
        'type'=>'emoji', //类型 image 和 emoji 二选一
        'content'=>[
           '😀','😂','🤷','🙊','😱','👩‍🎓'
        ]   
    ])
```
---
