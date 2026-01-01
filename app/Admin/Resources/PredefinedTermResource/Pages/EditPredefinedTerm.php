<?php

namespace App\Admin\Resources\PredefinedTermResource\Pages;

use App\Admin\Resources\PredefinedTermResource;
use Filament\Resources\Pages\EditRecord;

class EditPredefinedTerm extends EditRecord
{
    protected static string $resource = PredefinedTermResource::class;

    protected function getHeaderActions(): array
    {
        return [
            \Filament\Actions\DeleteAction::make(),
        ];
    }
}
