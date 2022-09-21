<?php

namespace App\Entities;

use App\Models\DocumentModel;

class Document extends BaseEntity
{
    /**
     * Return documentable document files of a given the data.
     */
    public function documentable(int $id = null, string $type = null)
    {
        return (new DocumentModel())->builder()->where(['documentable_id' => $id, 'documentable_type' => $type])->get()->getResult();
    }
}
