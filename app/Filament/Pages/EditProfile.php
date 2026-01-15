<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Notifications\Notification;
use App\Models\PasswordResetOtp;
use App\Notifications\PasswordResetOtpNotification;
use Illuminate\Support\Facades\Hash;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Carbon\Carbon;

class EditProfile extends Page implements HasForms
{
    use InteractsWithForms;
    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-user-circle';
    protected string $view = 'filament.pages.edit-profile';
    protected static ?string $navigationLabel = 'Profil Saya';
    protected static ?string $title = 'Profil Saya';
    protected static ?int $navigationSort = 100;

    public ?array $data = [];
    
    public function mount(): void
    {
        $this->form->fill([
            'name' => auth()->user()->name,
            'email' => auth()->user()->email,
        ]);
    }

    public function form(Schema $form): Schema
    {
        return $form
            ->schema([
                \Filament\Schemas\Components\Section::make('Informasi Profil')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Nama')
                            ->required()
                            ->maxLength(255),
                        
                        Forms\Components\TextInput::make('email')
                            ->label('Email')
                            ->email()
                            ->disabled()
                            ->dehydrated(false),
                    ])
                    ->columns(2),

                \Filament\Schemas\Components\Actions::make([
                    \Filament\Actions\Action::make('save')
                        ->label('Simpan Perubahan')
                        ->submit('save')
                        ->color('primary'),
                    
                    \Filament\Actions\Action::make('changePassword')
                        ->label('Ganti Password')
                        ->color('warning')
                        ->icon('heroicon-o-key')
                        ->form([
                            \Filament\Forms\Components\Placeholder::make('info')
                                ->content('Kode OTP akan dikirim ke email Anda: ' . auth()->user()->email)
                                ->columnSpanFull(),
                            
                            \Filament\Schemas\Components\Actions::make([
                                \Filament\Actions\Action::make('sendOtp')
                                    ->label('Kirim Kode OTP')
                                    ->action(fn () => $this->sendOtp())
                                    ->color('primary'),
                            ]),
                            
                            Forms\Components\TextInput::make('otp')
                                ->label('Kode OTP')
                                ->required()
                                ->length(6)
                                ->numeric()
                                ->placeholder('Masukkan 6 digit kode OTP'),
                            
                            Forms\Components\TextInput::make('new_password')
                                ->label('Password Baru')
                                ->password()
                                ->required()
                                ->minLength(8)
                                ->same('new_password_confirmation'),
                            
                            Forms\Components\TextInput::make('new_password_confirmation')
                                ->label('Konfirmasi Password Baru')
                                ->password()
                                ->required()
                                ->minLength(8),
                        ])
                        ->action(fn (array $data) => $this->changePassword($data)),
                ]),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $data = $this->form->getState();
        
        auth()->user()->update([
            'name' => $data['name'],
        ]);

        Notification::make()
            ->title('Profil berhasil diperbarui')
            ->success()
            ->send();
    }

    protected function sendOtp(): void
    {
        $user = auth()->user();
        
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
        
        // Send email
        $user->notify(new PasswordResetOtpNotification($otp, 5));
        
        Notification::make()
            ->title('Kode OTP telah dikirim')
            ->body('Silakan cek email Anda untuk mendapatkan kode OTP.')
            ->success()
            ->send();
    }

    protected function changePassword(array $data): void
    {
        $user = auth()->user();
        
        // Find valid OTP
        $otpRecord = PasswordResetOtp::where('user_id', $user->id)
            ->where('otp', $data['otp'])
            ->where('is_used', false)
            ->where('expires_at', '>', Carbon::now())
            ->first();
        
        if (!$otpRecord) {
            Notification::make()
                ->title('Kode OTP tidak valid')
                ->body('Kode OTP salah atau sudah kadaluarsa. Silakan kirim ulang kode OTP.')
                ->danger()
                ->send();
            return;
        }
        
        // Update password
        $user->update([
            'password' => Hash::make($data['new_password']),
        ]);
        
        // Mark OTP as used
        $otpRecord->markAsUsed();
        
        Notification::make()
            ->title('Password berhasil diubah')
            ->body('Password Anda telah berhasil diperbarui.')
            ->success()
            ->send();
    }
}
