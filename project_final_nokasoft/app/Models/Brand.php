<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    const active = 'active';
    const unactive = 'unactive';
    const arrayStatus = [
        Brand::active,
        Brand::unactive,
    ];

    public $timestamps = false; // set time to false
    protected $fillable = ['name', 'status', 'created_by', 'updated_by', 'deleted_at','created_at', 'updated_at'];
    protected $primaryKey = 'id';
    protected $table = 'brands';

    use HasFactory;

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'created_by');
    }
}
