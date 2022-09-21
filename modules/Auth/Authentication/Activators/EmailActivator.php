<?php

namespace Modules\Auth\Authentication\Activators;

use App\Entities\User;
use App\Libraries\Common;
use Config\Email;
use Modules\Auth\Entities\Auth;

/**
 * Class EmailActivator.
 *
 * Sends an activation email to user.
 */
class EmailActivator extends BaseActivator implements ActivatorInterface
{
    /**
     * Sends an activation email.
     *
     * @param User $user
     * @param Auth $auth
     */
    public function send(User $user = null, Auth $auth = null): bool
    {

        helper('html');

        $template = db_connect()->table('email_templates')->getWhere(['hook' => 'activation_notification'])->getRow();

        $url = site_url('auth/activate-account?token=' . $auth->activate_hash);

        $template->message = replace_keywords(
            [
                '{name}' => $user->name,
                '{activation_link}' => $url,
            ],
            $template->message
        );

        $config = new Email();
        $settings = $this->getActivatorSettings();

        $email = new \SendGrid\Mail\Mail();
        $email->setFrom($settings->fromEmail ?? $config->fromEmail, $settings->fromName ?? $config->fromName);
        $email->setSubject(lang('Auth.activationSubject'));
        $email->addTo($user->email);
        $email->addContent("text/html", $template->message);

        $sendgrid = new \SendGrid(getenv('SENDGRID_API_KEY'));

        $send = $sendgrid->send($email);

        if (!$send) {
            $this->error = lang('Auth.errorEmailSent', [$user->email]);
            return false;
        }

        return true;
    }
}
