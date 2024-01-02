<?php

namespace App\Repositories\Brand;

use App\Models\Brand;
use App\Repositories\AbstractRepository;

class BrandRepository extends AbstractRepository implements BrandRepositoryInterface
{
    protected static $model = Brand::class;

    public function all($filter = [])
    {
        $brands = self::$model::whereNull('deleted_at');
        if (isset($filter['name'])) {
            $brands->where('name','like','%'.$filter['name'].'%');
        }
        if (isset($filter['status']) && in_array($filter['status'], Brand::arrayStatus)) {
            $brands->where('status', $filter['status']);
        }
        if (isset($filter['created_by'])) {
            $brands->where('created_by', $filter['created_by']);
        }
        $brands = $brands->paginate($filter['select-item'] ?? 8);
        return $brands;
    }

    public function getListNameBrand()
    {
        return Brand::all()->pluck('name')->toArray();
    }

    public function deleteAll($brandIds)
    {
        Brand::whereIn('id', $brandIds)->update(['deleted_at' => now()]);
        return;
    }
}
