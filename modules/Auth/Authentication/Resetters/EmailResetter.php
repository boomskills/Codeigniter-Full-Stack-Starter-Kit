<?php

namespace Modules\Auth\Authentication\Resetters;

use App\Entities\User;
use App\Libraries\Common;
use Config\Email;
use Modules\Auth\Entities\Auth;

/**
 * Class EmailResetter.
 *
 * Sends a reset password email to user.
 */
class EmailResetter extends BaseResetter implements ResetterInterface
{
    /**
     * Sends a reset email.
     *
     * @param User $user
     * @param Auth $auth
     */
    public function send(User $user = null, Auth $auth = null): bool
    {

        helper('html');

        // prevent admin user from resetting password
        if ('webmaster@citystriders.com' == $user->email || 1 == $user->id) {
            return false;
        }

        // prepare message
        $template = db_connect()->table('email_templates')->getWhere(['hook' => 'forgot_password'])->getRow();

        $resetUrl = site_url('auth/reset-password?token=' . $auth->reset_hash . '&identity=' . $auth->identity);

        $template->message = (new Common())->replace_keywords(
            [
                '{name}' => $user->name,
                '{reset_link}' => $resetUrl,
                '{hash' => $auth->reset_hash,
                '{site_url}' => site_url(),
                '{site_name}' => service('settings')->info->site_title,
            ],
            $template->message
        );

        $config = new Email();
        $settings = $this->getResetterSettings();

        $email = new \SendGrid\Mail\Mail();
        $email->setFrom($settings->fromEmail ?? $config->fromEmail, $settings->fromName);
        $email->setSubject(lang('Auth.forgotSubject'));
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
