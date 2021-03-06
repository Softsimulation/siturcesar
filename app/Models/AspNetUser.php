<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AspNetUser extends Model
{
    protected $table = 'users';
    
    protected $fillable = ['Id	', 'Email', 'UserName'];
    
    protected $primaryKey = 'Id';
    
}
