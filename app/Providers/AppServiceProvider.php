<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Storage;
use Illuminate\Filesystem\FilesystemAdapter;
use League\Flysystem\GoogleCloudStorage\GoogleCloudStorageAdapter;
use League\Flysystem\GoogleCloudStorage\PortableVisibilityHandler;
use App\Storage\NoAclVisibilityHandler;
use League\Flysystem\Filesystem;
use Google\Cloud\Storage\StorageClient;
class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Storage::extend('gcs', function ($app, $config) {

            $storageClient = new StorageClient([
                'projectId' => $config['project_id'],
            ]);

            $bucket = $storageClient->bucket($config['bucket']);

            $adapter = new GoogleCloudStorageAdapter(
                $bucket,
                '',
                new NoAclVisibilityHandler()
            );

            return new FilesystemAdapter(
                new Filesystem($adapter),
                $adapter,
                $config
            );
        });

        if (app()->environment('production')) {
            URL::forceScheme('https');
        }
    }
}
