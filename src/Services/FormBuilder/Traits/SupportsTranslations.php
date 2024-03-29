<?php

namespace Nodus\Packages\LivewireForms\Services\FormBuilder\Traits;

use Illuminate\Support\Str;
use InvalidArgumentException;

/**
 * Supports translations form input trait
 *
 * @package Nodus\Packages\LivewireForms\Services\FormBuilder\Traits
 * @property array $translations
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
    public function setTranslation(string $key, string $translation): static
    {
        $this->translations[ $key ] = $translation;

        return $this;
    }

    /**
     * Returns the translated string for the given key
     *
     * @param string $key
     *
     * @return string|null
     */
    public function getTranslation(string $key): ?string
    {
        if (!isset($this->translations[ $key ])) {
            return null;
        }

        return trans($this->translations[ $key ]);
    }

    /**
     * Resolves and dispatches a magic method call
     *
     * @param string $name
     * @param array  $arguments
     *
     * @return static|string|null
     */
    protected function resolveTranslationMethod(string $name, array $arguments): string|static|null
    {
        if (!Str::endsWith($name, 'Text')) {
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
        $return = $this->resolveTranslationMethod($name, $arguments);

        if ($return !== null) {
            return $return;
        }

        throw new InvalidArgumentException('Method ' . $name . ' not exists');
    }
}
