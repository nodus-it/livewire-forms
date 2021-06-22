<?php

namespace Tests\Unit\InputTests;

use Nodus\Packages\LivewireForms\Services\FormBuilder\Html;
use Tests\Unit\TestCase;

class HtmlTest extends TestCase
{
    public function testDefaults()
    {
        $input = new Html('test-id', '<b>test_section</b>');
        $this->assertSame('<b>test_section</b>', $input->getLabel());
        $this->assertSame('test-id', $input->getId());
        $this->assertSame('test-id', $input->getName());
        $this->assertSame('html', $input->getType());
        $this->assertSame('values.test-id', $input->getViewId());
        $this->assertSame(12, $input->getSize());
    }
}