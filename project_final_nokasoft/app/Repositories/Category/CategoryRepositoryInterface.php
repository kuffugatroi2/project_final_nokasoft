<?php

namespace App\Repositories\Category;

use App\Repositories\AbstractRepositoryInterface;

interface CategoryRepositoryInterface extends AbstractRepositoryInterface
{
    public function getListCategory();
    public function deleteAll($arrayId, $today);
}
