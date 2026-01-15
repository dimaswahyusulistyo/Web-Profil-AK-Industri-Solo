<?php

namespace App\Filament\Resources\Roles\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;

class RoleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->schema([
            TextInput::make('nama_role')
                ->label('Nama Role')
                ->required()
                ->maxLength(100),
            
            \Filament\Forms\Components\CheckboxList::make('permissions')
                ->label('Izin Akses Menu')
                ->options(function() {
                    $options = [
                        'resource.Berita' => 'Berita',
                        'resource.Pengumuman' => 'Pengumuman',
                        'resource.Layanan' => 'Layanan',
                        'resource.Mitra' => 'Mitra',
                        'resource.Berita.KategoriBerita' => 'Kategori Berita',
                        'resource.Komentar' => 'Komentar',
                        'resource.KontenBiasa' => 'Konten Biasa',
                        'resource.Menu' => 'Menu',
                        'resource.Slider' => 'Slider',
                        'resource.IdentitasWebsite' => 'Global Settings',
                        'resource.Role' => 'Role',
                        'resource.User' => 'User',
                        'resource.Form' => 'Form Builder',
                        'resource.FormSubmission' => 'Hasil Submission (General)',
                    ];

                    // Add dynamic forms
                    $forms = \App\Models\Form::where('is_active', true)->get();
                    foreach ($forms as $form) {
                        $options["form.{$form->id}"] = "Submission: {$form->name}";
                    }

                    return $options;
                })
                ->columns(2)
                ->gridDirection('vertical')
                ->bulkToggleable()
                ->disabled(fn ($record) => $record?->nama_role === 'Admin')
                ->dehydrated(fn ($record) => $record?->nama_role !== 'Admin'),
        ]);
    }
}
