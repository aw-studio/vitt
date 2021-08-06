<?php

namespace AwStudio\Vitt\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class InstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vitt:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->handleBladeFiles();
        $this->handleAssetFiles();
        $this->handleConfFiles();
        $this->handleControllers();
        $this->installNpmPackages();

        $this->callSilently('inertia:middleware');

        $this->comment('Please execute "npm install".');
    }

    /**
     * Handle Blade files.
     *
     * @return void
     */
    public function handleBladeFiles()
    {
        $this->callSilently('vendor:publish', ['--tag' => 'vitt-blade', '--force' => true]);

        if (File::exists(resource_path('views/welcome.blade.php'))) {
            File::delete(resource_path('views/welcome.blade.php'));
        }
    }

    /**
     * Handle asset files.
     *
     * @return void
     */
    public function handleAssetFiles()
    {
        if (File::exists(resource_path('js'))) {
            File::deleteDirectory(resource_path('js'));
        }
        if (File::exists(resource_path('css'))) {
            File::deleteDirectory(resource_path('css'));
        }
        $this->callSilently('vendor:publish', ['--tag' => 'vitt-assets', '--force' => true]);
    }

    /**
     * Handle config files.
     *
     * @return void
     */
    public function handleConfFiles()
    {
        $this->callSilently('vendor:publish', ['--tag' => 'vitt-conf', '--force' => true]);
    }

    /**
     * Handle controllers.
     *
     * @return void
     */
    public function handleControllers()
    {
        $this->callSilently('vendor:publish', ['--tag' => 'vitt-controllers', '--force' => true]);
    }

    /**
     * Install NPM-packages.
     *
     * @return void
     */
    public function installNpmPackages()
    {
        $this->updateNodePackages(function ($packages) {
            return [
                '@inertiajs/inertia'      => '^0.10.0',
                '@inertiajs/inertia-vue3' => '^0.5.1',
                'vue'                     => '^3.1.5',
                '@vue/compiler-sfc'       => '^3.1.5',
                'tailwindcss'             => '^2.2.7',
                'ts-loader'               => '^9.2.4',
                'typescript'              => '^4.3.5',
                'vue-loader'              => '^16.4.1',
            ] + $packages;
        });
    }

    /**
     * Update the "package.json" file.
     *
     * @param  callable $callback
     * @param  bool     $dev
     * @return void
     */
    protected static function updateNodePackages(callable $callback, $dev = true)
    {
        if (! file_exists(base_path('package.json'))) {
            return;
        }

        $configurationKey = $dev ? 'devDependencies' : 'dependencies';

        $packages = json_decode(file_get_contents(base_path('package.json')), true);

        $packages[$configurationKey] = $callback(
            array_key_exists($configurationKey, $packages) ? $packages[$configurationKey] : [],
            $configurationKey
        );

        ksort($packages[$configurationKey]);

        file_put_contents(
            base_path('package.json'),
            json_encode($packages, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) . PHP_EOL
        );
    }
}