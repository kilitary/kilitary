<?php
declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->isLocal()) {
            $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
            $this->app->register(TelescopeServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        \Blade::directive('datetime', static function ($expression) {
            return "<?php
declare(strict_types=1);

 echo ({$expression})->format('d.m.Y HH:ii:ss'); ?>";
        });

        \Blade::directive('reltime', static function () {
            return "<?php
declare(strict_types=1);

 echo now()->to(session('time_prev_request'), \Carbon\CarbonInterface::DIFF_RELATIVE_TO_NOW); ?>";
        });
    }
}
