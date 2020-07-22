<?php


namespace App\Http\Controllers\Manage;


use App\Services\Enums\System\AlbumFileTypeEnum;
use App\Services\Repositories\System\Interfaces\IAlbum;
use App\Services\Repositories\System\Interfaces\IAlbumFile;
use App\Utility\Format;
use Illuminate\Http\Request;
use JoyceZ\LaravelLib\Helpers\ResultHelper;
use JoyceZ\LaravelLib\Helpers\TreeHelper;

class Attachment extends ManageController
{

    public function index()
    {
        return $this->view();
    }


    /**
     * 专辑弹窗选择图片、视频、文档
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function album(Request $request, IAlbum $albumRepo)
    {
        $menusData = $albumRepo->all([], ['album_id', 'album_name', 'pid'], 'album_sort');
        $menus = TreeHelper::listToTree($menusData->toArray(), 0, 'album_id');
        $file_type = $request->file_type ? (in_array($request->file_type, AlbumFileTypeEnum::FILE_TYPE) ? $request->file_type : 'image') : 'image';
        $select_num = $request->select_num ? intval($request->select_num) : 0;
        return view($request->route()->getName(), compact('menus', 'file_type','select_num'));
    }

    public function albumFile(Request $request, IAlbumFile $albumFile)
    {
        $ret = $albumFile->getPageLists($request->all());
        $list = Format::formatReturnDataByManyDim($ret['data']);
        return ResultHelper::returnFormat('success', 200, ['total' => $ret['total'], 'list' => $list]);
    }

}
