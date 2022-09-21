<?php

namespace Modules\Auth\Config;

///////////////////////////////////////////////////////////////////////////////////
//////////////////////////////// AUTH ROUTES //////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////
$routes->group('auth', ['namespace' => 'Modules\Auth\Controllers'], function ($auth) {
    // Login/Logout
    $auth->get('login', 'LoginAuthController::login', ['as' => 'login']);
    $auth->post('login', 'LoginAuthController::attemptLogin');
    $auth->get('login/google-oauth2', 'SocialLoginAuthController::googleOauthLogin');
    $auth->get('logout', 'LogoutApiController::logout');

    // Registration
    $auth->get('register', 'RegisterAuthController::register', ['as' => 'register']);
    $auth->post('register', 'RegisterAuthController::attemptRegister');

    // Activation
    $auth->get('activate-account', 'ActivationAuthController::activateAccount', ['as' => 'activate-account']);
    $auth->get('resend-activate-account', 'ActivationAuthController::resendActivateAccount', ['as' => 'resend-activate-account']);

    // Forgot
    $auth->get('forgot', 'ForgotPasswordAuthController::forgotPassword', ['as' => 'forgot']);
    $auth->post('forgot', 'ForgotPasswordAuthController::attemptForgot');

    // Resets
    $auth->get('reset-password', 'ResetPasswordAuthController::resetPassword', ['as' => 'reset-password']);
    $auth->post('reset-password', 'ResetPasswordAuthController::attemptReset');

    // account management
    $auth->group('',  ['namespace' => 'Modules\Auth\Controllers', 'filter' => 'login'], function ($account) {
        // Phone Verification
        $account->post('verify-phone', 'PhoneVerificationController::verify');
        $account->get('resend-phone-verification', 'PhoneVerificationController::resend');

        $account->match(['put', 'patch'], 'update-account', 'AuthController::attemptUpdate');
        $account->post('change-avatar', 'AuthController::attemptChangeAvatar');
        $account->post('change-email', 'AuthController::attemptChangeEmail');
        $account->post('change-password', 'AuthController::attemptChangePassword');
        $account->delete('delete-account', 'AuthController::attemptDelete');
    });
});
