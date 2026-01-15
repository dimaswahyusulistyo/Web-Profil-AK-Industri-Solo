<?php

namespace App\Filament\Pages\Auth;

use App\Models\PasswordResetOtp;
use App\Models\User;
use App\Notifications\PasswordResetOtpNotification;
use Carbon\Carbon;
use Filament\Actions\Action;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Filament\Notifications\Notification;
use Filament\Auth\Pages\PasswordReset\RequestPasswordReset;
use Illuminate\Support\Facades\URL;
use Illuminate\Contracts\Support\Htmlable;

class ForgotPassword extends RequestPasswordReset
{
    public ?array $data = [];

    public function form(Schema $form): Schema
    {
        return $form
            ->schema([
                $this->getEmailFormComponent(),
            ])
            ->statePath('data');
    }

    protected function getRequestFormAction(): Action
    {
        return Action::make('request')
            ->label('Kirim Kode OTP')
            ->submit('request');
    }

    public function request(): void
    {
        $data = $this->form->getState();
        $email = $data['email'];

        $user = User::where('email', $email)->first();

        if (!$user) {
            Notification::make()
                ->title('Email tidak terdaftar')
                ->danger()
                ->send();
            return;
        }

        // Invalidate previous OTPs
        PasswordResetOtp::where('user_id', $user->id)
            ->where('is_used', false)
            ->update(['is_used' => true]);

        // Generate new OTP
        $otp = PasswordResetOtp::generateOtp();
        $expiresAt = Carbon::now()->addMinutes(5);

        PasswordResetOtp::create([
            'user_id' => $user->id,
            'otp' => $otp,
            'expires_at' => $expiresAt,
        ]);

        // Send notification
        $user->notify(new PasswordResetOtpNotification($otp, 5));

        Notification::make()
            ->title('Kode OTP telah dikirim')
            ->body('Silakan cek email Anda untuk mendapatkan kode OTP.')
            ->success()
            ->send();

        // Redirect to Reset Password page with email as query param and signed URL
        $this->redirect(URL::signedRoute('filament.admin.auth.password-reset.reset', [
            'email' => $email,
            'token' => 'otp-flow',
        ]));
    }

    public function getHeading(): string | Htmlable
    {
        return 'Lupa Password';
    }

    public function getSubheading(): string | Htmlable | null
    {
        return 'Masukkan email Anda untuk menerima kode OTP.';
    }
}
