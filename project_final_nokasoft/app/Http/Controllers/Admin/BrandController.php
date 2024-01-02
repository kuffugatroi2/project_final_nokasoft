<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Brand\BrandFormRequest;
use App\Models\Brand;
use Illuminate\Http\Request;
use App\Services\BrandService;

class BrandController extends Controller
{
    protected $brandService;

    public function __construct(BrandService $brandService)
    {
        $this->brandService = $brandService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $brands = $this->brandService->index($request);
        return view('admin.brand.index', compact('brands'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = [
            'action' => route('brands.store'),
            'method' => 'POST',
            'function' => 'create',
        ];
        return view('admin.brand.form', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BrandFormRequest $request)
    {
        $brand = $this->brandService->store($request);
        // return redirect()->route('brands.index')->with('message', ($brand['status'] == 200) ? 'Thêm thương hiệu thành công!' : 'Thêm thương hiệu thất bại!');
        return redirect()->route('brands.index')->with(($brand['status'] == 200) ? 'message' : 'error', ($brand['status'] == 200) ? 'Thêm thương hiệu thành công!' : 'Thêm thương hiệu thất bại!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Brand $brand)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $brand = $this->brandService->edit($id);
        if (isset($brand['error_subcode']) && $brand['error_subcode'] == 404)
            return response()->json(['message' => $brand['message'], 'status' => $brand['error_subcode']]);
        $data = [
            'action' => route('brands.update', $id),
            'method' => 'POST',
            'function' => 'edit',
            'brand' => $brand,

        ];
        return view('admin.brand.form', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BrandFormRequest $request, $id)
    {
        $brand = $this->brandService->update($request, $id);
        if (isset($brand['checkIssetName']) && $brand['checkIssetName'] == false) {
            return redirect()->back()->with('error', $brand['message']);
        }
        if (isset($brand['error_subcode']) && $brand['error_subcode'] == 404)
            return response()->json(['message' => $brand['message'], 'status' => $brand['error_subcode']]);
        return redirect()->route('brands.index')->with(($brand['status'] == 200) ? 'message' : 'error', ($brand['status'] == 200) ? 'Update thương hiệu thành công!' : 'Update thương hiệu thất bại!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $brand = $this->brandService->destroy($id);
        if (isset($brand['error_subcode']) && $brand['error_subcode'] == 404)
            return response()->json(['message' => $brand['message'], 'status' => $brand['error_subcode']]);
        return redirect()->back()->with(($brand['status'] == 200) ? 'message' : 'error', ($brand['status'] == 200) ? 'Xóa thương hiệu thành công!' : 'Xóa thương hiệu thất bại!');
    }

    public function deleteAll(Request $request)
    {
        $this->brandService->deleteAll($request);
        return response()->json(['message' => 'Success', 'status' => '200']);
    }

    public function statusChange($id)
    {
        $brand = $this->brandService->statusChange($id);
        if (isset($brand['error_subcode']) && $brand['error_subcode'] == 404)
            return response()->json(['message' => $brand['message'], 'status' => $brand['error_subcode']]);
        return redirect()->route('brands.index')->with(($brand['status'] == 200) ? 'message' : 'error', ($brand['status'] == 200) ? 'Update trạng thái thành công!' : 'Update trạng thái thất bại!');
    }
}
