<?php

namespace Modules\Auth\Controllers;

use App\Models\PhoneModel;
use App\Libraries\Twilio\Service;
use Modules\Auth\Events\PhoneVerified;

/**
 * Class PhoneVerificationController
 */
class PhoneVerificationController extends BaseAuthController
{
    /**
     * Verification service.
     *
     * @var Service
     */
    protected $verify;

    /**
     * Create a new controller instance.
     */
    public function __construct(Service $verify)
    {
        parent::__construct();
        $this->verify = $verify;
    }

    /**
     * Mark the authenticated user's phone number as verified.
     *
     * @return JsonResponse
     */
    public function verify()
    {

        if (!$this->auth->user()->phone) {
            return $this->fail([
                'message' =>  "There is no phone number associated with your account. Please setup phone number and try again later."
            ]);
        }

        // phone already verified
        if ($this->auth->user()->phone() != null && $this->auth->user()->isPhoneVerified()) {
            return $this->fail([
                'message' => "Phone already verified",
            ]);
        }

        if (!$this->validate([
            'code' => ['required'],
        ])) {
            return $this->fail($this->validate->errors);
        }

        $code = $this->request->getVar('code');

        $verification = $this->verify->checkVerification($this->auth->user()->phone, $code);

        if ($verification->isValid()) {
            // store phone to user phone
            $phoneId = (new PhoneModel())->insert([
                "phone" => $this->auth->user()->phone,
                'user_id' => auth_id()
            ], true);

            // get newly created model
            $phone = (new PhoneModel())->find($phoneId);

            // set verify attributes
            $phone = $phone->verify();

            // verify
            (new PhoneModel())->save($phone);

            // trigger phone verified event
            (new PhoneVerified($this->auth))->handle();

            return $this->resend(['message' => "You phone number has been verified. You will now receive notifications via sms and WhatsApp"]);
        }

        $errors = [];

        foreach ($verification->getErrors() as $error) {
            array_push($errors['verification'], $error);
        }

        return $this->fail($errors);
    }

    /**
     * Resend the phone verification code.
     *
     * @return JsonResponse
     */
    public function resend($userId = null)
    {
        if (!$this->auth->user()->phone) {
            return $this->fail([
                'message' =>  "There is no phone number associated with your account. Please setup phone number and try again later."
            ]);
        }

        // phone already verified
        if ($this->auth->user()->phone() != null && $this->auth->user()->phone()->isVerified()) {
            return $this->fail([
                'message' => "Phone already verified",
            ]);
        }

        // from the model
        $phone = $this->auth->user()->phone;

        $verification = $this->verify->startVerification($phone, 'sms');

        if (!$verification->isValid()) {

            $errors = [];

            foreach ($verification->getErrors() as $error) {
                array_push($errors['verification'], $error);
            }

            return $this->fail($errors);
        }

        return $this->respond(['verification' => "A verification code has been sent to {$phone}"]);
    }
}
