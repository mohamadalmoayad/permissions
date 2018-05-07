<?php

namespace Almoayad\Permissions\models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class permissionsAdmin extends Model
{
    protected $table = 'PRMSN_permissions_admins';
    protected $guarded = ['id'];

    public function users(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
