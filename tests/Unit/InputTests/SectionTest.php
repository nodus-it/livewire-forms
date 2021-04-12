<?php

namespace Tests\Unit\InputTests;

use Nodus\Packages\LivewireForms\Services\FormBuilder\Code;
use Nodus\Packages\LivewireForms\Services\FormBuilder\Section;
use Nodus\Packages\LivewireForms\Services\FormBuilder\Text;
use Tests\Unit\TestCase;

class SectionTest extends TestCase
{
    public function testDefaults()
    {
        $input = new Section('test_section');

        $this->assertSame('test_section',$input->getLabel());
        $this->assertSame('test_section',$input->getId());
        $this->assertSame('test_section',$input->getName());
        $this->assertSame('section',$input->getType());
        $this->assertSame('values.test_section',$input->getViewId());
        $this->assertSame(12,$input->getSize());
    }

    public function testHtmlMode()
    {
        $input = new Section('<b>HTML Test</b>');
        $this->assertSame('&lt;b&gt;HTML Test&lt;/b&gt;',$input->getLabel());
        $input->enableHtml();
        $this->assertSame('<b>HTML Test</b>',$input->getLabel());
    }
}