<?php

namespace Tests\Feature\App\Http\Controllers\Auth;

use App\Http\Controllers\Auth\ForgotPasswordController;
use Database\Factories\ProductFactory;
use Database\Factories\UserFactory;
use Illuminate\Auth\Notifications\ResetPassword as ResetPasswordNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Tests\TestCase;

class ThumbnailControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     * @return void
     */
    public function it_generated_success(): void
    {


        $size = '500x500';
        $method = 'resize';
        $storage = Storage::disk('images');
        //$storage =  Storage::fake('images');

        config()->set('thumbnail', ['allowed_sizes' => [$size]]);

        $product  = ProductFactory::new()->create();

        $response = $this->get($product->makeThumbnail($size, $method));

       /* Image::shouldReceive('make')
            ->once()
            ->andReturnSelf()
            ->shouldReceive('resize')
            ->once()
            ->andReturnSelf()
            ->shouldReceive('save');*/

        $response->assertOk();

        $storage->assertExists(
            "products/$method/$size/" . File::basename($product->thumbnail)
        );
    }

}
