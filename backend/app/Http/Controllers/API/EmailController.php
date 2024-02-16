<?php

namespace App\Http\Controllers\API;

use App\Exceptions\EmailExistsVerifiedException;
use App\Http\Controllers\Controller;
use App\Models\Email;
use App\Services\EmailService;

class EmailController extends Controller
{
    /**
     * @throws EmailExistsVerifiedException
     */
    public function verify($email_id, $token)
    {
        $email = app(EmailService::class);
        $email->check($email_id);
        Email::where('id', $email_id)->where('token', $token)->update(['verified' => true, 'token' => '']);

        return response()->json('Почта успешно подтверждена');
    }
}
