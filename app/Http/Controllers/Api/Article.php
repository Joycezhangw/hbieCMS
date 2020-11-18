<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Services\Repositories\CMS\Interfaces\IArticle;
use App\Utility\Format;
use Illuminate\Http\Request;
use JoyceZ\LaravelLib\Helpers\ResultHelper;

class Article extends Controller
{

    public function detail(Request $request, IArticle $articleRepo)
    {
        $articleId = intval($request->get('id'));
        if ($articleId <= 0) {
            return ResultHelper::returnFormat('缺少必要的参数', -1);
        }
        $articleData = $articleRepo->getByPkId($articleId);
        if (!$articleData) {
            return ResultHelper::returnFormat('文章不存在', -1);
        }
        $articleData->content;
        $article = $articleRepo->parseDataRows($articleData->toArray());
        return ResultHelper::returnFormat('success', 200, compact('article'));
    }

}
