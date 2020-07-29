<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Services\Repositories\System\Interfaces\IWebLogError;
use Illuminate\Http\Request;
use JoyceZ\LaravelLib\Helpers\FiltersHelper;
use JoyceZ\LaravelLib\Helpers\ResultHelper;

class LogError extends Controller
{

    /**
     * 记录前端bug
     * @param Request $request
     * @param IWebLogError $webLogErrorRepo
     * @return array|mixed
     */
    public function error(Request $request, IWebLogError $webLogErrorRepo)
    {
        $params = $request->all();
        $webLogErrorRepo->doCreate([
            'message' => FiltersHelper::stringSpecialHtmlFilter($params['message']),
            'source_module'=>FiltersHelper::stringFilter($params['source_module']),
            'source' => FiltersHelper::stringSpecialHtmlFilter($params['source']),
            'lineno' => $params['lineno'],
            'colno' => $params['colno'],
            'stack' => FiltersHelper::stringSpecialHtmlFilter($params['stack']),
            'href' => FiltersHelper::stringFilter($params['href'])
        ]);
        return ResultHelper::returnFormat();
    }

}
