<?php


namespace App\Http\Controllers\Manage;


use App\Services\Enums\System\AlbumFileTypeEnum;
use App\Services\Repositories\System\Interfaces\IAlbum;
use App\Services\Repositories\System\Interfaces\IAlbumFile;
use Illuminate\Http\Request;
use JoyceZ\LaravelLib\Helpers\FiltersHelper;
use JoyceZ\LaravelLib\Helpers\ResultHelper;

class Attachment extends ManageController
{
    /**
     * 专辑管理页面
     * @param IAlbum $albumRepo
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(IAlbum $albumRepo)
    {
        $menus = $albumRepo->all([], ['album_id', 'album_name', 'pid', 'is_default'], 'album_sort')->toArray();//$albumRepo->getAlbumTree();
        return $this->view(compact('menus'));
    }

    /**
     * 专辑弹窗选择图片、视频、文档
     * @param Request $request
     * @param IAlbum $albumRepo
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function album(Request $request, IAlbum $albumRepo)
    {
        $menus = $albumRepo->getAlbumTree();
        $file_type = $request->file_type ? (in_array($request->file_type, AlbumFileTypeEnum::FILE_TYPE) ? $request->file_type : 'image') : 'image';
        $select_num = $request->select_num ? intval($request->select_num) : 0;
        return view($request->route()->getName(), compact('menus', 'file_type', 'select_num'));
    }

    /**
     * 获取附件列表
     * @param Request $request
     * @param IAlbumFile $albumFileRepo
     * @return array|mixed
     */
    public function albumFile(Request $request, IAlbumFile $albumFileRepo)
    {
        $ret = $albumFileRepo->getPageLists($request->all());
        $list = $albumFileRepo->parseDataRows($ret['data']);
        return ResultHelper::returnFormat('success', 200, ['total' => $ret['total'], 'list' => $list]);
    }

    /**
     * 创建专辑
     * @param Request $request
     * @param IAlbum $albumRepo
     * @return array|mixed
     */
    public function store(Request $request, IAlbum $albumRepo)
    {
        $params = [
            'album_name' => FiltersHelper::stringFilter($request->post('album_name')),
            'pid' => 0,
            'is_default' => 0
        ];
        $album = $albumRepo->doCreate($params);
        if ($album) {
            $params['album_id'] = $album->album_id;
            return ResultHelper::returnFormat('添加分组成功', 200, $params);
        }
        return ResultHelper::returnFormat('网络繁忙，请稍后再试', -1);
    }

    /**
     * 更新专辑分组
     * @param Request $request
     * @param IAlbum $albumRepo
     * @return array|mixed
     */
    public function update(Request $request, IAlbum $albumRepo)
    {
        $album_id = intval($request->post('album_id'));
        if ($album_id <= 0) {
            return ResultHelper::returnFormat('缺少必要的参数', -1);
        }
        $album = $albumRepo->getByPkId($album_id);
        if (empty($album)) {
            return ResultHelper::returnFormat('该分组不存在', -1);
        }
        $album->album_name = FiltersHelper::stringFilter($request->post('album_name'));
        if ($album->save()) {
            return ResultHelper::returnFormat('修改分组名称成功', 200);
        }
        return ResultHelper::returnFormat('网络繁忙，请稍后再试', -1);
    }

    //删除
    public function destroy(Request $request, IAlbum $albumRepo, IAlbumFile $albumFileRepo)
    {
        $album_id = intval($request->post('album_id'));
        if ($album_id <= 0) {
            return ResultHelper::returnFormat('缺少必要的参数', -1);
        }
        $album = $albumRepo->getByPkId($album_id);
        if (empty($album)) {
            return ResultHelper::returnFormat('该分组不存在', -1);
        }
        if ($album->delete()) {
            $albumFileRepo->doUpdateByCondition(['album_id' => $album_id], ['album_id' => 10001]);
            return ResultHelper::returnFormat('删除分组成功', 200);
        }
        return ResultHelper::returnFormat('网络繁忙，请稍后再试', -1);
    }

}
