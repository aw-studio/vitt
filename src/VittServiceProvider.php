<?php

namespace AwStudio\Vitt;

use AwStudio\Vitt\Commands\InstallCommand;
use Illuminate\Support\ServiceProvider;

class VittServiceProvider extends ServiceProvider
{
    /**
     * Register application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Boot application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerCommands();

        $this->publishes([
            __DIR__ . '/../publish/resources/views/app.blade.php' => resource_path('views/app.blade.php'),
        ], 'vitt-blade');

        $this->publishes([
            __DIR__ . '/../publish/resources/js'  => resource_path('js'),
            __DIR__ . '/../publish/resources/css' => resource_path('css'),
        ], 'vitt-assets');

        $this->publishes([
            __DIR__ . '/../publish/shims-vue.d.ts'         => base_path('shims-vue.d.ts'),
            __DIR__ . '/../publish/tsconfig.json'          => base_path('tsconfig.json'),
            __DIR__ . '/../publish/webpack.mix.js'         => base_path('webpack.mix.js'),
            __DIR__ . '/../publish/tailwind.config.js'     => base_path('tailwind.config.js'),
            __DIR__ . '/../publish/.php-cs-fixer.dist.php' => base_path('.php-cs-fixer.dist.php'),
            __DIR__ . '/../publish/.prettierignore'        => base_path('.prettierignore'),
            __DIR__ . '/../publish/.prettierrc'            => base_path('.prettierrc'),
        ], 'vitt-root');

        $this->publishes([
            __DIR__ . '/../publish/Http/Controllers/HomeController.php' => app_path('Http/Controllers/Pages/HomeController.php'),
            __DIR__ . '/../publish/routes/web.php'                      => base_path('routes/web.php'),
        ], 'vitt-controllers');
    }

    /**
     * Register Deeplable command.
     *
     * @return void
     */
    public function registerCommands(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                InstallCommand::class,
            ]);
        }
    }
}
