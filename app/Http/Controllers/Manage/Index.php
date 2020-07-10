<?php


namespace App\Http\Controllers\Manage;


use Illuminate\Http\Request;

class Index extends ManageController
{
    public function index(Request $request){

       return $this->view();
    }

}
