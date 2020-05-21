<?php


namespace App\Providers;

use App\Support\Security;
use Slim\Psr7\Factory\ResponseFactory;
use Symfony\Component\Debug\Exception\ClassNotFoundException;

class SecurityServiceProvider extends ServiceProvider
{
    /**
     * @global $security
     * @param ResponseFactory
     * @param App
     * @param array $argsGet
     * @param array $argsPost
     */
    public function register()
    {
        try {
            $this->app->getContainer()->set(Security::class, function()
            {
                return new Security();
            });
        } catch (Exception $e) {
        if (env('APP_DEBUG', false))
            throw new ClassNotFoundException('Erreur ' . var_export(self::class) . ' n\'est pas fonctionnel', $e);
        }
    }

    public function boot()
    {
        // TODO: Implement boot() method.
    }
}
