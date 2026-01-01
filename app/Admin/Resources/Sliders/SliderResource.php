<?php

namespace App\Admin\Resources\Sliders;

use App\Admin\Resources\Sliders\Pages\CreateSlider;
use App\Admin\Resources\Sliders\Pages\EditSlider;
use App\Admin\Resources\Sliders\Pages\ListSliders;
use App\Admin\Resources\Sliders\Schemas\SliderForm;
use App\Admin\Resources\Sliders\Tables\SlidersTable;
use App\Models\Slider;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class SliderResource extends Resource
{
    protected static ?string $model = Slider::class;

    protected static string|BackedEnum|null $navigationIcon = 'ri-image-line';

    protected static string|BackedEnum|null $activeNavigationIcon = 'ri-image-fill';

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Schema $schema): Schema
    {
        return SliderForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SlidersTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListSliders::route('/'),
            'create' => CreateSlider::route('/create'),
            'edit' => EditSlider::route('/{record}/edit'),
        ];
    }
}
