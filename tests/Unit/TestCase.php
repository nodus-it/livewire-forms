<?php

namespace Nodus\Packages\LivewireForms\Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Route;
use Livewire\LivewireServiceProvider;
use Illuminate\Support\Facades\Artisan;
use Nodus\Packages\LivewireForms\LivewireFormsServiceProvider;
use Orchestra\Testbench\TestCase as BaseTestCase;

class TestCase extends BaseTestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->afterApplicationCreated(function () {
            $this->cleanUp();
        });

        $this->beforeApplicationDestroyed(function () {
            $this->cleanUp();
        });


        $this->withFactories(__DIR__ . '/../data/database/factories');

        /**
         * Fake Routes
         */
        Route::get(
            'user/{id}',
            function ($id) {
                return 'user.detais:' . $id;
            }
        )->name('users.details');
    }

    protected function defineDatabaseMigrations(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/../data/database/migrations');
    }

    public function cleanUp(): void
    {
        Artisan::call('view:clear');
    }

    protected function getPackageProviders($app): array
    {
        return [
            LivewireServiceProvider::class,
            LivewireFormsServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app): void
    {
        $app['config']->set(
            'view.paths',
            [
                __DIR__ . '/views',
                resource_path('views'),
            ]
        );

        $app['config']->set('app.key', 'base64:Hupx3yAySikrM2/edkZQNQHslgDWYfiBfCuSThJ5SK8=');
        $app['config']->set('app.locale', 'en');
        $app['config']->set('app.fallback_locale', 'de');
        $app['config']->set('database.default', 'sqlite');
        $app['config']->set(
            'database.connections.sqlite',
            [
                'driver' => 'sqlite',
                'database' => ':memory:',
                'prefix' => '',
            ]
        );
    }
}