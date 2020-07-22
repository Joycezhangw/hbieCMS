<?php
declare (strict_types=1);

namespace App\Services\Repositories\System\Interfaces;


use JoyceZ\LaravelLib\Repositories\Interfaces\BaseInterface;

interface IAlbumFile extends BaseInterface
{

    /**
     * 上传图片到本地
     * @param $request
     * @return array
     */
    public function doLocalUpload($request): array;

    /**
     * 附件列表
     * @param array $params
     * @return array
     */
    public function getPageLists(array $params): array;

}
