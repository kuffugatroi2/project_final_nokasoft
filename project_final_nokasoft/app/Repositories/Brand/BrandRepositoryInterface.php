<?php

namespace App\Repositories\Brand;

use App\Repositories\AbstractRepositoryInterface;

interface BrandRepositoryInterface extends AbstractRepositoryInterface
{
    public function getListBrand();
    public function deleteAll($arrayId, $today);
}
