<?php

namespace App\Repositories\Category;

use App\Models\Category;
use App\Repositories\AbstractRepository;

class CategoryRepository extends AbstractRepository implements CategoryRepositoryInterface
{
    protected static $model = Category::class;

    public function all($filter = [])
    {
        // Lấy categories
        $categories = self::$model::whereNull('deleted_at');
        if (isset($filter['brand_id'])) {
            $categories->where('brand_id', $filter['brand_id']);
        }
        if (isset($filter['name'])) {
            $categories->where('name','like','%'.$filter['name'].'%');
        }
        if (isset($filter['status']) && in_array($filter['status'], self::$model::arrayStatus)) {
            $categories->where('status', $filter['status']);
        }
        if (isset($filter['created_by'])) {
            $categories->where('created_by', $filter['created_by']);
        }
        $categories = $categories->orderby('id','desc')->paginate($filter['select-item'] ?? 8);

        // Lấy admin tạo các categories
        $admins = self::$model::with(['admin' => function ($query) {
            $query->select('id', 'name'); // Chọn các trường bạn muốn lấy từ bảng admin
        }])->whereNull('deleted_at')->get();
        $adminIds = $admins->pluck('admin.id')->unique()->values()->all();
        $adminNames = $admins->pluck('admin.name')->unique()->values()->all();
        $admins = array_map(function ($id, $name) {
            return ['id' => $id, 'name' => $name];
        }, $adminIds, $adminNames);

        // Lấy brands có trong table categories
        $brands = self::$model::with(['brand' => function ($query) {
            $query->select('id', 'name'); // Chọn các trường bạn muốn lấy từ bảng admin
        }])->whereNull('deleted_at')->get();
        $brandIds = $brands->pluck('brand.id')->unique()->values()->all();
        $brandNames = $brands->pluck('brand.name')->unique()->values()->all();
        $brands = array_map(function ($id, $name) {
            return ['id' => $id, 'name' => $name];
        }, $brandIds, $brandNames);

        return [
            'categories' => $categories,
            'admins' => $admins,
            'brands' => $brands,
        ];
        return $categories;
    }

    public function getListCategory()
    {
        $listNameCategory = self::$model::whereNull('deleted_at')->pluck('name')->toArray();
        $listCategory = self::$model::whereNull('deleted_at')->select('id', 'name')->get();
        return [
            'listNameCategory' => $listNameCategory,
            'listCategory' => $listCategory,
        ];
    }

    public function deleteAll($categoryIds, $today)
    {
        self::$model::whereIn('id', $categoryIds)->update(['deleted_at' => $today]);
        return;
    }
}
