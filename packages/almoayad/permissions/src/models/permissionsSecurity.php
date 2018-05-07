<?php

namespace Almoayad\Permissions\models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class permissionsSecurity extends Model
{
    protected $table = 'PRMSN_permissions_securities';
    protected $guarded = ['id'];

    public function users(){
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
}
