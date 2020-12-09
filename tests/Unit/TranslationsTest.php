<?php

    namespace Tests\Unit;

    use Illuminate\Support\Arr;
    use Illuminate\Support\Facades\Lang;

    class TranslationsTest extends TestCase
    {
        public function testTransFileLoad()
        {
            $this->assertTrue(Lang::hasForLocale('nodus.packages.livewire-forms::forms.bootstrap_select.none_selected', 'de'));
            $this->assertTrue(Lang::hasForLocale('nodus.packages.livewire-forms::forms.bootstrap_select.none_selected', 'en'));
        }

        public function testTransFilesAreEquallyTranslated()
        {
            $expected = count(Arr::dot(trans('nodus.packages.livewire-forms::forms')));

            Lang::setLocale('de');
            $this->assertCount($expected, Arr::dot(trans('nodus.packages.livewire-forms::forms')));
            Lang::setLocale('en');
        }
    }