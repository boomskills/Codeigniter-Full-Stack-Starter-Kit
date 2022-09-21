<?php

namespace Modules\Auth\Config;

use App\Models\UserModel;
use CodeIgniter\Model;
use Config\Services as BaseService;
use Modules\Auth\Authentication\Activators\ActivatorInterface;
use Modules\Auth\Authentication\Activators\UserActivator;
use Modules\Auth\Authentication\Passwords\PasswordValidator;
use Modules\Auth\Authentication\Resetters\EmailResetter;
use Modules\Auth\Authentication\Resetters\ResetterInterface;
use Modules\Auth\Authorization\FlatAuthorization;
use Modules\Auth\Authorization\PermissionModel;
use Modules\Auth\Authorization\RoleModel;
use Modules\Auth\Config\Auth as AuthConfig;
use Modules\Auth\Models\AuthModel;
use Modules\Auth\Models\LoginModel;

class Services extends BaseService
{
    public static function authentication(string $lib = 'local', Model $authModel = null, Model $loginModel = null, bool $getShared = true)
    {
        if ($getShared) {
            return self::getSharedInstance('authentication', $lib, $authModel, $loginModel);
        }

        $authModel = $authModel ?? new AuthModel();
        $loginModel = $loginModel ?? new LoginModel();

        /** @var AuthConfig $config */
        $config = config('Auth');
        $class = $config->authenticationLibs[$lib];
        $instance = new $class($config);

        return $instance->setAuthModel($authModel)->setLoginModel($loginModel);
    }

    public static function authorization(Model $roleModel = null, Model $permissionModel = null, Model $userModel = null, bool $getShared = true)
    {
        if ($getShared) {
            return self::getSharedInstance('authorization', $roleModel, $permissionModel, $userModel);
        }

        $roleModel = $roleModel ?? new RoleModel();
        $permissionModel = $permissionModel ?? new PermissionModel();
        $userModel = $userModel ?? new UserModel();

        $instance = new FlatAuthorization($roleModel, $permissionModel);

        return $instance->setUserModel($userModel);
    }

    /**
     * Returns an instance of the PasswordValidator.
     */
    public static function passwords(AuthConfig $config = null, bool $getShared = true): PasswordValidator
    {
        if ($getShared) {
            return self::getSharedInstance('passwords', $config);
        }

        return new PasswordValidator($config ?? config(AuthConfig::class));
    }

    /**
     * Returns an instance of the Activator.
     */
    public static function activator(AuthConfig $config = null, bool $getShared = true): ActivatorInterface
    {
        if ($getShared) {
            return self::getSharedInstance('activator', $config);
        }

        $config = $config ?? config(AuthConfig::class);
        $class = $config->requireActivation ?? UserActivator::class;

        return new $class($config);
    }

    /**
     * Returns an instance of the Resetter.
     */
    public static function resetter(AuthConfig $config = null, bool $getShared = true): ResetterInterface
    {
        if ($getShared) {
            return self::getSharedInstance('resetter', $config);
        }

        $config = $config ?? config(AuthConfig::class);
        $class = $config->activeResetter ?? EmailResetter::class;

        return new $class($config);
    }
}