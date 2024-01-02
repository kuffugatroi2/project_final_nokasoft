<?php

namespace App\Repositories\Brand;

use App\Repositories\AbstractRepositoryInterface;

interface BrandRepositoryInterface extends AbstractRepositoryInterface
{
    public function getListNameBrand();
    public function deleteAll($arrayId);
}
