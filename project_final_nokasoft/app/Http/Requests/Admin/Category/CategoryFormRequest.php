<?php

namespace App\Http\Requests\Admin\Category;

use Illuminate\Foundation\Http\FormRequest;

class CategoryFormRequest extends FormRequest
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
        $rules = !empty($parameter) ? '' : 'unique:categories,name';
        return [
            'name' => [
                'required',
                'regex:/^[a-zA-Z][a-zA-Z\d\p{L}\s]*$/u',
                $rules,
            ],
            'type' => [
                'required',
                'regex:/^[a-zA-Z][a-zA-Z\d\p{L}\s]*$/u',
            ],
        ];
    }

    public function messages()
    {
        $inputName = $this->input('name');
        return [
            'name.required' => "Tên danh mục không được trống!",
            'name.unique' => "Danh mục $inputName đã tồn tại!",
            'name.regex' => "Tên danh mục chỉ được chứa chữ cái hoặc số, và phải bắt đầu bằng chữ cái!",
            'type.required' => "Loại danh mục không được trống!",
            'type.regex' => "Loại danh mục chỉ được chứa chữ cái hoạc số, và phải bắt đầu bằng chữ cái!",
        ];
    }
}
