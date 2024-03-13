<?php

    namespace Nodus\Packages\LivewireForms\Controllers;

    use Illuminate\Http\Response;
    use Illuminate\Support\Arr;

    class JavaScriptAssets
    {
        public function source(): Response
        {
            return $this->pretendResponseIsFile(
                [
                    __DIR__ . '/../resources/js/DecimalInput.js',
                    __DIR__ . '/../resources/js/FormView.js',
                ]
            );
        }

        protected function pretendResponseIsFile($files): Response
        {
            $files = Arr::wrap($files);
            $content = '';
            $expires = strtotime('+1 year');
            $lastModified = filemtime($files[0]);//todo
            $cacheControl = 'public, max-age=31536000';

            foreach ($files as $file) {
                $content .= file_get_contents($file);
            }

            return response(
                $content,
                200,
                [
                    'Content-Type'  => 'application/javascript; charset=utf-8',
                    'Expires'       => $this->httpDate($expires),
                    'Cache-Control' => $cacheControl,
                    'Last-Modified' => $this->httpDate($lastModified),
                ]
            );
        }

        protected function httpDate($timestamp): string
        {
            return sprintf('%s GMT', gmdate('D, d M Y H:i:s', $timestamp));
        }
    }
