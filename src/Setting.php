<?php

namespace SaTan\Dcat\Extensions\WangEditor;

use Dcat\Admin\Extend\Setting as Form;

class Setting extends Form
{
    public function form()
    {
        $this->text('key1')->required();
        $this->text('key2')->required();
    }
}
