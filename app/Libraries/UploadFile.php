<?php

namespace App\Libraries;

use App\Entities\Document;
use App\Models\DocumentModel;

class UploadFile
{
    public const IMAGE = 1;
    public const DOCUMENT = 2;
    public const VIDEO = 3;
    public const AUDIO = 4;

    public const PROPERTIES = [
        self::IMAGE => [
            'path' => 'images',
        ],
        self::VIDEO => [
            'path' => 'videos',
        ],
        self::AUDIO => [
            'path' => 'audios',
        ],
        self::DOCUMENT => [
            'path' => 'documents',
        ],
    ];

    protected $file;
    protected $type;
    protected $user;
    protected $documentable_id;
    protected $documentable_type;
    protected $directory;
    protected $is_public;

    public function __construct($file, $type, $user, $documentable_id, $documentable_type, $directory)
    {
        $this->file = $file;
        $this->type = $type;
        $this->user = $user;
        $this->documentable_id = $documentable_id;
        $this->documentable_type = $documentable_type;
        $this->directory = $directory;
    }

    public function handleUpload()
    {
        $documentModel = new DocumentModel();

        if (is_array($this->file)) {
            return false; //return early if the payload is just JSON
        }

        $instance = '';

        $path = self::PROPERTIES[$this->type]['path'];

        $instance = 'uploads/' . $this->file->store($path . '/' . strtolower(url_title($this->directory)) . '-' . date('Y-m-d'));

        if (in_array($this->file->extension(), ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webb', 'tiff', 'psd'])) {
            $image_size = getimagesize($this->file);

            $width = $image_size[0];
            $height = $image_size[1];
        }

        $document = new Document();
        $document->user_id = $this->user->id;
        $document->url = $instance;
        $document->name = $this->file->getClientOriginalName();
        $document->type = $this->file->extension();
        $document->directory = $this->directory;
        $document->hash = $this->file->hashName();
        $document->size = $this->file->getSize();
        $document->width = isset($width) ? $width : null;
        $document->height = isset($height) ? $height : null;
        $document->documentable_id = $this->documentable_id;
        $document->documentable_type = $this->documentable_type;

        return $documentModel->save($document);
    }
}
