<?php


namespace App\Providers;

use App\Security;
use App\Models\DatabaseModel;
use App\Models\ContentModelManager;
use Slim\Psr7\Factory\ResponseFactory;

class ContentDatabaseServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->getContainer()->set(ContentModelManager::class, function()
        {
            return new ContentModelManager(new ResponseFactory);
        });

    }

    public function boot()
    {
        //
    }
}
