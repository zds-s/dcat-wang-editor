<?php

namespace SaTan\Dcat\Extensions\WangEditor;

use Dcat\Admin\Extend\ServiceProvider;
use Dcat\Admin\Admin;
use Dcat\Admin\Form;
use SaTan\Dcat\Extensions\WangEditor\Form\WangEditor;

class DcatWangEditorServiceProvider extends ServiceProvider
{

	public function register()
	{
		//
	}

	public function init()
	{
		parent::init();

        Form::extend('wangEditor',WangEditor::class);
	}

	public function settingForm()
	{
		return new Setting($this);
	}
}
