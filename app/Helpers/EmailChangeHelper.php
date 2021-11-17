<?php

namespace App\Helpers;

use App\Models\EmailChangeVerification;
use App\Models\User;
use App\Notifications\EmailChangeVerification as NotificationsEmailChangeVerification;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Str;

class EmailChangeHelper {

    /**
     * Create token verification
     *
     * @param User $user User who changed email
     * @param string $new_email New email to apply
     * @param int $expiredInMinutes Expire token in minutes
     * @return void
     **/
    public static function create(User $user, $new_email, $expiredInMinutes = 60)
    {
        $emailChange = EmailChangeVerification::create([
            'user_id' => $user->id,
            'token' => Str::random(50),
            'old_email' => $user->email,
            'new_email' => $new_email,
            'expired_at' => now()->addMinutes($expiredInMinutes)
        ]);

        static::sendEmail($user, $emailChange);
    }

    /**
     * Send verification email when current email is change
     *
     * @param User $user User notifiable
     * @param EmailChangeVerification $emailChange EmailChangeVerification model
     * @return void
     **/
    public static function sendEmail(User $user, EmailChangeVerification $emailChange)
    {
        $user->notify(
            new NotificationsEmailChangeVerification(
                $emailChange
            )
        );
    }

    /**
     * Resend verification email when current email is change
     *
     * @param User $user User notifiable
     **/
    public static function resendEmail(User $user)
    {
        $emailChange = $user->emailChangeTokens()->active()->first();
        if (!empty($emailChange)) {
            static::sendEmail($user, $emailChange);
        }
    }

    /**
     * Validate email change token
     *
     * @param string $token
     * @return bool
     **/
    public static function validateToken($token)
    {
        $emailChange = EmailChangeVerification::where('token', $token)
                                              ->active()
                                              ->latest()
                                              ->first();
        if (empty($emailChange)) {
            abort(403, 'The token is invalid');
        }

        $user = $emailChange->user;
        $merchant = $user->merchant;

        $emailChange->update([
            'verified_at' => now()
        ]);

        $user->update([
            'email' => $emailChange->new_email,
            'email_verified_at' => now()
        ]);

        $merchant->update([
            'Email' => $emailChange->new_email
        ]);

        return redirect()->route('dashboard.index')
                         ->with(
                             'status',
                             "email address $emailChange->new_email successfully applied as new email"
                        );
    }
}
