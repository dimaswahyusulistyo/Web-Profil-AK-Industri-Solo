<?php

namespace App\Filament\Pages\Auth;

use App\Models\PasswordResetOtp;
use App\Models\User;
use Carbon\Carbon;
use Filament\Actions\Action;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Filament\Notifications\Notification;
use Filament\Auth\Pages\PasswordReset\ResetPassword as BaseResetPassword;
use Filament\Auth\Http\Responses\Contracts\PasswordResetResponse;
use Illuminate\Support\Facades\Hash;

class ResetPassword extends BaseResetPassword
{
    public ?array $data = [];

    public function mount(?string $email = null, ?string $token = null): void
    {
        parent::mount($email, $token);

        // Get email from query parameter if available
        if ($email = request()->query('email')) {
            $this->data['email'] = $email;
        }
    }

    public function form(Schema $form): Schema
    {
        return $form
            ->schema([
                TextInput::make('email')
                    ->label('Email')
                    ->email()
                    ->required()
                    ->disabled()
                    ->dehydrated(),
                
                TextInput::make('otp')
                    ->label('Kode OTP')
                    ->required()
                    ->length(6)
                    ->numeric()
                    ->placeholder('Masukkan 6 digit kode OTP'),
                
                $this->getPasswordFormComponent(),
                $this->getPasswordConfirmationFormComponent(),
            ])
            ->statePath('data');
    }

    public function getResetPasswordFormAction(): Action
    {
        return Action::make('resetPassword')
            ->label('Reset Password')
            ->submit('resetPassword');
    }

    public function resetPassword(): ?PasswordResetResponse
    {
        $data = $this->form->getState();
        
        $user = User::where('email', $this->data['email'])->first();

        if (!$user) {
            Notification::make()
                ->title('Email tidak valid')
                ->danger()
                ->send();
            return null;
        }

        // Verify OTP
        $otpRecord = PasswordResetOtp::where('user_id', $user->id)
            ->where('otp', $data['otp'])
            ->where('is_used', false)
            ->where('expires_at', '>', Carbon::now())
            ->first();

        if (!$otpRecord) {
            Notification::make()
                ->title('Kode OTP tidak valid')
                ->body('Kode OTP salah atau sudah kadaluarsa.')
                ->danger()
                ->send();
            return null;
        }

        // Update password
        $user->update([
            'password' => Hash::make($data['password']),
        ]);

        // Mark OTP as used
        $otpRecord->markAsUsed();

        Notification::make()
            ->title('Password berhasil diubah')
            ->success()
            ->send();

        // Redirect to login
        $this->redirect(filament()->getLoginUrl());

        return null;
    }
}
