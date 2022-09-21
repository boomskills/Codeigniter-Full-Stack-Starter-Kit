<?php

namespace App\Models;

use App\Entities\Category;

class CategoryModel extends BaseModel
{
    protected $table = 'categories';
    protected $returnType = Category::class;
    protected $allowedFields = ['slug', 'title', 'description', 'icon'];

    public function getEntityType()
    {
        return self::class;
    }
}
