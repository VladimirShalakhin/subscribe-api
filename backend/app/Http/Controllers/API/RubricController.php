<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\EmailService;

class RubricController extends Controller
{
    public function get($rubric)
    {
        $email = app(EmailService::class);
        $result = $email->getVerifiedRubricEmails($rubric);

        return response()->json($result);
    }
}
