<?php

namespace App\Repositories\Brand;

use App\Models\Brand;
use App\Repositories\AbstractRepository;

class BrandRepository extends AbstractRepository implements BrandRepositoryInterface
{
    protected static $model = Brand::class;

    public function all($filter = [])
    {
        // Lấy brands
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
        $brands = $brands->orderby('id','desc')->paginate($filter['select-item'] ?? 8);

        // Lấy admin tạo các brands
        $admins = self::$model::with(['admin' => function ($query) {
            $query->select('id', 'name'); // Chọn các trường bạn muốn lấy từ bảng admin
        }])->whereNull('deleted_at')->get();
        $adminIds = $admins->pluck('admin.id')->unique()->values()->all();
        $adminNames = $admins->pluck('admin.name')->unique()->values()->all();
        $admins = array_map(function ($id, $name) {
            return ['id' => $id, 'name' => $name];
        }, $adminIds, $adminNames);

        return [
            'brands' => $brands,
            'admins' => $admins,
        ];
    }

    public function getListBrand()
    {
        $listNameBrand = self::$model::whereNull('deleted_at')->pluck('name')->toArray();
        $listBrand = self::$model::whereNull('deleted_at')->select('id', 'name')->get();
        return [
            'listNameBrand' => $listNameBrand,
            'listBrand' => $listBrand,
        ];
    }

    public function deleteAll($brandIds, $today)
    {
        Brand::whereIn('id', $brandIds)->update(['deleted_at' => now()]);
        return;
    }
}
