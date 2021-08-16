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
        $this->info(' _    __________________');
        $this->info('| |  / /  _/_  __/_  __/');
        $this->info('| | / // /  / /   / /   ');
        $this->info('| |/ // /  / /   / /    ');
        $this->info('|___/___/ /_/   /_/     ');

        $litstack = false;
        if ($this->confirm('Install litstack preset?')) {
            $litstack = true;
        }

        // Delete welcome view and replace with app
        $this->handleBladeFiles();

        // Publish js and css resources
        $this->handleAssetFiles($litstack);

        // publish root dir config files
        $this->handleRootFiles();

        // publish home controller
        $this->handleControllers();

        // update package.json
        $this->installNpmPackages($litstack);

        // install inertia middleware
        $this->callSilently('inertia:middleware');

        $this->comment("\nPlease execute 'npm install & npm run dev'.\n");

        // handle litstack preset files
        if ($litstack) {
            $this->handleLitstackFiles();
            $this->comment("\nPlease install litstack bladesmith'.\n");
        }
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
     * Handle root files.
     *
     * @return void
     */
    public function handleRootFiles()
    {
        $this->callSilently('vendor:publish', ['--tag' => 'vitt-root', '--force' => true]);
    }

    /**
     * Handle controllers.
     *
     * @return void
     */
    public function handleControllers()
    {
        $this->callSilently('vendor:publish', ['--tag' => 'vitt-controllers', '--force' => true]);

        if ($url = env('APP_URL')) {
            $data = "
mix.browserSync({
    proxy: '$url',
    notify: false
});";

            File::append(base_path('webpack.mix.js'), $data);
        }
    }

    /**
     * Install NPM-packages.
     *
     * @return void
     */
    public function installNpmPackages($litstack)
    {
        $this->updateNodePackages(function ($packages) use ($litstack) {
            if ($litstack) {
                $packages = array_merge(
                    $packages,
                    [
                        '@aw-studio/vue-lit-block'      => '^1.0',
                        '@aw-studio/vue-lit-image-next' => '^1.0',
                        '@headlessui/vue'               => '^1.4.0',
                    ]
                );
            }

            return [
                '@macramejs/macrame-vue3' => '^0.0.1',
                '@inertiajs/inertia'      => '^0.10.0',
                '@inertiajs/inertia-vue3' => '^0.5.1',
                '@vue/compiler-sfc'       => '^3.1.5',
                'tailwindcss'             => '^2.2.7',
                'ts-loader'               => '^9.2.4',
                'typescript'              => '^4.3.5',
                'vue'                     => '^3.1.5',
                'vue-loader'              => '^16.4.1',
            ] + $packages;
        });
    }

    /**
     * Handle Litstack files.
     *
     * @return void
     */
    public function handleLitstackFiles()
    {
        $this->callSilently('vendor:publish', ['--tag' => 'vitt-litstack', '--force' => true]);
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
