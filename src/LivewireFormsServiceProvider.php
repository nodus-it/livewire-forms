<?php

    namespace Nodus\Packages\LivewireForms;

    use Illuminate\Support\Facades\Route;
    use Illuminate\Support\Facades\Validator;
    use Illuminate\Support\ServiceProvider;
    use Nodus\Packages\LivewireForms\Controllers\JavaScriptAssets;

    class LivewireFormsServiceProvider extends ServiceProvider
    {
        private string $packageNamespace = 'nodus.packages.livewire-forms';

        private string $resourcesPath = __DIR__ . DIRECTORY_SEPARATOR . 'resources' . DIRECTORY_SEPARATOR;

        public function register()
        {
            $this->registerConfig();
            $this->registerRoutes();
        }

        public function boot()
        {
            $this->loadTranslationsFrom($this->resourcesPath . 'lang', $this->packageNamespace);
            $this->loadViewsFrom($this->resourcesPath . 'views', $this->packageNamespace);

            $this->publishes([__DIR__ . '/config/livewire-forms.php' => config_path('livewire-forms.php')], 'livewire-forms:config');
            $this->publishes([__DIR__ . '/resources/views' => resource_path('views/vendor/' . $this->packageNamespace)], 'livewire-forms:views');

            $this->bootValidationRules();
        }

        public function registerConfig()
        {
            $this->mergeConfigFrom(__DIR__ . '/config/livewire-forms.php', 'livewire-forms');
        }

        public function registerRoutes()
        {
            Route::get('/livewire-forms/livewire-forms.js', [JavaScriptAssets::class, 'source']);
        }

        public function bootValidationRules()
        {
            Validator::extend(
                'float',
                function ($attribute, $value, $parameters, $validator) {
                    return preg_match('/^\d*(\.\d+)?$/', $value);
                }
            );
        }
    }
