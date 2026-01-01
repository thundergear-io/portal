<?php

namespace App\Admin\Resources\Sliders\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;

class SliderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('Sliders')
                    ->persistTabInQueryString()
                    ->tabs([
                        Tab::make('General')
                            ->schema([
                                TextInput::make('title')
                                    ->label('Title')
                                    ->maxLength(255),
                                TextInput::make('link')
                                    ->label('Link (Optional)')
                                    ->url()
                                    ->maxLength(255),
                                Toggle::make('active')
                                    ->label('Active')
                                    ->default(true),
                            ]),
                        Tab::make('Images')
                            ->schema([
                                FileUpload::make('image')
                                    ->label('Slider Image')
                                    ->required()
                                    ->image()
                                    ->disk('public')
                                    ->directory('sliders')
                                    ->maxSize(5120),
                            ]),
                        Tab::make('Description')
                            ->schema([
                                RichEditor::make('description')
                                    ->label('Description')
                                    ->columnSpanFull(),
                            ]),
                    ]),
            ]);
    }
}
