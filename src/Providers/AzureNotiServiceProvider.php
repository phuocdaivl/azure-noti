<?php
namespace DaiDP\AzureNoti\Providers;

use DaiDP\AzureNoti\HttpClient;
use DaiDP\AzureNoti\Platform\AppleEndpoint;
use DaiDP\AzureNoti\Platform\GoogleEndpoint;
use DaiDP\AzureNoti\Support\Token;
use Illuminate\Support\ServiceProvider;

/**
 * Class AzureNotiServiceProvider
 * @package DaiDP\AzureNoti\Providers
 * @author DaiDP
 * @since Sep, 2019
 */
class AzureNotiServiceProvider extends ServiceProvider
{
    /**
     * Boot the service provider.
     */
    public function boot()
    {
        $path = realpath(__DIR__.'/../../config/config.php');

        $this->publishes([$path => config_path('azure-noti.php')], 'config');
        $this->mergeConfigFrom($path, 'azure-noti');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerToken();

        //$this->app->singleton(UserManagementInterface::class, UserManagement::class);
        $this->app->bind(GoogleEndpoint::class, function($app) {
           return new GoogleEndpoint(new HttpClient());
        });

        $this->app->bind(AppleEndpoint::class, function($app) {
            return new AppleEndpoint(new HttpClient());
        });
    }

    /**
     * Đăng ký tạo token authen
     */
    protected function registerToken()
    {
        $this->app->singleton('daidp.azure_noti.token', function () {
            $conStr  = $this->config('connection_string');
            $hubPath = $this->config('hub_path');
            $ttl     = $this->config('token_ttl');

            return new Token($conStr, $hubPath, $ttl);
        });
    }

    /**
     * Helper to get the config values.
     *
     * @param  string  $key
     * @param  string  $default
     *
     * @return mixed
     */
    protected function config($key, $default = null)
    {
        return config("azure-noti.$key", $default);
    }
}