<?php

namespace Modules\Auth\Config;


$routes->group('auth', ['namespace' => 'Modules\Auth\Controllers'], function ($auth) {
    // Login/Logout
    $auth->get('login', 'LoginAuthController::login', ['as' => 'login']);
    $auth->post('login', 'LoginAuthController::attemptLogin');
    $auth->get('login/google-oauth2', 'SocialLoginAuthController::googleOauthLogin');
    $auth->get('logout', 'LogoutApiController::logout');

    // Registration
    $auth->get('register-account', 'RegisterAuthController::register', ['as' => 'register']);
    $auth->post('register-account', 'RegisterAuthController::attemptRegister');

    // Activation
    $auth->get('activate-account', 'ActivationAuthController::activateAccount', ['as' => 'activate-account']);
    $auth->get('resend-activate-account', 'ActivationAuthController::resendActivateAccount', ['as' => 'resend-activate-account']);

    // Forgot
    $auth->get('forgot-password', 'ForgotPasswordAuthController::forgotPassword', ['as' => 'forgot']);
    $auth->post('forgot-password', 'ForgotPasswordAuthController::attemptForgot');

    // Resets
    $auth->get('reset-password', 'ResetPasswordAuthController::resetPassword', ['as' => 'reset-password']);
    $auth->post('reset-password', 'ResetPasswordAuthController::attemptReset');

    // account management
    $auth->group('',  ['namespace' => 'Modules\Auth\Controllers', 'filter' => 'login'], function ($account) {
        $account->match(['put', 'patch'], 'update-account', 'AuthController::attemptUpdate');
        $account->post('change-email', 'AuthController::attemptChangeEmail');
        $account->post('change-password', 'AuthController::attemptChangePassword');
        $account->delete('delete-account', 'AuthController::deleteAccount');
    });
});
