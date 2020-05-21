<?php


namespace App\Providers;

use App\Models\DatabaseModel;
use App\Models\UsersModelManager;
use Slim\Psr7\Factory\ResponseFactory;
use Symfony\Component\Debug\Exception\ClassNotFoundException;

class UsersDatabaseServiceProvider extends ServiceProvider
{
    public function register()
    {
        try {
        $this->app->getContainer()->set(UsersModelManager::class, function()
        {
            return new UsersModelManager(new ResponseFactory);
        });
        } catch (Exception $e) {
            if (env('APP_DEBUG', false))
                throw new ClassNotFoundException('Erreur ' . var_export(self::class) . ' n\'est pas fonctionnel', $e);
        }
    }

    public function boot()
    {
        //
    }
}