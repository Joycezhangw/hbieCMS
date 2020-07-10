<?php

namespace App\Services\Models\Manage;

use Illuminate\Database\Eloquent\Model;

class ManageRoleHasModule extends Model
{
    protected $table='hb_manage_role_has_module';

    protected $fillable=[
        'role_id','module_id'
    ];
}
