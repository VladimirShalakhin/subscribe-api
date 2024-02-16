<?php

namespace App\Http\Controllers\API;

use App\Exceptions\EmailDoesntExistException;
use App\Exceptions\RubricDoesntExistException;
use App\Exceptions\SubscriptionConfirmationException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Subscribe\SubscribeRequest;
use App\Http\Requests\Subscribe\UnsubscribeRequest;
use App\Mail\UserSubscribeUnsubscribe;
use App\Models\Email;
use App\Models\EmailRubric;
use App\Models\Rubric;
use App\Services\EmailService;
use App\Services\RubricService;
use DB;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class SubscribeController extends Controller
{
    /**
     * Не авторизованный пользователь, создать подписку только по email (пункт 4)
     */
    public function subscribe(SubscribeRequest $request): JsonResponse
    {
        //токен для подтверждения
        $token = hash('sha256', time());
        //получил данные из запроса
        $email = $request->input('email');
        $rubric_ids = $request->input('rubric_ids');

        //убрал ненужное условие с ошибкой, если указанная почта не существует - создаю ее
        //внес в базу или получил почту (если уже такая была) и получил id
        $email = Email::firstOrCreate(['value' => $email]);
        foreach ($rubric_ids as $rubric_id) {
            $email->rubrics()->attach($rubric_id, ['token' => $token]);
        }

        $subject = 'Please confirm subscription';

        $action = 'confirmsubsctiption';

        Mail::to($email->value)->send(new UserSubscribeUnsubscribe($subject, $token, $email, $rubric_ids, $action));

        return response()->json('ok');
    }

    /**
     * Подтвердить подписку, пункт 4
     * @throws EmailDoesntExistException
     * @throws RubricDoesntExistException
     * @throws SubscriptionConfirmationException
     */
    public function confirmSubscription($token, $address, $rubric): JsonResponse
    {
        $email = app(EmailService::class);
        $email_id = $email->getByValue($address);
        $rubric = explode(',', $rubric);
        $rubricService = app(RubricService::class);
        //проверяю, что такие рубрики существуют, если нет - ошибка
        $rubricService->checkExist($rubric);
        $emailService = app(EmailService::class);
        foreach ($rubric as $rubric_item) {
            //проверяю, что есть такая почта с такой подпиской неподтвержденная, если нет - ошибка
            $emailService->checkEmailUnverifiedRubrics($token, $email_id, $rubric_item);
            DB::table('email_rubric')->where('email_id', $email_id)->where('token', $token)->update(['token' => '', 'confirmed_at' => now()]);
        }

        return response()->json('Successfully confirmed subscription to rubrics');
    }

    public function unsubscribe(UnsubscribeRequest $request): JsonResponse
    {
        $token = hash('sha256', time());
        $email = $request->input('email');
        //only one value allowed for unsubscription
        $rubric_id = $request->input('rubric_id');

        if (Email::where('value', $email)->doesntExist()) {
            return response()->json([
                'message' => 'Email doesn\'t exists',
            ], 400);
        }

        $rubric = Rubric::find($rubric_id);
        if (empty($rubric_id->id)) {
            return response()->json([
                'message' => 'Rubric doesn\'t exist',
            ], 400);
        }

        $email = Email::whereValue($email)->get()->firstOrFail();

        $email->rubrics()->updateExistingPivot($rubric_id, ['token' => $token]);

        $subject = 'Please confirm unsubscription';

        $action = 'confirmunsubscription';

        Mail::to($email->value)->send(new UserSubscribeUnsubscribe($subject, $token, $email, [$rubric_id], $action));

        return response()->json('ok');
    }

    public function confirmUnsubscription($token, $address)
    {
        $email = Email::where('value', $address)->first(['id']);

        if (empty($email->id)) {
            return response()->json([
                'message' => 'Email doesn\'t exist',
            ], 400);
        }

        DB::table('email_rubric')->where('email_id', $email->id)->where('token', $token)->delete();

        return response()->json('Successfully confirmed unsubscription to rubric');
    }

    public function unsubscribeAll(Request $request)
    {
        $token = hash('sha256', time());
        $email = $request->input('email');
        $email_id = Email::where('value', $email)->first(['id']);
        if (empty($email_id)) {
            return response()->json([
                'message' => 'Email doesn\'t exist',
            ], 400);
        }
        $email = Email::whereValue($email)->get()->firstOrFail();
        DB::table('email_rubric')->where('email_id', $email->id)->update(['token' => $token]);

        $rubrics = EmailRubric::select('rubric_id')->where('email_id', $email->id)->get()->toArray();
        $rubric_ids = [];
        foreach ($rubrics as $rubric) {
            $rubric_ids[] = $rubric['rubric_id'];
        }

        $subject = 'Please confirm unsubscription from all rubrics';

        $action = 'confirmunsubsctiptionall';

        Mail::to($email->value)->send(new UserSubscribeUnsubscribe($subject, $token, $email, $rubric_ids, $action));

        return response()->json('ok');
    }

    public function confirmUnsubscribeAll($token, $address)
    {
        $email = Email::where('value', $address)->first(['id']);

        if (empty($email)) {
            return response()->json([
                'message' => 'Email doesn\'t exist',
            ], 400);
        }
        $subscription_ids = DB::table('email_rubric')->where('email_id', $email->id)->where('token', $token)->select('id');
        if (empty($subscription_ids)) {
            return response()->json([
                'message' => 'Email doesn\'t have active subscriptions',
            ], 400);
        }

        $email = Email::where('value', $address)->first(['id']);
        DB::table('email_rubric')->where('email_id', $email->id)->where('token', $token)->delete();

        return response()->json('Successfully confirmed unsubscription to all rubrics');
    }
}
