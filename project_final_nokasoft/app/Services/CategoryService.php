<?php

namespace App\Services;

use App\Repositories\Category\CategoryRepositoryInterface;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CategoryService
{
    protected $categoryRepository;
    protected $adminRepository;
    protected $today;

    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
        $this->today = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d H:i:s');
    }

    public function index($request)
    {
        $params = $request->all();
        $filter = array_filter($params);
        try {
            $data = $this->categoryRepository->all($filter);
            $listIdBrand = array_column($data['brands'], 'id');
            return [
                'status' => 200,
                'categories' => $data['categories'],
                'admins' => $data['admins'],
                'brands' => $data['brands'],
                'listIdBrand' => $listIdBrand,
            ];
        } catch (Exception $exception) {
            return [
                'status' => 500,
                'error' => $exception->getMessage(),
            ];
        }
    }

    public function store($request)
    {
        $input = $request->only('brand_id', 'name', 'type', 'status');
        $input['created_by'] = Auth::guard('admin')->id();
        $input['updated_by'] = Auth::guard('admin')->id();
        $input['created_at'] = $this->today;
        $input['updated_at'] = $this->today;

        DB::beginTransaction();
        try {
            $category = $this->categoryRepository->store($input);
            DB::commit();
            return [
                'status' => 200,
                'data' => $category
            ];
        } catch (Exception $e) {
            DB::rollBack();
            return [
                'status' => 500,
                'error' => $e->getMessage()
            ];
        }
    }

    public function edit($id)
    {
        DB::beginTransaction();
        try {
            $brand = $this->categoryRepository->edit(decrypt($id));
            if (is_null($brand)) {
                return [
                    'success' => false,
                    'error_subcode' => 404,
                    'message' => 'not_found!'
                ];
            }
            DB::commit();
            return [
                'status' => 200,
                'data' => $brand
            ];
        } catch (Exception $e) {
            DB::rollBack();
            return [
                'status' => 500,
                'error' => $e->getMessage()
            ];
        }
    }

    public function update($request, $id)
    {
        $input = $request->only('brand_id', 'name', 'type', 'status');
        $input['updated_by'] = Auth::guard('admin')->id();
        $input['updated_at'] = $this->today;

        $category = $this->edit($id);
        if ($category['status'] != 200) {
            return [
                'success' => false,
                'error_subcode' => 404,
                'message' => 'not_found!'
            ];
        }
        $resultCheck = true;
        $inputName = $input['name'];
        $listCategory = $this->getListCategory();
        $checkName = in_array($inputName, $listCategory['listNameCategory']);
        if ($checkName && $inputName != $category['data']['name']) {
            $resultCheck = false;
            return [
                'status' => 500,
                'checkIssetName' => $resultCheck,
                'message' => "Danh mục $inputName đã tồn tại!"
            ];
        }
        DB::beginTransaction();
        try {
            $category = $this->categoryRepository->update($input, decrypt($id));
            DB::commit();
            return [
                'status' => 200,
                'data' => $category
            ];
        } catch (Exception $e) {
            DB::rollBack();
            return [
                'status' => 500,
                'error' => $e->getMessage()
            ];
        }
    }

    public function destroy($id)
    {
        $input = [
            'updated_by' => Auth::guard('admin')->id(),
            'deleted_at' => $this->today,
        ];
        $category = $this->edit($id);
        if ($category['status'] != 200) {
            return [
                'success' => false,
                'error_subcode' => 404,
                'message' => 'not_found!'
            ];
        }
        DB::beginTransaction();
        try {
            $category = $this->categoryRepository->destroy($input, decrypt($id));
            DB::commit();
            return [
                'status' => 200,
            ];
        } catch(Exception $e) {
            DB::rollBack();
            return [
                'status' => 500,
                'error' => $e->getMessage()
            ];
        }
    }

    public function deleteAll($request)
    {
        // Lấy mảng dữ liệu từ phần thân yêu cầu
        $requestData = $request->json()->all();
        // Truy cập mảng categoryIds trong dữ liệu
        $categoryIds = $requestData['brandIds'];
        DB::beginTransaction();
        try {
            $this->categoryRepository->deleteAll($categoryIds, $this->today);
            DB::commit();
            return [
                'status' => 200,
            ];
        } catch(Exception $e) {
            DB::rollBack();
            return [
                'status' => 500,
                'error' => $e->getMessage()
            ];
        }
    }

    public function statusChange($id)
    {
        $input = [
            'updated_by' => Auth::guard('admin')->id(),
            'updated_at' => $this->today,
        ];
        $category = $this->edit($id);
        if ($category['status'] != 200) {
            return [
                'success' => false,
                'error_subcode' => 404,
                'message' => 'not_found!'
            ];
        }
        $input['status'] = $category['data']['status'];

        DB::beginTransaction();
        try {
            $category = $this->categoryRepository->statusChange($input, decrypt($id));
            DB::commit();
            return [
                'status' => 200,
                'data' => $category
            ];
        } catch(Exception $e) {
            DB::rollBack();
            return [
                'status' => 500,
                'error' => $e->getMessage()
            ];
        }
    }

    public function getListCategory()
    {
        return $this->categoryRepository->getListCategory();
    }
}
