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

    /**
     * Return documentable files of a given the data.
     */
    public function documentable(int $documentableId = null, string $documentableType = '')
    {
        return $this->builder()->where(['documentable_id' => $documentableId, 'documentable_type' => $documentableType])->get()->getResult();
    }
}
