<?php

namespace App\Utils;

class UnlinkFile
{
    protected $file_path;

    public function __construct(string $file_path)
    {
        $this->file_path = $file_path;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {

        $path = base_url(IMAGE_PATH . $this->file_path);

        if (@getimagesize($path)) {
            unlink($this->file_path);
        }
    }
}
