<?php

namespace Nodus\Packages\LivewireForms\Tests\Unit\InputTests;

use Livewire\TemporaryUploadedFile;
use Nodus\Packages\LivewireForms\Services\FormBuilder\File;
use Nodus\Packages\LivewireForms\Tests\TestCase;

class FileInputTest extends TestCase
{
    public function testDefaults()
    {
        $input = new File('file_input', 'file_input_label');

        $this->assertSame('file_input_label', $input->getLabel());
        $this->assertSame('file_input', $input->getId());
        $this->assertSame('file_input', $input->getName());
        $this->assertSame('file', $input->getType());
        $this->assertSame('values.file_input', $input->getViewId());
        $this->assertSame(null, $input->getAcceptFormats());

        $input = File::create('file_input', 'file_input_label');
        $this->assertSame('file_input_label', $input->getLabel());
        $this->assertSame('file_input', $input->getId());
        $this->assertSame('file_input', $input->getName());
        $this->assertSame('file', $input->getType());
        $this->assertSame('values.file_input', $input->getViewId());
        $this->assertSame(null, $input->getAcceptFormats());
    }

    public function testAcceptFormats()
    {
        $input = new File('file_input', 'file_input_label');
        $this->assertSame(null, $input->getAcceptFormats());
        $input->setAcceptFormats('image/jpeg');
        $this->assertSame('image/jpeg', $input->getAcceptFormats());
    }

    public function testPreRenderMutator()
    {
        $upload = $this->mock(TemporaryUploadedFile::class);

        $input = new File('file_input', 'file_input_label');
        $this->assertSame(null, $input->preRenderMutator(null));
        $this->assertSame(null, $input->preRenderMutator('/test/path/file.txt'));
        $this->assertSame($upload, $input->preRenderMutator($upload));

        $input->setMultiple();
        $this->assertSame([], $input->preRenderMutator(null));
        $this->assertSame([], $input->preRenderMutator('/test/path/file.txt'));
        $this->assertSame([], $input->preRenderMutator(['/test/path/file.txt']));
        $this->assertSame([], $input->preRenderMutator($upload));
        $this->assertSame([$upload], $input->preRenderMutator([$upload]));
    }
}
