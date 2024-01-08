@extends('admin/layout/layout')
@section('admin_content')
    <div class="right_col" role="main">
        <div class="col-md-12 col-sm-12 ">
            <div class="x_panel">
                <div class="x_title show-filter">
                    <h2 class="h5"><small><i class="mr-2 fa fa-search"></i></small>Search</h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li class="mt-2 ml-1"><i class="fa fa-chevron-down icon-show-filter"></i></a>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content d-none" id="filter-form">
                    <br />
                    <form action="{{ route('categories.index') }}" method="GET" id="demo-form2" data-parsley-validate
                        class="form-horizontal form-label-left">
                        <div class="container">
                            <div class="row">
                                <div class="col">
                                    <div class="form-group row ">
                                        <label class="control-label col-md-3 col-sm-3 ">Thương hiệu</label>
                                        <div class="col-md-9 col-sm-9 ">
                                            <select class="form-control" name="brand_id">
                                                <option value="">Vui lòng chọn thương hiệu</option>
                                                @foreach ($data['brands'] as $brand)
                                                    <option value="{{ $brand['id'] }}">{{ $brand['name'] }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row ">
                                        <label class="control-label col-md-3 col-sm-3 ">Người tạo</label>
                                        <div class="col-md-9 col-sm-9 ">
                                            <select class="form-control" name="created_by">
                                                <option value="">Vui lòng chọn người tạo</option>
                                                @foreach ($data['admins'] as $admin)
                                                    <option value="{{ $admin['id'] }}">{{ $admin['name'] }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group row ">
                                        <label class="control-label col-md-3 col-sm-3 ">Danh mục</label>
                                        <div class="col-md-9 col-sm-9 ">
                                            <input type="text" class="form-control" name="name"
                                                placeholder="Vui lòng nhập tên danh mục">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label col-md-3 col-sm-3 ">Trạng thái</label>
                                        <div class="col-md-9 col-sm-9 ">
                                            <select class="form-control" name="status">
                                                <option value="">All</option>
                                                <option value="active">Hoạt động</option>
                                                <option value="unactive">Không hoạt động</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="ln_solid"></div>
                        <div class="item form-group">
                            <div class="col-md-12 col-sm-12 offset-md-12 d-flex justify-content-center">
                                <button type="submit" class="btn btn-success">Search</button>
                                <button class="btn btn-primary" type="reset">Reset</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-sm-12 ">
            <div class="x_panel">
                <div id="alert" style="opacity: 1; transition: opacity 2s;">
                    @include('Layout.message')
                </div>
                <div class="x_title">
                    <h2>Danh sách thương hiệu</h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </li>
                        <li><a class="close-link"><i class="fa fa-close"></i></a>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card-box table-responsive">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-sm">
                                            <div class="selectbox">
                                                <form action="{{ route('categories.index') }}" method="GET">
                                                    <label for="brand">Chọn</label>
                                                    <select name="select-item" id="brands"
                                                        style="width: 50px; height:38px" onchange="this.form.submit()">
                                                        <option value="10">10</option>
                                                        <option value="20">20</option>
                                                        <option value="50" selected>50</option>
                                                        <option value="100">100</option>
                                                    </select>
                                                    mục
                                                </form>
                                            </div>
                                        </div>
                                        <div class="col-sm d-flex justify-content-end">
                                            <a href="{{ route('categories.create') }}" class="btn btn-success">Tạo mới</a>
                                            <button class="btn btn-danger delete-all"
                                                onclick="return confirm('Bạn có chắc muốn xóa những danh mục này không?')">Xóa
                                                all</button>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <table id="datatable-checkbox" class="table table-striped table-bordered bulk_action"
                                    style="width:100%">
                                    <thead>
                                        <tr>
                                            <th><input type="checkbox"></th>
                                            <th>Danh mục</th>
                                            <th>Thương hiệu</th>
                                            <th>Trạng thái</th>
                                            <th>Loại</th>
                                            <th>Người tạo</th>
                                            <th>Ngày tạo</th>
                                            <th>Ngày update</th>
                                            <th>Hoạt động</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data['categories'] as $value)
                                            <tr>
                                                <td><input type="checkbox" value="{{ $value->id }}"></td>
                                                <td>{{ $value->name }}</td>
                                                <td>{{ $value->brand->name }}</td>
                                                <td>
                                                    {{ $value->status }}
                                                    {!! convertSatus($value->status, $value->id) !!}
                                                </td>
                                                <td>{{ $value->type }}</td>
                                                <td>{{ $value->admin->name }}</td>
                                                <td>{{ $value->created_at }}</td>
                                                <td>{{ $value->updated_at }}</td>
                                                <td class="d-flex justify-content-center">
                                                    <form action="{{ route('categories.destroy', encrypt($value->id)) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <div class="dropdown">
                                                            <label class="dropdown-toggle" data-toggle="dropdown"
                                                                role="button" aria-expanded="false"><i
                                                                    class="h2 fa fa-navicon"></i>
                                                            </label>
                                                            <div class="dropdown-menu text-center"
                                                                aria-labelledby="dropdownMenuButton">
                                                                <a class="dropdown-item"
                                                                    href="{{ route('categories.edit', encrypt($value->id)) }}">
                                                                    <i class="text-primary mr-1 fa fa-edit"></i>Sửa
                                                                </a>
                                                                <button type="submit" class="dropdown-item"
                                                                    onclick="return confirm('Bạn có chắc muốn xóa danh mục này không?')">
                                                                    <i class="text-danger mr-1 fa fa-trash"></i>Xóa
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        @if (!empty($brands['data']))
                            <div class="col-lg-12 mt-3 d-flex justify-content-center">
                                {{ $brands['data']->links('pagination::bootstrap-4') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        /*
                    document.addEventListener('DOMContentLoaded', function () { ... });
                    - Đoạn mã này đảm bảo rằng tất cả các phần tử html được tải hoàn toàn
                    trước khi thực hiện các hành động của javascript
                    DOMContentLoaded: để đảm bảo rằng mã Javascript sẽ thực hiện sau khi trang đã được tải xong
                */

        document.addEventListener('DOMContentLoaded', function() {
            // ------------------------------Xử lý xóa all checkbox---------------------------------

            // Lấy thẻ checkbox ở thẻ thead
            var mainCheckbox = document.querySelector('#datatable-checkbox thead input[type="checkbox"]');
            // Lấy tất cả các ô checkbox ở tbody
            var checkboxes = document.querySelectorAll('#datatable-checkbox tbody input[type="checkbox"]');

            // Gán sự kiện click cho phần tử
            mainCheckbox.addEventListener('click', function() {
                /*
                    kiểm tra xem nút checkbox all ở thread có checked hay không
                    - Nếu checked thì sẽ checked tất cả các nút checkbox ở tbody
                    - Nếu bỏ checked ở thread thì cũng sẽ bỏ checked ở tbody
                */
                if (mainCheckbox && mainCheckbox.checked) {
                    checkboxes.forEach(function(checkbox) {
                        checkbox.checked = mainCheckbox.checked;
                    });
                } else {
                    checkboxes.forEach(function(checkbox) {
                        checkbox.checked = false;
                    });
                }
            });

            // Lắng nghe sự kiện click trên nút xóa all
            var deleteAll = document.querySelector('.delete-all');

            deleteAll.addEventListener('click', function() {
                // Lấy tất cả các checkbox đã được chọn
                var selectedCheckboxes = document.querySelectorAll('input[type="checkbox"]:checked');
                // Tạo một mảng để lưu trữ các ID của sản phẩm đã chọn
                var selectedBrandIds = [];
                // Lặp qua danh sách các checkbox đã được chọn để lấy ID và thêm vào mảng
                selectedCheckboxes.forEach(function(checkbox) {
                    // Lấy ID của sản phẩm từ thuộc tính value của checkbox
                    var BrandId = checkbox.value;
                    // Thêm ID vào mảng
                    selectedBrandIds.push(BrandId);
                });
                // Kiểm tra xem nếu checkbox all được checked thì xóa bỏ phần tử đầu tiên (checkbox của checkbox all)
                if (mainCheckbox && mainCheckbox.checked) {
                    selectedBrandIds.shift();
                }
                //Kiểm tra nếu có ít nhất một sản phẩm đã được chọn
                if (selectedBrandIds.length > 0) {
                    fetch('{{ route('categories.delete_all') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                brandIds: selectedBrandIds
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            // Xử lý dữ liệu trả về
                            // if (data.message === 'Success') {
                            //     location.reload();
                            // }
                            // // Hiển thị thông báo từ JavaScript lên HTML
                            // // var alertDiv = document.getElementById('alert');
                            // // setTimeout(function() {
                            // //     alertDiv.innerHTML =
                            // //         `<div class="alert ${data.status === 200 ? 'alert-success' : 'alert-danger'}">${data.message}</div>`;
                            // // }, 10000);

                            // Cập nhật DOM để loại bỏ các phần tử đã xóa (không load lại trang)
                            selectedCheckboxes.forEach(function(checkbox) {
                                // Lấy hàng cha của checkbox và loại bỏ nó
                                var row = checkbox.closest('tr');
                                row.parentNode.removeChild(row);
                            });
                        })
                        .catch(error => console.error('Error:', error));
                } else {
                    alert('Vui lòng chọn ít nhất một danh mục để xóa!');
                }
            });
        });
    </script>
@endsection
