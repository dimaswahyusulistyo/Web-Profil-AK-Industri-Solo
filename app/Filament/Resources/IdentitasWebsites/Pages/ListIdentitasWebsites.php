<?php

namespace App\Filament\Resources\IdentitasWebsites\Pages;

use App\Filament\Resources\IdentitasWebsites\IdentitasWebsiteResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListIdentitasWebsites extends ListRecords
{
    protected static string $resource = IdentitasWebsiteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function mount(): void
    {
        parent::mount();

        $record = $this->getResource()::getModel()::first();

        if ($record) {
            $this->redirect($this->getResource()::getUrl('edit', ['record' => $record]));
        } else {
            $this->redirect($this->getResource()::getUrl('create'));
        }
    }
}
