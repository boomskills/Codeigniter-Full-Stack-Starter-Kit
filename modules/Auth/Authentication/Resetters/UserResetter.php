<?php

namespace Modules\Auth\Authentication\Resetters;

use App\Entities\User;
use Modules\Auth\Entities\Auth;

class UserResetter extends BaseResetter implements ResetterInterface
{
    /**
     * Sends reset message to the user via specified class
     * in `$activeResetter` setting in Config\Auth.php.
     *
     * @param User $user
     * @param Auth $auth
     */
    public function send(User $user = null, Auth $auth = null): bool
    {
        if (null === $this->config->activeResetter) {
            return true;
        }

        $className = $this->config->activeResetter;

        $class = new $className();
        $class->setConfig($this->config);

        if (false === $class->send($user, $auth)) {
            log_message('error', lang('Auth.errorResetting', [$user->email]));
            $this->error = $class->error();

            return false;
        }

        return true;
    }
}