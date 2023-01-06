<?php

namespace Nodus\Packages\LivewireForms\Services\FormBuilder\Traits;

/**
 * Supports options form input trait
 *
 * @package Nodus\Packages\LivewireForms\Services\FormBuilder\Traits
 */
trait SupportsOptions
{
    /**
     * Options array
     *
     * @var array
     */
    protected array $options = [];

    /**
     * Sets the options array
     *
     * @param array $options
     *
     * @return $this
     */
    public function setOptions(array $options): static
    {
        $this->options = $options;

        return $this;
    }

    /**
     * Returns the options array
     *
     * @return array
     */
    public function getOptions(): array
    {
        return $this->options;
    }

    /**
     * Creates an option array
     *
     * @param string      $label
     * @param string|null $icon
     *
     * @return array
     */
    public static function option(string $label, ?string $icon = null): array
    {
        return compact('label', 'icon');
    }
}
