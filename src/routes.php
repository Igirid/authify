<?php

use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;
use Laravel\Fortify\Http\Controllers\ConfirmablePasswordController;
use Laravel\Fortify\Http\Controllers\ConfirmedPasswordStatusController;
use Laravel\Fortify\Http\Controllers\EmailVerificationNotificationController;
use Laravel\Fortify\Http\Controllers\EmailVerificationPromptController;
use Laravel\Fortify\Http\Controllers\NewPasswordController;
use Laravel\Fortify\Http\Controllers\PasswordController;
use Laravel\Fortify\Http\Controllers\PasswordResetLinkController;
use Laravel\Fortify\Http\Controllers\ProfileInformationController;
use Laravel\Fortify\Http\Controllers\RecoveryCodeController;
use Laravel\Fortify\Http\Controllers\RegisteredUserController;
use Laravel\Fortify\Http\Controllers\TwoFactorAuthenticatedSessionController;
use Laravel\Fortify\Http\Controllers\TwoFactorAuthenticationController;
use Laravel\Fortify\Http\Controllers\TwoFactorQrCodeController;
use Laravel\Fortify\Http\Controllers\VerifyEmailController;

Route::middleware(config('fortify.middleware', ['web']))->group(function () {
    $enableViews = config('fortify.views', true);

    Route::prefix('user')->group(function () use($enableViews) {
        // Profile Information...
        if (Features::enabled(Features::updateProfileInformation())) {
            Route::put('/profile-information', /*[ProfileInformationController::class, 'update']*/ fortify('profile-information', 'update'))
                ->middleware(['auth:' . config('fortify.guard')])
                ->name('user-profile-information.update');
        }

        // Passwords...
        if (Features::enabled(Features::updatePasswords())) {
            Route::put('/password', /*[PasswordController::class, 'update']*/ fortify('password', 'update'))
                ->middleware(['auth:' . config('fortify.guard')])
                ->name('user-password.update');
        }

        // Password Confirmation...
        if ($enableViews) {
            Route::get('/confirm-password', /*[ConfirmablePasswordController::class, 'show']*/ fortify('confirmable-passwod', 'show'))
                ->middleware(['auth:' . config('fortify.guard')])
                ->name('password.confirm');
        }

        Route::get('/confirmed-password-status', /*[ConfirmedPasswordStatusController::class, 'show']*/ fortify('confirmed-password-status', 'show'))
            ->middleware(['auth:' . config('fortify.guard')])
            ->name('password.confirmation');

        Route::post('/confirm-password', /*[ConfirmablePasswordController::class, 'store']*/ fortify('confirmable-password', 'store'))
            ->middleware(['auth:' . config('fortify.guard')]);


        $twoFactorMiddleware = Features::optionEnabled(Features::twoFactorAuthentication(), 'confirmPassword')
            ? ['auth:' . config('fortify.guard'), 'password.confirm']
            : ['auth:' . config('fortify.guard')];

        Route::middleware($twoFactorMiddleware)->group(function () {
            Route::post('/two-factor-authentication', /*[TwoFactorAuthenticationController::class, 'store']*/ fortify('two-factor-authentication', 'store'))
                ->name('two-factor.enable');

            Route::delete('/two-factor-authentication', /*[TwoFactorAuthenticationController::class, 'destroy']*/ fortify('two-factor-authentication', 'destroy'))
                ->name('two-factor.disable');

            Route::get('/two-factor-qr-code', /*[TwoFactorQrCodeController::class, 'show']*/ fortify('two-factor-qr-code', 'show'))
                ->name('two-factor.qr-code');

            Route::get('/two-factor-recovery-codes', /*[RecoveryCodeController::class, 'index']*/ fortify('recovery-code', 'index'))
                ->name('two-factor.recovery-codes');

            Route::post('/two-factor-recovery-codes', /*[RecoveryCodeController::class, 'store']*/ fortify('recovery-code', 'store'));
        });
    });

    // Authentication...
    if ($enableViews) {
        Route::get('/login', /*[AuthenticatedSessionController::class, 'create']*/ fortify('authenticated-session', 'create'))
            ->middleware(['guest:' . config('fortify.guard')])
            ->name('login');
    }

    $limiter = config('fortify.limiters.login');
    $twoFactorLimiter = config('fortify.limiters.two-factor');
    $verificationLimiter = config('fortify.limiters.verification', '6,1');

    Route::post('/login', /*[AuthenticatedSessionController::class, 'store']*/ fortify('authenticated-session', 'store'))
        ->middleware(array_filter([
            'guest:' . config('fortify.guard'),
            $limiter ? 'throttle:' . $limiter : null,
        ]));

    Route::post('/logout', /*[AuthenticatedSessionController::class, 'destroy']*/ fortify('authenticated-session', 'destroy'))
        ->name('logout');

    // Password Reset...
    if (Features::enabled(Features::resetPasswords())) {
        if ($enableViews) {
            Route::get('/forgot-password', /*[PasswordResetLinkController::class, 'create']*/ fortify('password-reset-link', 'create'))
                ->middleware(['guest:' . config('fortify.guard')])
                ->name('password.request');

            Route::get('/reset-password/{token}', /*[NewPasswordController::class, 'create']*/ fortify('new-password', 'create'))
                ->middleware(['guest:' . config('fortify.guard')])
                ->name('password.reset');
        }

        Route::post('/forgot-password', /*[PasswordResetLinkController::class, 'store']*/ fortify('password-reset-link', 'store'))
            ->middleware(['guest:' . config('fortify.guard')])
            ->name('password.email');

        Route::post('/reset-password', /*[NewPasswordController::class, 'store']*/ fortify('new-password', 'store'))
            ->middleware(['guest:' . config('fortify.guard')])
            ->name('password.update');
    }

    // Registration...
    if (Features::enabled(Features::registration())) {
        if ($enableViews) {
            Route::get('/register', /*[RegisteredUserController::class, 'create']*/ fortify('registerd-user', 'create'))
                ->middleware(['guest:' . config('fortify.guard')])
                ->name('register');
        }

        Route::post('/register', /*[RegisteredUserController::class, 'store']*/ fortify('registered-user', 'store'))
            ->middleware(['guest:' . config('fortify.guard')]);
    }

    // Email Verification...
    if (Features::enabled(Features::emailVerification())) {
        if ($enableViews) {
            Route::get('/email/verify', /*[EmailVerificationPromptController::class, '__invoke']*/ fortify('email-verification-prompt', '__invoke'))
                ->middleware(['auth:' . config('fortify.guard')])
                ->name('verification.notice');
        }

        Route::get('/email/verify/{id}/{hash}', /*[VerifyEmailController::class, '__invoke']*/ fortify('verify-email', '__invoke'))
            ->middleware(['auth:' . config('fortify.guard'), 'signed', 'throttle:' . $verificationLimiter])
            ->name('verification.verify');

        Route::post('/email/verification-notification', /*[EmailVerificationNotificationController::class, 'store']*/ fortify('email-verification-notification', 'store'))
            ->middleware(['auth:' . config('fortify.guard'), 'throttle:' . $verificationLimiter])
            ->name('verification.send');
    }


    // Two Factor Authentication...
    if (Features::enabled(Features::twoFactorAuthentication())) {
        
        if ($enableViews) {
            Route::get('/two-factor-challenge', /*[TwoFactorAuthenticatedSessionController::class, 'create']*/ fortify('two-factor-authenticated-session', 'create'))
                ->middleware(['guest:' . config('fortify.guard')])
                ->name('two-factor.login');
        }

        Route::post('/two-factor-challenge', /*[TwoFactorAuthenticatedSessionController::class, 'store']*/ fortify('two-factor-authenticated-session', 'store'))
            ->middleware(array_filter([
                'guest:' . config('fortify.guard'),
                $twoFactorLimiter ? 'throttle:' . $twoFactorLimiter : null,
            ]));
    }
});
