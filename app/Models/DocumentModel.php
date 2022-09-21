<?php

namespace App\Models;

use App\Entities\Document;

class DocumentModel extends BaseModel
{
    protected $table = 'documents';
    protected $returnType = Document::class;
    protected $allowedFields = [
        'user_id',
        'documentable_id',
        'documentable_type',
        'url',
        'name',
        'preview',
        'type',
        'extension',
        'directory',
        'hash',
        'size',
        'width',
        'height',
        'ip_address',
    ];

    public function getEntityType()
    {
        return self::class;
    }
}
