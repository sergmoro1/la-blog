<?php

namespace App\Traits;

trait HasStorage
{
    /**
     * Get the disk.
     */
    public function getDisk()
    {
        return $this->storage['disk'];
    }

    /**
     * Get full path to image.
     */
    public function getFullPath()
    {
        return $this->storage['path'] . ($this->storage['seperatly'] ? '/' . $this->id : '');
    }
}
