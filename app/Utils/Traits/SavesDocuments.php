<?php

namespace App\Utils\Traits;

use App\Libraries\UploadFile;

trait SavesDocuments
{
    public function saveDocuments($document_array, $documentable_id, $documentable_type, $user, $directory)
    {
        foreach ($document_array as $document) {
            (new UploadFile(
                $document,
                UploadFile::DOCUMENT,
                $user,
                $documentable_id,
                $documentable_type,
                $directory
            ))->handleUpload();
        }
    }

    public function saveDocument($document, $documentable_id, $documentable_type, $user, $directory)
    {
        (new UploadFile(
            $document,
            UploadFile::DOCUMENT,
            $user,
            $documentable_id,
            $documentable_type,
            $directory
        ))->handleUpload();
    }
}
