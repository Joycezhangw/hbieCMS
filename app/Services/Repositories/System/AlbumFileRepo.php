<?php
declare (strict_types=1);

namespace App\Services\Repositories\System;


use App\Services\Models\System\AlbumFile;
use App\Services\Repositories\System\Interfaces\IAlbumFile;
use Illuminate\Support\Facades\Storage;
use JoyceZ\LaravelLib\Helpers\ResultHelper;
use JoyceZ\LaravelLib\Repositories\BaseRepository;

class AlbumFileRepo extends BaseRepository implements IAlbumFile
{
    public function __construct(AlbumFile $model)
    {
        parent::__construct($model);
    }

    /**
     * 上传文件到本地
     * @param $request
     * @return array
     */
    public function doLocalUpload($request): array
    {
        $file = $request->file('file');
        $md5 = md5_file($file->getRealPath());
        $name = $file->getClientOriginalName();
        $ext = $file->getClientOriginalExtension();
        $mimeType = $file->getClientMimeType();

        $hasFile = $this->model->where('file_md5', $md5)->where('original_name', $name)->where('file_ext', $ext)->first();

        // 不存在文件，则插入数据库
        if (empty($hasFile)) {

            $file_type = $request->file_type ? $request->file_type : 'image';
            $folder = $request->folder ? $request->folder : 'pic';
            $now_time = time();
            $path = $file->store("public/uploads/$file_type/$folder/" . date("Y", $now_time) . '/' . date("m", $now_time) . '/' . date("d", $now_time));
            // 获取文件url，用于外部访问
            $url = Storage::url($path);
            // 获取文件大小
            $size = Storage::size($path);
//            if ($file_type === 'image') {
//                $imgSize = getimagesize(storage_path() . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . $path);
//            } else {
//                $imgSize = [0, 0];
//            }
            // 插入数据库
            $picture = $this->doCreate([
                'album_id' => $request->album_id ? $request->album_id : 10001,
                'file_md5' => $md5,
                'file_name' => $name,
                'original_name' => $name,
                'file_path' => $path,
                'file_size' => $size,
                'file_type' => $file_type,
                'mime_type' => $mimeType,
                'file_ip' => $request->ip(),
                'file_ext' => $ext
            ]);
            $fileId = $picture->file_id;
        } else {
            $fileId = $hasFile->file_id;

            if (strpos($hasFile->file_path, 'http') !== false) {
                $url = $hasFile->file_path;
            } else {
                // 获取文件url，用于外部访问
                $url = Storage::url($hasFile->file_path);
            }
            $path = $hasFile->file_path;
            $size = $hasFile->file_size;
        }

        $result['file_id'] = $fileId;
        $result['file_name'] = $name;
        $result['file_url'] = asset($url);
        $result['file_path'] = $path;
        $result['file_size'] = $size;
        return ResultHelper::returnFormat('上传成功', 200, $result);
    }


}
