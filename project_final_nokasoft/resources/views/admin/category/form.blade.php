@extends('admin/layout/layout')
@section('admin_content')
    <div class="right_col" role="main">
        <div class="col-md-12 col-sm-12 ">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Form thông tin danh mục</h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </li>
                        <li><a class="close-link"><i class="fa fa-close"></i></a>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <form action="{{ $action }}" method="{{ $method }}">
                        @csrf
                        @if (isset($function) && $function == 'edit')
                            @method('PUT')
                        @endif
                        <div class="field item form-group">
                            <label class="col-form-label col-md-3 col-sm-3 label-align">Thương hiệu</label>
                            <div class="col-md-6 col-sm-6">
                                <select class="form-control" name="brand_id">
                                    @if (isset($brands))
                                        @foreach ($brands['listBrand'] as $value)
                                            <option value="{{ $value->id }}">{{ $value->name }}</option>
                                        @endforeach
                                    @else
                                        <option value="{{ $category['data']->brand_id }}">
                                            {{ $category['data']->brand->name }}</option>
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="field item form-group">
                            <label class="col-form-label col-md-3 col-sm-3 label-align">Danh mục<span
                                    class="text-danger h5">*</span></label>
                            <div class="col-md-6 col-sm-6">
                                <input type="text" id="name" class="form-control" data-validate-length-range="6"
                                    data-validate-words="2" name="name" placeholder="Nhập tên thương hiệu" required
                                    value="{{ $category['data']->name ?? '' }}" />
                                @error('name')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                                @if (session('error'))
                                    <div class="text-danger">
                                        {{ session('error') }}
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="field item form-group">
                            <label class="col-form-label col-md-3 col-sm-3 label-align">Loại<span
                                    class="text-danger h5">*</span></label>
                            <div class="col-md-6 col-sm-6">
                                <input type="text" id="type" class="form-control" data-validate-length-range="6"
                                    data-validate-words="2" name="type" placeholder="Nhập loại sản phẩm" required
                                    value="{{ $category['data']->type ?? '' }}"
                                    {{ isset($category['data']) ? 'readonly' : '' }} />
                                @error('type')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="field item form-group">
                            <label class="col-form-label col-md-3 col-sm-3 label-align">Trạng thái</label>
                            @if (!empty($category['data']->status))
                                <div class="form-check form-check-inline ml-3">
                                    <input class="form-check-input" type="radio" value="active" name="status"
                                        @if ($category['data']->status == 'active') checked @endif>
                                    <label class="form-check-label" for="inlineradio">Active</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" value="unactive" name="status"
                                        @if ($category['data']->status == 'unactive') checked @endif>
                                    <label class="form-check-label" for="inlineradio">Unactive</label>
                                </div>
                            @else
                                <div class="form-check form-check-inline ml-3">
                                    <input class="form-check-input" type="radio" value="active" name="status" checked>
                                    <label class="form-check-label" for="inlineradio">Active</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" value="unactive" name="status">
                                    <label class="form-check-label" for="inlineradio">Unactive</label>
                                </div>
                            @endif
                        </div>
                        <div class="ln_solid">
                            <div class="form-group">
                                <br>
                                <div class="col-md-6 offset-md-3">
                                    <button type='submit' class="btn btn-success">Submit</button>
                                    <button type='reset' class="btn btn-primary">Reset</button>
                                    <a href="{{ route('categories.index') }}" class="btn btn-warning text-danger">Come back
                                        <i class="fa fa-backward"></i></a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
