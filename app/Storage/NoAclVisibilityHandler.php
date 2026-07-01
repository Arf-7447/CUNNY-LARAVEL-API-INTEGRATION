<?php

namespace App\Storage;

use Google\Cloud\Storage\StorageObject;
use League\Flysystem\GoogleCloudStorage\PortableVisibilityHandler;
use League\Flysystem\GoogleCloudStorage\VisibilityHandler;
use League\Flysystem\Visibility;

class NoAclVisibilityHandler implements VisibilityHandler
{
    /**
     * UBLA mengelola akses melalui IAM,
     * jadi tidak perlu mengubah ACL object.
     */
    public function setVisibility(StorageObject $object, string $visibility): void
    {
        // Do nothing
    }

    /**
     * Anggap semua object private.
     * Akses sebenarnya diatur oleh IAM bucket.
     */
    public function determineVisibility(StorageObject $object): string
    {
        return Visibility::PRIVATE;
    }

    /**
     * Sangat penting!
     * Jangan pernah mengirim predefinedAcl.
     */
    public function visibilityToPredefinedAcl(string $visibility): string
    {
        return PortableVisibilityHandler::NO_PREDEFINED_VISIBILITY;
    }
}
