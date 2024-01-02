<?php

namespace App\Services;

use App\Repositories\Admin\AdminRepositoryInterface;
use App\Repositories\Brand\BrandRepositoryInterface;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BrandService
{
    protected $brandRepository;
    protected $adminRepository;
    protected $today;

    public function __construct(BrandRepositoryInterface $brandRepository, AdminRepositoryInterface $adminRepository)
    {
        $this->brandRepository = $brandRepository;
        $this->adminRepository = $adminRepository;
        $this->today = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d H:i:s');
    }

    public function index($request)
    {
        $params = $request->all();
        $filter = array_filter($params);
        try {
            $brand = $this->brandRepository->all($filter);
            $admins = $this->adminRepository->all();
            return [
                'status' => 200,
                'data' => $brand,
                'admins' => $admins,
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
        DB::beginTransaction();
        try {
            $input = $request->only('name', 'status');
            $input['created_by'] = Auth::guard('admin')->id();
            $input['updated_by'] = Auth::guard('admin')->id();
            $input['created_at'] = $this->today;
            $input['updated_at'] = $this->today;

            $brand = $this->brandRepository->store($input);
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

    public function edit($id)
    {
        DB::beginTransaction();
        try {
            $brand = $this->brandRepository->edit(decrypt($id));
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
        $input = $request->only('name', 'status');
        $input['updated_by'] = Auth::guard('admin')->id();
        $input['updated_at'] = $this->today;

        $brand = $this->edit($id);
        if ($brand['status'] != 200) {
            return [
                'success' => false,
                'error_subcode' => 404,
                'message' => 'not_found!'
            ];
        }
        $resultCheck = true;
        $inputName = $input['name'];
        $listBrand = $this->brandRepository->getListNameBrand();
        $checkName = in_array($inputName, $listBrand);
        if ($checkName && $inputName != $brand['data']['name']) {
            $resultCheck = false;
            return [
                'status' => 500,
                'checkIssetName' => $resultCheck,
                'message' => "Thương hiệu $inputName đã tồn tại!"
            ];
        }
        DB::beginTransaction();
        try {
            $brand = $this->brandRepository->update($input, decrypt($id));
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

    public function destroy($id)
    {
        $input = [
            'updated_by' => Auth::guard('admin')->id(),
            'deleted_at' => $this->today,
        ];
        $brand = $this->edit($id);
        if ($brand['status'] != 200) {
            return [
                'success' => false,
                'error_subcode' => 404,
                'message' => 'not_found!'
            ];
        }
        DB::beginTransaction();
        try {
            $brand = $this->brandRepository->destroy($input, decrypt($id));
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
        // Truy cập mảng brandIds trong dữ liệu
        $brandIds = $requestData['brandIds'];
        DB::beginTransaction();
        try {
            $this->brandRepository->deleteAll($brandIds);
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
        $brand = $this->edit($id);
        if ($brand['status'] != 200) {
            return [
                'success' => false,
                'error_subcode' => 404,
                'message' => 'not_found!'
            ];
        }
        $input['status'] = $brand['data']['status'];

        DB::beginTransaction();
        try {
            $brand = $this->brandRepository->statusChange($input, decrypt($id));
            DB::commit();
            return [
                'status' => 200,
                'data' => $brand
            ];
        } catch(Exception $e) {
            DB::rollBack();
            return [
                'status' => 500,
                'error' => $e->getMessage()
            ];
        }
    }
}
