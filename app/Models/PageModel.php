<?php

namespace App\Models;

use App\Entities\Page;

class PageModel extends BaseModel
{
    protected $table            = 'pages';
    protected $returnType       = Page::class;
    protected $allowedFields    = ['title', 'slug', 'content'];

    public function getEntityType()
    {
        return self::class;
    }
}
