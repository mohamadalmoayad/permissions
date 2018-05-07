<?php

namespace Almoayad\Permissions\models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class routesPrefix extends Model
{
    protected $table = 'PRMSN_routes_prefixes';
    protected $guarded = ['id'];

    public function users(){
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
}
