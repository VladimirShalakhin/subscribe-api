<?php

namespace App\Services;

use App\Exceptions\EmailDoesntExistException;
use App\Exceptions\EmailExistsVerifiedException;
use App\Exceptions\SubscriptionConfirmationException;
use App\Models\Email;
use Illuminate\Support\Facades\DB;

class EmailService
{
    /**
     * @throws EmailExistsVerifiedException
     */
    public function check(int $email_id): bool
    {
        $email = Email::where('id', $email_id)->get('verified')->first();
        if (empty($email) || $email->verified) {
            throw new EmailExistsVerifiedException();
        }

        return true;
    }

    public function getVerifiedRubricEmails(int $rubric_id): array
    {
        $emails = DB::table('emails')->select('emails.value', 'email_rubric.confirmed_at')->join('email_rubric', 'email_rubric.email_id', '=', 'emails.id')->where('emails.verified', '=', true)->where('email_rubric.rubric_id', '=', $rubric_id)->get();
        $result = [];
        foreach ($emails->all() as $item) {
            $result[] = $item;
        }

        return $result;
    }

    /**
     * @throws EmailDoesntExistException
     */
    public function getByValue(string $email): int
    {
        $email = Email::where('value', $email)->first(['id']);
        if (empty($email->id)) {
            throw new EmailDoesntExistException();
        }

        return $email->id;
    }

    /**
     * @throws SubscriptionConfirmationException
     */
    public function checkEmailUnverifiedRubrics(string $token, int $email_id, int $rubric_id): void
    {
        if (DB::table('email_rubric')->where('email_id', $email_id)->where('token', $token)->where('rubric_id', $rubric_id)->doesntExist()) {
            throw new SubscriptionConfirmationException();
        }
    }
}
