<?php

namespace App\Repositories;

use Illuminate\Support\Facades\App;

abstract class AbstractRepository implements AbstractRepositoryInterface
{
    protected static $model;
    protected const active = 'active';
    protected const unactive = 'unactive';

    public function __call(string $name, array $arguments)
    {
        return App::make(static::$model)->{$name}(...$arguments);
    }

    /*
        App::make(static::$model): Sử dụng App::make để tạo một đối tượng của lớp được xác định bởi biến $model.
        Đối tượng này thường là một đại diện cho một bảng trong cơ sở dữ liệu.
    */

    public function all($filter = [])
    {
        return App::make(static::$model)->all();
    }

    public function store($request)
    {
        return App::make(static::$model)->create($request);
    }

    public function edit($id)
    {
        return App::make(static::$model)->find($id);
    }

    public function update($request, $id)
    {
        $data = $this->edit($id);
        $data->fill($request); // Điền dữ liệu mới từ request vào bản ghi
        $data->save();
        return $data;
    }

    public function destroy($request, $id)
    {
        $data = $this->edit($id);
        $data->fill($request); // Điền dữ liệu mới từ request vào bản ghi
        $data->save();
        return;
    }

    // public function destroy($id)
    // {
    //     $data = $this->edit($id);
    //     $data->delete();
    //     return $data;
    // }

    public function statusChange($request ,$id)
    {
        $status = $request['status'] === self::active ? self::unactive : self::active;
        $request['status'] = $status;
        $data = $this->edit($id);
        $data->fill($request); // Điền dữ liệu mới từ request vào bản ghi
        $data->save();
        return;
    }
}
