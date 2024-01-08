<?php

define('activeStatus', 'active'); // Khai báo hằng kiểu define
const unactiveStatus = 'unactive'; // Khai báo hằng kiểu const

function convertSatus($status, $id)
{
    /**
     *  Lấy url (giá sử url: http://0.0.0.0:8000/admin/items) thì sẽ lấy ra là /admin/items
     *  Sử dụng substr() để cắt chuỗi: /admin/items => kết quả: items
     *  Sử dụng strpos() kiểm tra trong url sau khi cắt chuỗi có ? hay ko (giả sử brands?page=2)
     *  Nếu có thì cắt bỏ toàn các params truyền vào sau ? => kết quả: brands
     *  Kiểm tra xem tồn tại "url" hay ko? và kiểm tra status và cutCurrentURL tương ứng để hiển thị link thay đổi status
     * ------------------------------------------------------------------------------------------------------------------------
     * event.stopImmediatePropagation(): hàm route() sẽ không được gọi lại khi thay đổi id (ngăn chặn việc cố tình thay đổi id).
     * Vì vậy trong trường hợp cố tình F12 thay đổi id (trường hợp id không tồn tại) là không thành công.
     */

    $currentURL = $_SERVER['REQUEST_URI']; // lấy url
    $cutCurrentURL = substr($currentURL, 7); // cắt chuỗi
    if (strpos($cutCurrentURL, '?') == true) {
        $cutCurrentURL = strstr($cutCurrentURL, '?', true);
    }
    $html = '';
    if (isset($currentURL)) {
        switch ($cutCurrentURL) {
            case 'brands':
                $html .= '<a onclick="event.stopImmediatePropagation();if(confirm(\'Bạn có chắc muốn thay đổi trạng thái không?\')){window.location.href=\'' . route('brands.status_change', encrypt($id)) . '\'}"><i class="ml-2 fa fa-exchange ' . ($status == activeStatus ? 'text-success' : 'text-danger') . '" title="Thay đổi trạng thái"></i></a>';
                break;
            case 'categories':
                $html .= '<a onclick="event.stopImmediatePropagation();if(confirm(\'Bạn có chắc muốn thay đổi trạng thái không?\')){window.location.href=\'' . route('categories.status_change', encrypt($id)) . '\'}"><i class="ml-2 fa fa-exchange ' . ($status == activeStatus ? 'text-success' : 'text-danger') . '" title="Thay đổi trạng thái"></i></a>';
                break;
            case 'products':
                $html .= '<a onclick="event.stopImmediatePropagation();if(confirm(\'Bạn có chắc muốn thay đổi trạng thái không?\')){window.location.href=\'' . route('products.status_change', encrypt($id)) . '\'}"><i class="ml-2 fa fa-exchange ' . ($status == activeStatus ? 'text-success' : 'text-danger') . '" title="Thay đổi trạng thái"></i></a>';
                break;
            case 'payments':
                $html .= '<a onclick="event.stopImmediatePropagation();if(confirm(\'Bạn có chắc muốn thay đổi trạng thái không?\')){window.location.href=\'' . route('payments.status_change', encrypt($id)) . '\'}"><i class="ml-2 fa fa-exchange ' . ($status == activeStatus ? 'text-success' : 'text-danger') . '" title="Thay đổi trạng thái"></i></a>';
                break;
            default:
                break;
        }
    }
    return $html;
}

function checkDisabled($id, $listId)
{
    return in_array($id, $listId) ? 'disabled' : '';
}

function checkcheck($id, $listId, $action)
{
    $html = '';
    if (in_array($id, $listId)) {
        $html .= '<a href="'.route($action, encrypt($id)). '" class="dropdown-item"> <i class="text-primary mr-1 fa fa-edit"></i>Sửa</a>';
    } else {
        $html .= '<a href="'.route($action, encrypt($id)). '" class="dropdown-item"> <i class="text-primary mr-1 fa fa-edit"></i>Sửa</a>';
        $html .= '<button type="submit" class="dropdown-item" onclick="return confirm(\'Bạn có chắc muốn xóa thương hiệu này không?\')"><i class="text-danger mr-1 fa fa-trash"></i>Xóa</button>';
    }
    return $html;
}
