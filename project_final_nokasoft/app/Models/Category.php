<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    const active = 'active';
    const unactive = 'unactive';
    const arrayStatus = [
        Brand::active,
        Brand::unactive,
    ];

    public $timestamps = false; // set time to false
    protected $fillable = ['brand_id', 'name', 'status', 'type', 'created_by', 'updated_by', 'deleted_at','created_at', 'updated_at'];
    protected $primaryKey = 'id';
    protected $table = 'categories';

    use HasFactory;

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'created_by');
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }
}
