<?php

    namespace Tests\Unit;

    use Illuminate\Support\Facades\File;
    use Livewire\LivewireServiceProvider;
    use Illuminate\Support\Facades\Artisan;
    use Nodus\Packages\LivewireForms\LivewireFormsServiceProvider;
    use Orchestra\Testbench\TestCase as BaseTestCase;

    class TestCase extends BaseTestCase
    {
        public function setUp(): void
        {
            $this->afterApplicationCreated(function () {
                $this->makeACleanSlate();
            });

            $this->beforeApplicationDestroyed(function () {
                $this->makeACleanSlate();
            });

            parent::setUp();
        }

        public function makeACleanSlate()
        {
            Artisan::call('view:clear');

            //File::deleteDirectory($this->livewireViewsPath());
            //File::deleteDirectory($this->livewireClassesPath());
            //File::delete(app()->bootstrapPath('cache/livewire-components.php'));
        }

        protected function getPackageProviders($app)
        {
            return [
                LivewireServiceProvider::class,
                LivewireFormsServiceProvider::class,
            ];
        }

        protected function getEnvironmentSetUp($app)
        {
            $app['config']->set('view.paths', [
                __DIR__.'/views',
                resource_path('views'),
            ]);

            $app['config']->set('app.key', 'base64:Hupx3yAySikrM2/edkZQNQHslgDWYfiBfCuSThJ5SK8=');

            /*$app['config']->set('database.default', 'testbench');
            $app['config']->set('database.connections.testbench', [
                'driver'   => 'sqlite',
                'database' => ':memory:',
                'prefix'   => '',
            ]);*/
        }

        protected function resolveApplicationHttpKernel($app)
        {
            $app->singleton('Illuminate\Contracts\Http\Kernel', 'Illuminate\Foundation\Http\Kernel');
        }

        protected function livewireClassesPath($path = '')
        {
            return app_path('Http/Livewire'.($path ? '/'.$path : ''));
        }

        protected function livewireViewsPath($path = '')
        {
            return resource_path('views').'/livewire'.($path ? '/'.$path : '');
        }
    }