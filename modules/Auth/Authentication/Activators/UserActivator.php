<?php

namespace Modules\Auth\Authentication\Activators;

use App\Entities\User;
use Modules\Auth\Entities\Auth;

class UserActivator extends BaseActivator implements ActivatorInterface
{
    /**
     * Sends activation message to the user via specified class
     * in `$requireActivation` setting in Config\Auth.php.
     *
     * @param User $user
     * @param Auth $auth
     */
    public function send(User $user = null, Auth $auth = null): bool
    {
        if (!$this->config->requireActivation) {
            return true;
        }

        $className = $this->config->requireActivation;

        $class = new $className();
        $class->setConfig($this->config);

        if (false === $class->send($user, $auth)) {
            log_message('error', "Failed to send activation message to: {$user->email}");
            $this->error = $class->error();

            return false;
        }

        return true;
    }
}
