<?php

    namespace Tests\Unit;

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
            $app[ 'config' ]->set(
                'view.paths',
                [
                    __DIR__ . '/views',
                    resource_path('views'),
                ]
            );

            $app[ 'config' ]->set('app.key', 'base64:Hupx3yAySikrM2/edkZQNQHslgDWYfiBfCuSThJ5SK8=');

            $app[ 'config' ]->set('database.default', 'sqlite');
            $app[ 'config' ]->set(
                'database.connections.sqlite',
                [
                    'driver'   => 'sqlite',
                    'database' => ':memory:',
                    'prefix'   => '',
                ]
            );
        }
    }