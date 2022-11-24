<?php
namespace Tests\Feature\Auth\Actions;

use Domain\Auth\Contracts\RegisterNewUserContract;
use Domain\Auth\DTOs\NewUserDTO;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegisterNewUserActionTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     * @return void
     */
    public function it_success_user_created():void
    {
        $this->assertDatabaseMissing('users',
            ['email' => 'test11@ya.ru']
        );

        $action = app(RegisterNewUserContract::class);
        $action(
            NewUserDTO::make(...['test', 'test11@ya.ru', '123456'])
        );

        $this->assertDatabaseHas('users',
            ['email' => 'test11@ya.ru']
        );

    }
}