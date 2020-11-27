<?php

    namespace Nodus\Packages\LivewireForms\Services\FormBuilder\Traits;

    use Illuminate\Support\Str;

    /**
     * Supports translations form input trait
     *
     * @package Nodus\Packages\LivewireForms\Services\FormBuilder\Traits
     */
    trait SupportsTranslations
    {
        /**
         * Sets a translation string for the given key
         *
         * @param string $key
         * @param string $translation
         *
         * @return $this
         */
        public function setTranslation(string $key, string $translation)
        {
            $this->translations[ $key ] = $translation;

            return $this;
        }

        /**
         * Returns the translated string for the given key
         *
         * @param string $key
         *
         * @return string
         */
        public function getTranslation(string $key)
        {
            if ( !isset($this->translations[ $key ])) {
                null;
            }

            return trans($this->translations[ $key ]);
        }

        /**
         * Resolves and dispatches an magic method call
         *
         * @param string $name
         * @param array  $arguments
         *
         * @return SupportsTranslations|string|null
         */
        protected function resolveTranslationMethod(string $name, array $arguments)
        {
            if ( !Str::endsWith($name, 'Text')) {
                return null;
            }

            $key = Str::snake(Str::substr(Str::substr($name, 3), 0, -4));

            if (Str::startsWith($name, 'get')) {
                return $this->getTranslation($key);
            }

            if (Str::startsWith($name, 'set')) {
                return $this->setTranslation($key, ...$arguments);
            }

            return null;
        }

        /**
         * Magic Call method emulating the getter and setters for the translations
         *
         * @param string $name
         * @param array  $arguments
         *
         * @return SupportsTranslations|string
         */
        public function __call(string $name, array $arguments)
        {
            if ($return = $this->resolveTranslationMethod($name, $arguments)) {
                return $return;
            }

            throw new \InvalidArgumentException('Method ' . $name . ' not exists');
        }
    }
