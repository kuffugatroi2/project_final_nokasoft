<?php

namespace App\Http\Requests\Admin\Brand;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

use function PHPUnit\Framework\isNull;

class BrandFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $parameter = $this->route()->parameters(); // Lấy parameters để kiểm tra xem là chức năng create hay update
        // $brandId = isset($parameter['brand']) ? decrypt($parameter['brand']) : null;
        // $rules = !empty($parameter) ? 'required|regex:/^[a-zA-Z]+[a-zA-Z0-9]*$/u' : 'required|unique:brands,name|regex:/^[a-zA-Z]+[a-zA-Z0-9]*$/u';
        $rules = !empty($parameter) ? '' : 'unique:brands,name';
        return [
            'name' => [
                'required',
                'regex:/^[a-zA-Z\s]+[a-zA-Z0-9\s]*$/u',
                $rules,
            ],
        ];
    }

    public function messages()
    {
        $inputName = $this->input('name');
        return [
            'name.required' => "Tên thương hiệu không được trống!",
            'name.unique' => "Thương hiệu $inputName đã tồn tại!",
            'name.regex' => "Tên thương hiệu chỉ được chứa chữ cái và số, và phải bắt đầu bằng chữ cái!",
        ];
    }
}
