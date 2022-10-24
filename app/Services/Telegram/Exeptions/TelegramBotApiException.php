<?php
/**
 * Created by PhpStorm.
 * User: egoleva
 * Date: 22.10.22
 * Time: 19:53
 */

namespace App\Services\Telegram\Exeptions;


use http\Env\Request;

class TelegramBotApiException extends \Exception
{

    public function render(Request $request)
    {
        return response()->json([]);
    }
}