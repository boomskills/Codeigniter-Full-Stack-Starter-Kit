<?php

namespace App\Libraries;

use App\Entities\Image;
use App\Models\ImageModel;

class UploadImage
{
    protected $file;
    protected $user;
    protected $imageable_id;
    protected $imageable_type;
    protected $directory;

    public function __construct($file, $user, $imageable_id, $imageable_type, $directory)
    {
        $this->file = $file;
        $this->user = $user;
        $this->imageable_id = $imageable_id;
        $this->imageable_type = $imageable_type;
        $this->directory = $directory;
    }

    public function handleUpload()
    {
        $service = \Config\Services::request();

        if (is_array($this->file)) {
            return false; //return early if the payload is just JSON
        }

        // path
        $path = 'uploads/' . $this->file->store($this->directory);

        $image = new Image();
        $image->user_id = $this->user->id;
        $image->url = $path;
        $image->filename = $this->file->getClientName();
        $image->extension = $this->file->getClientExtension();
        $image->mime_type = $this->file->getClientMimeType();
        $image->size = $this->file->getSize();
        $image->ip_address = $service->getIPAddress();
        $image->imageable_id = $this->imageable_id;
        $image->imageable_type = $this->imageable_type;

        return (new ImageModel())->save($image);
    }
}
