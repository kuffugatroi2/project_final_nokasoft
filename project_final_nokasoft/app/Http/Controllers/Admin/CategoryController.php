<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Category\CategoryFormRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Services\CategoryService;
use App\Services\BrandService;

class CategoryController extends Controller
{
    protected $brandService;
    protected $categoryService;

    public function __construct(BrandService $brandService, CategoryService $categoryService)
    {
        $this->brandService = $brandService;
        $this->categoryService = $categoryService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = $this->categoryService->index($request);
        return view('admin.category.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $brands = $this->brandService->getListBrand();
        $data = [
            'action' => route('categories.store'),
            'method' => 'POST',
            'function' => 'create',
            'brands' => $brands ?? [],
        ];
        return view('admin.category.form', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryFormRequest $request)
    {
        $category = $this->categoryService->store($request);
        return redirect()->route('categories.index')->with(($category['status'] == 200) ? 'message' : 'error', ($category['status'] == 200) ? 'Thêm danh mục thành công!' : 'Thêm danh mục thất bại!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $category = $this->categoryService->edit($id);
        if (isset($category['error_subcode']) && $category['error_subcode'] == 404) {
            return response()->json(['message' => $category['message'], 'status' => $category['error_subcode']]);
        } else if ($category['status'] == 500) {
            return response()->json(['error' => $category['error'], 'status' => $category['status']]);
        }
        $data = [
            'action' => route('categories.update', $id),
            'method' => 'POST',
            'function' => 'edit',
            'category' => $category ?? [],

        ];
        return view('admin.category.form', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryFormRequest $request, $id)
    {
        $category = $this->categoryService->update($request, $id);
        if (isset($category['checkIssetName']) && $category['checkIssetName'] == false) {
            return redirect()->back()->with('error', $category['message']);
        }
        if (isset($category['error_subcode']) && $category['error_subcode'] == 404) {
            return response()->json(['message' => $category['message'], 'status' => $category['error_subcode']]);
        } else if ($category['status'] == 500) {
            return response()->json(['error' => $category['error'], 'status' => $category['status']]);
        }
        return redirect()->route('categories.index')->with(($category['status'] == 200) ? 'message' : 'error', ($category['status'] == 200) ? 'Update danh mục thành công!' : 'Update danh mục thất bại!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $category = $this->categoryService->destroy($id);
        if (isset($category['error_subcode']) && $category['error_subcode'] == 404) {
            return response()->json(['message' => $category['message'], 'status' => $category['error_subcode']]);
        } else if ($category['status'] == 500) {
            return response()->json(['error' => $category['error'], 'status' => $category['status']]);
        }
        return redirect()->back()->with(($category['status'] == 200) ? 'message' : 'error', ($category['status'] == 200) ? 'Xóa danh mục thành công!' : 'Xóa danh mục thất bại!');
    }

    public function deleteAll(Request $request)
    {
        $this->categoryService->deleteAll($request);
        return response()->json(['message' => 'Success', 'status' => '200']);
    }

    public function statusChange($id)
    {
        $category = $this->categoryService->statusChange($id);
        if (isset($category['error_subcode']) && $category['error_subcode'] == 404) {
            return response()->json(['message' => $category['message'], 'status' => $category['error_subcode']]);
        } else if ($category['status'] == 500) {
            return response()->json(['error' => $category['error'], 'status' => $category['status']]);
        }
        return redirect()->back()->with(($category['status'] == 200) ? 'message' : 'error', ($category['status'] == 200) ? 'Update trạng thái thành công!' : 'Update trạng thái thất bại!');
    }
}
