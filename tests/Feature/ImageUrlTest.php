<?php

namespace Tests\Feature;

use Tests\TestCase;

class ImageUrlTest extends TestCase
{
    public function test_image_url_resolves_every_case(): void
    {
        // kosong -> gambar bawaan
        $this->assertSame(asset('image/user-default.jpg'), image_url(null));
        $this->assertSame(asset('image/menu-default.svg'), image_url('', 'image/menu-default.svg'));

        // URL luar dipakai apa adanya
        $remote = 'https://picsum.photos/seed/nasi-goreng/400/300';
        $this->assertSame($remote, image_url($remote));

        // file yang ada di public/
        $this->assertSame(asset('image/user-default.jpg'), image_url('image/user-default.jpg'));

        // hasil upload di storage/app/public
        $upload = public_path('storage/menu/probe-image-url.txt');
        @mkdir(dirname($upload), 0755, true);
        file_put_contents($upload, 'probe');

        try {
            $this->assertSame(asset('storage/menu/probe-image-url.txt'), image_url('menu/probe-image-url.txt'));
        } finally {
            @unlink($upload);
        }

        // file upload yang sudah hilang -> balik ke gambar bawaan
        $this->assertSame(asset('image/user-default.jpg'), image_url('users/tidak-ada.jpg'));
    }
}
