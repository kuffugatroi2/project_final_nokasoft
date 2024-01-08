<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    public $timestamps = true;
    protected $fillable = ['name', 'email', 'password'];
    protected $primaryKey = 'id';
    protected $table = 'admins';

    use HasFactory;

    public function brands()
    {
        return $this->hasMany(Brand::class);
    }

    public function categories()
    {
        return $this->hasMany(Category::class);
    }
}
