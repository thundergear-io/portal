<?php

namespace App\Admin\Resources\QuoteResource\Pages;

use App\Admin\Resources\QuoteResource;
use Filament\Resources\Pages\EditRecord;

class EditQuote extends EditRecord
{
    protected static string $resource = QuoteResource::class;
}
