<?php


namespace App\Http\Controllers\Manage;


class Article extends ManageController
{
    public function index()
    {
        return $this->view();
    }
}
