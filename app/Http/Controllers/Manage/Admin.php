<?php
declare (strict_types=1);

namespace App\Http\Controllers\Manage;


class Admin extends ManageController
{

    public function index()
    {
        return $this->view();
    }

    public function create()
    {
        return $this->view();
    }
}
