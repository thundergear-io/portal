<?php

namespace App\Admin\Resources\PredefinedTermResource\Pages;

use App\Admin\Resources\PredefinedTermResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPredefinedTerms extends ListRecords
{
    protected static string $resource = PredefinedTermResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
