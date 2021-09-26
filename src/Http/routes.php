<?php

use Illuminate\Support\Facades\Route;


//Route::get('dcat-wang-editor', Controllers\DcatWangEditorController::class.'@index');
Route::group([
    'prefix'     => 'dcat-api',
    'namespace'  => 'SaTan\Dcat\Extensions\WangEditor\Http\Controllers',
    'as'         => 'dcat-api.',
],function (\Illuminate\Routing\Router $router){
    //视频上传接口
    $router->post('satan-wang-editor/upload/video', 'DcatWangEditorController@upload')
        ->name('satan-wang-editor.upload.video');
    //图片上传接口
    $router->post('satan-wang-editor/upload/img', 'DcatWangEditorController@upload')
        ->name('satan-wang-editor.upload.img');
});
