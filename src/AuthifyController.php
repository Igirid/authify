<?php

namespace Igirid\Authify;

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


class AuthifyController
{
    /**
     * Authenticated session Controller.
     *
     * @return string
     */
    public function authenticatedSession($method)
    {
        return [AuthenticatedSessionController::class, $method];
    }

    public function confirmablePassword($method)
    {
        return ConfirmablePasswordController::class;
    }

    /**
     * Authentication Controller.
     *
     * @return string
     */
    public function confirmedPasswordStatus($method)
    {
        return ConfirmedPasswordStatusController::class;
    }

    /**
     * Authentication Controller.
     *
     * @return string
     */
    public function emailVerificationNotification()
    {
        return EmailVerificationNotificationController::class;
    }

    /**
     * Authentication Controller.
     *
     * @return string
     */
    public function EmailVerificationPrompt()
    {
        return EmailVerificationPromptController::class;
    }

    /**
     * Authentication Controller.
     *
     * @return string
     */
    public function newPassword()
    {
        return NewPasswordController::class;
    }

    /**
     * Authentication Controller.
     *
     * @return string
     */
    public function password()
    {
        return PasswordController::class;
    }

        /**
     * Authentication Controller.
     *
     * @return string
     */
    public function passwordResetLink()
    {
        return PasswordResetLinkController::class;
    }    
    
    /**
    * Authentication Controller.
    *
    * @return string
    */
   public function profileInformation()
   {
       return ProfileInformationController::class;
   }   
   
   /**
   * Authentication Controller.
   *
   * @return string
   */
  public function recoveryCode()
  {
      return RecoveryCodeController::class;
  }

      /**
     * Authentication Controller.
     *
     * @return string
     */
    public function registeredUser()
    {
        return RegisteredUserController::class;
    }

        /**
     * Authentication Controller.
     *
     * @return string
     */
    public function twoFactorAuthenticatedSession()
    {
        return TwoFactorAuthenticatedSessionController::class;
    }

    /**
     * Authentication Controller.
     *
     * @return string
     */
    public function twoFactorAuthentication()
    {
        return TwoFactorAuthenticationController::class;
    }

    /**
     * Authentication Controller.
     *
     * @return string
     */
    public function twoFactorQrCode()
    {
        return TwoFactorQrCodeController::class;
    }

    /**
     * Authentication Controller.
     *
     * @return string
     */
    public function verifyEmail()
    {
        return VerifyEmailController::class;
    }
}
