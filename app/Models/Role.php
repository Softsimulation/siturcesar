<?php

namespace App\Models;

use Zizaco\Entrust\EntrustRole;

class Role extends EntrustRole
{
    protected $fillable = [
        'name','display_name','description'
    ];
    public $timestamps = false;
    protected $table = 'roles';
   public function users(){
        return $this->belongsToMany('App\Models\User');
    }
}