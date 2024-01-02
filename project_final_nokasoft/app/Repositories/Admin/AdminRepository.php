<?php

namespace App\Repositories\Admin;

use App\Models\Admin;
use App\Repositories\AbstractRepository;

class AdminRepository extends AbstractRepository implements AdminRepositoryInterface
{
    protected static $model = Admin::class;
}
