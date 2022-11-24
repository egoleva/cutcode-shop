<?php

namespace Tests\Feature\App\Http\Controllers;


use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\SignInController;
use App\Http\Controllers\Auth\SignUpController;
use App\Http\Controllers\AuthController;
use App\Http\Requests\SignInFormRequest;
use App\Http\Requests\SignUpFormRequest;
use App\Listeners\SendEmailNewUserListener;
use App\Notifications\NewUserNotification;
use Database\Factories\UserFactory;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;
use Tests\RequestFactories\SignUpFormRequestFactory;
use Tests\TestCase;
use Throwable;
//use App\Models\User;
use Domain\Auth\Models\User;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     * @return void
     */
    public function it_sign_in_success(): void
    {
        Notification::fake();
        Event::fake();

        /*$request = [
            'name',
            'email',
            'password'
        ];*/


        $request = SignUpFormRequest::factory()->create([
            'email' => 'test@ya.ru',
            'password' => '1234567890',
            'password_confirmation' => '1234567890'
        ]);

        $this->assertDatabaseMissing('users', [
            'email' => $request['email']
        ]);

        $response = $this->post(
            action([SignUpController::class, 'handle']),
            $request
        );

        $user = User::query()
            ->where('email', $request['email'])
            ->first();

        $response->assertValid();

        $this->assertDatabaseHas('users', [
            'email' => $request['email']
        ]);

        Event::assertDispatched(Registered::class);
        Event::assertListening(Registered::class, SendEmailNewUserListener::class);

        $event = new Registered($user);
        $listener = new SendEmailNewUserListener();
        $listener->handle($event);

        Notification::assertSentTo($user, NewUserNotification::class);

        $this->assertAuthenticatedAs($user);

        $response->assertRedirect(route('home'));
    }

    /**
     * @test
     * @return void
     */
    public function it_login_page_success():void
    {
        $this->get(action([SignInController::class, 'page']))
            ->assertOk()
            ->assertSee('Вход в аккаунт')
            ->assertViewIs('auth.login');
    }

    /**
     * @test
     * @return void
     */
    public function it_sign_up_page_success():void
    {
        $this->get(action([SignUpController::class, 'page']))
            ->assertOk()
            ->assertSee('Регистрация')
            ->assertViewIs('auth.sign-up');
    }

    /**
     * @test
     * @return void
     */
    public function it_forgot_page_success():void
    {
        $this->get(action([ForgotPasswordController::class, 'page']))
            ->assertOk()
            ->assertViewIs('auth.forgot-password');
    }

    /**
     * @test
     * @return void
     */
    public function it_sign_in_page_success():void
    {
        $password = '123456789';
        $user = UserFactory::new()->create([
            'email' => 'test@yandex.ru',
            'password' => bcrypt($password)
        ]);
        $request = SignInFormRequest::factory()->create([
            'email' => $user->email,
            'password' => $password
        ]);

        $response = $this->post(
            action([SignInController::class, 'handle']),
            $request
        );

        $response->assertValid()
            ->assertRedirect(route('home'));

        $this->assertAuthenticatedAs($user);
    }

    /**
     * @test
     * @return void
     */
    public function it_logout_page_success():void
    {
        $user = UserFactory::new()->create([
            'email' => 'test@yandex.ru',
        ]);

        $this->actingAs($user)
            ->delete(action([SignInController::class, 'logout']));

        $this->assertGuest();
    }

}