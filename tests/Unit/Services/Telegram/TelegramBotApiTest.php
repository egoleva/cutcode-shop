<?php

namespace Tests\Unit\Services\Telegram;


use Illuminate\Support\Facades\Http;
use Services\Telegram\TelegramBotApi;
use Tests\TestCase;

class TelegramBotApiTest extends TestCase
{
    /**
     * @test
     * @return void
     */
    public function it_send_message_success(): void
    {
        Http::fake([
            TelegramBotApi::HOST . '*' => Http::response(['ok' => true], 200)
        ]);
        $result = TelegramBotApi::sendMessage('',1, 'Testing');

        $this->assertTrue($result);

    }
}