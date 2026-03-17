<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PublicMediaFallbackTest extends TestCase
{
    public function test_public_media_route_serves_a_file_from_the_public_disk(): void
    {
        Storage::fake('public');
        Storage::disk('public')->put('local-amenities/test-image.txt', 'bella-vista');

        $response = $this->get('/media/local-amenities/test-image.txt');

        $response->assertOk();
        $this->assertSame('bella-vista', $response->streamedContent());
    }
}
