<?php

return [
    // Exceptions
    'invalidModel' => 'The {0} model must be loaded prior to use.',
    'authNotFound' => 'Unable to locate a account with ID = {0, number}.',
    'noAuthEntity' => 'Account Entity must be provided for password validation.',
    'tooManyCredentials' => 'You may only validate against 1 credential other than a password.',
    'invalidFields' => 'The "{0}" field cannot be used to validate credentials.',
    'unsetPasswordLength' => 'You must set the `minimumPasswordLength` setting in the Auth config file.',
    'unknownError' => 'Sorry, we encountered an issue sending the email to you. Please try again later.',
    'notLoggedIn' => 'You must be logged in to access that page.',
    'notEnoughPrivilege' => 'You do not have sufficient permissions to access that page.',

    // Registration
    'registerDisabled' => 'Sorry, new accounts are not allowed at this time.',
    'registerSuccess' => 'Your account is successfully created. Please go to your inbox for a link to activate your account.',
    'registerCLI' => 'New account created: {0}, #{1}',

    // Activation
    'activationNoAccount' => 'Unable to locate a account with that activation code.',
    'activationSubject' => 'Account Activation at City Striders Club',
    'activationSendSuccess' => ' You may now activate your account by clicking the activation link in the email we have sent to you.',
    'activatedSuccess' => 'Thank you for joining us. Account is successfully activated, you may now go ahead and login.',
    'activationResend' => 'Resend activation link once more.',
    'notActivated' => 'This account is not yet activated.',
    'errorSendingActivation' => 'Failed to send activation message to: {0}',

    // Login
    'badAttempt' => 'Unable to log you in. Please check your credentials.',
    'loginSuccess' => 'Welcome back!',
    'invalidPassword' => 'Unable to log you in. Please check your password.',

    // Forgotten Passwords
    'forgotDisabled' => 'Resetting password option has been disabled.',
    'forgotNoAccount' => 'Unable to locate a account with the given ID.',
    'forgotSubject' => 'Password Reset Instructions',
    'resetSuccess' => 'Your password has been successfully changed. Please login with the new password.',
    'forgotEmailSent' => 'A security token has been emailed to you. Enter it in the box below to continue.',
    'errorEmailSent' => 'Unable to send email with password reset instructions to: {0}',
    'errorResetting' => 'Unable to send reset instructions to {0}',
    'errorResetTokenInvalid' => 'Invalid reset token',

    // Passwords
    'errorPasswordLength' => 'Passwords must be at least {0, number} characters long.',
    'suggestPasswordLength' => 'Pass phrases - up to 255 characters long - make more secure passwords that are easy to remember.',
    'errorPasswordCommon' => 'Password must not be a common password.',
    'suggestPasswordCommon' => 'The password was checked against over 65k commonly used passwords or passwords that have been leaked through hacks.',
    'currentPasswordWrong' => 'Your current password is wrong.',
    'errorPasswordPersonal' => 'Passwords cannot contain re-hashed personal information.',
    'suggestPasswordPersonal' => 'Variations on your email address or username should not be used for passwords.',
    'errorPasswordTooSimilar' => 'Password is too similar to the username.',
    'suggestPasswordTooSimilar' => 'Do not use parts of your username in your password.',
    'errorPasswordPwned' => 'The password {0} has been exposed due to a data breach and has been seen {1, number} times in {2} of compromised passwords.',
    'errorPasswordChange' => "New password cannot be the same as the current password.",
    'suggestPasswordPwned' => '{0} should never be used as a password. If you are using it anywhere change it immediately.',
    'errorPasswordPwnedDatabase' => 'a database',
    'errorPasswordPwnedDatabases' => 'databases',
    'errorPasswordEmpty' => 'A Password is required.',
    'passwordChangeSuccess' => 'Password changed successfully',
    'accountDoesNotExist' => 'Password was not changed. Account does not exist',
    'resetTokenExpired' => 'Sorry. Your reset token has expired.',

    // roles
    'roleNotFound' => 'Unable to locate role: {0}.',

    // Permissions
    'permissionNotFound' => 'Unable to locate permission: {0}',

    // Banned
    'accountIsBanned' => 'This account has been banned. Contact the administrator',

    // Too many requests
    'tooManyRequests' => 'Too many requests. Please wait {0, number} seconds.',

    // Login views
    'current' => 'Current',
    'forgotPassword' => 'Forgot Your Password?',
    'enterEmailForInstructions' => 'No problem! Enter your email below and we will send instructions to reset your password.',
    'email' => 'Email',
    'emailAddress' => 'Email Address',
    'username' => 'Username',
    'sendInstructions' => 'Send Instructions',
    'loginTitle' => 'Login',
    'loginAction' => 'Login',
    'rememberMe' => 'Remember me',
    'needAnAccount' => 'Need an account?',
    'forgotYourPassword' => 'Forgot your password?',
    'password' => 'Password',
    'repeatPassword' => 'Repeat Password',
    'emailOrUsername' => 'Email or username',
    'username' => 'Username',
    'register' => 'Register',
    'signIn' => 'Sign In',
    'alreadyRegistered' => 'Already registered?',
    'weNeverShare' => 'We\'ll never share your email with anyone else.',
    'resetYourPassword' => 'Reset Your Password',
    'enterCodeEmailPassword' => 'Enter the code you received via email, your email address, and your new password.',
    'token' => 'Token',
    'newPassword' => 'New Password',
    'newPasswordRepeat' => 'Repeat New Password',
    'resetPassword' => 'Reset Password',
];
