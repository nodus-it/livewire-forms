<?php

namespace Nodus\Packages\LivewireForms\Tests\Unit;

use Nodus\Packages\LivewireForms\Controllers\JavaScriptAssets;
use Nodus\Packages\LivewireForms\Tests\TestCase;

class JavascriptAssetsTest extends TestCase
{
    public function testSource()
    {
        $controller = new JavaScriptAssets();
        $response = $controller->source();

        $this->assertSame(200, $response->getStatusCode());
        $this->assertSame('application/javascript; charset=utf-8', $response->headers->get('Content-Type'));
    }
}
