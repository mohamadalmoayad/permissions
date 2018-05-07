<?php

namespace Almoayad\Permissions\models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class usersPermission extends Model
{
    protected $table = 'PRMSN_users_permissions';
    protected $guarded = ['id'];

    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function creatorUser(){
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
}
