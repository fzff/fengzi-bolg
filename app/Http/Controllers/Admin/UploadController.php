<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\UploadFileRequest;
use App\Http\Requests\UploadNewFolderRequest;
use App\Services\UploadsManager;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\File;

class UploadController extends Controller
{
    protected $uploadManager;

    public function __construct(UploadsManager $uploadsManager)
    {
        $this->uploadManager = $uploadsManager;
    }

    public function index(Request $request)
    {
        $folder = $request->get('folder');
        $data = $this->uploadManager->folderInfo($folder);
        //dd($data);

        return view('admin.upload.index', $data);

    }

    public function uploadFile(UploadFileRequest $request)
    {
        $file = $request->file('file');
        $custom_name = $request->get('file_name');
        $image_name  = $file->getClientOriginalName();
        $get_extension = $file->getClientOriginalExtension();

        $new_file_name = md5(uniqid() . time() . microtime(true)) . '.' . $get_extension;
        if (!empty($custom_name)) {
            $new_file_name = $custom_name . '.' . $get_extension;
        }

        $path = $request->get('folder') . '/' . $new_file_name;
        $result = $this->uploadManager->saveFile($path, File::get($file->getPathname()));

        if ($result === true) {
            return redirect()->back()->with("success", '文件「' . $new_file_name . '」上传成功.');
        }

        $error = $result ?: "文件上传出错.";
        return redirect()->back()->withErrors([$error]);
    }

    public function deleteFile(Request $request)
    {
        $del_file = $request->get('del_file');
        $path     = $request->get('folder') . '/' . $del_file;

        $result = $this->uploadManager->deleteFile($path);

        if ($result === true) {
            return redirect()->back()->with('success', '文件「' . $del_file . '」已删除.');
        }

        $error = $result ?: "文件删除出错.";
        return redirect()->back()->withErrors([$error]);
    }

    public function createFolder(UploadNewFolderRequest $request)
    {
        $new_folder = $request->get('new_folder');
        $folder     = $request->get('folder') . '/' . $new_folder;

        $result = $this->uploadManager->createDirectory($folder);

        if ($result === true) {
            return redirect()->back()->with('success', '目录「' . $new_folder . '」创建成功.');
        }

        $error = $result ?: "创建目录出错.";
        return redirect()->back()->withErrors([$error]);
    }

    public function deleteFolder(Request $request)
    {
        $del_folder = $request->get('del_folder');
        $folder     = $request->get('folder') . '/' . $del_folder;

        $result = $this->uploadManager->deleteDirectory($folder);

        if ($result === true) {
            return redirect()->back()->with('success', '目录「' . $del_folder . '」已删除');
        }

        $error = $result ?: "删除目录时发生错误.";
        return redirect()->back()->withErrors([$error]);
    }



}
