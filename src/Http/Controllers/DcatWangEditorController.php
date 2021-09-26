<?php

namespace SaTan\Dcat\Extensions\WangEditor\Http\Controllers;

use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class DcatWangEditorController extends Controller
{
    public function upload(Request $request)
    {
        $file = $request->file('file');
        $dir = trim($request->get('dir'), '/');
        $disk = $this->disk();

        $newName = $this->generateNewName($file);

        $disk->putFileAs($dir, $file, $newName);

        return ['errno'=>0,'data' => [$disk->url("{$dir}/$newName")]];
    }

    protected function generateNewName(UploadedFile $file): string
    {
        return uniqid(md5($file->getClientOriginalName())).'.'.$file->getClientOriginalExtension();
    }

    /**
     * @return Filesystem|FilesystemAdapter
     */
    protected function disk()
    {
        $disk = request()->get('disk') ?: config('admin.upload.disk');

        return Storage::disk($disk);
    }

}
