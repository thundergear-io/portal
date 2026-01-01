<?php

namespace App\Admin\Resources;

use App\Admin\Resources\QuoteResource\Pages\CreateQuote;
use App\Admin\Resources\QuoteResource\Pages\EditQuote;
use App\Admin\Resources\QuoteResource\Pages\ListQuotes;
use App\Enums\QuoteStatus;
use App\Models\Currency;
use App\Models\Quote;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Actions\ActionGroup;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class QuoteResource extends Resource
{
    protected static ?string $model = Quote::class;

    protected static string|\UnitEnum|null $navigationGroup = 'Administration';

    protected static string|\BackedEnum|null $navigationIcon = 'ri-article-line';

    protected static string|\BackedEnum|null $activeNavigationIcon = 'ri-article-fill';

    protected static ?string $recordTitleAttribute = 'title';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('status', QuoteStatus::Pending)->count() ?: null;
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(2)
                    ->schema([
                        Section::make('Project')
                            ->schema([
                                TextInput::make('title')
                                    ->label('Project Title')
                                    ->required()
                                    ->maxLength(255),
                                TextInput::make('client_name')
                                    ->label('Client Name')
                                    ->maxLength(255),
                                TextInput::make('client_email')
                                    ->label('Client Email')
                                    ->email()
                                    ->maxLength(255),
                                Textarea::make('brief')
                                    ->label('Project Brief')
                                    ->rows(4)
                                    ->columnSpanFull(),
                                Textarea::make('timeline')
                                    ->label('Timeline / Notes')
                                    ->rows(3)
                                    ->columnSpanFull(),
                            ])
                            ->columns(2)
                            ->columnSpan(2),
                        Section::make('Dates')
                            ->schema([
                                DatePicker::make('start_date')
                                    ->label('Start Date'),
                                DatePicker::make('end_date')
                                    ->label('End Date')
                                    ->afterOrEqual('start_date'),
                            ])
                            ->columns(2),
                        Section::make('Terms')
                            ->schema([
                                Repeater::make('terms')
                                    ->label('Project Terms')
                                    ->schema([
                                        Select::make('predefined_term_id')
                                            ->label('Predefined Term')
                                            ->options(\App\Models\PredefinedTerm::all()->pluck('title', 'id'))
                                            ->searchable()
                                            ->live()
                                            ->afterStateUpdated(function ($state, callable $set) {
                                                if ($state) {
                                                    $term = \App\Models\PredefinedTerm::find($state);
                                                    if ($term) {
                                                        $set('title', $term->title);
                                                        $set('content', $term->content);
                                                    }
                                                }
                                            }),
                                        TextInput::make('title')
                                            ->required()
                                            ->maxLength(255),
                                        RichEditor::make('content')
                                            ->label('Content')
                                            ->required(),
                                    ])
                                    ->columnSpanFull(),
                            ])
                            ->columnSpan(2),
                        Section::make('Cost Breakdown')
                            ->schema([
                                Select::make('currency')
                                    ->options(fn () => Currency::all()->mapWithKeys(fn ($currency) => [$currency->code => "{$currency->code} ({$currency->prefix})"])->toArray())
                                    ->default(fn () => Currency::first()->code ?? 'USD')
                                    ->required()
                                    ->live(),
                                Repeater::make('cost_items')
                                    ->label('Line Items')
                                    ->schema([
                                        TextInput::make('description')
                                            ->required()
                                            ->maxLength(255),
                                        TextInput::make('amount')
                                            ->required()
                                            ->numeric()
                                            ->prefix(fn (Get $get) => Currency::find($get('../../currency'))?->prefix ?? '$'),
                                    ])
                                    ->columns(2)
                                    ->columnSpanFull()
                                    ->reorderable()
                                    ->minItems(1)
                                    ->collapsed(false),
                            ])
                            ->columnSpan(2),
                        Section::make('Status')
                            ->schema([
                                Select::make('status')
                                    ->options(QuoteStatus::class)
                                    ->required()
                                    ->default(QuoteStatus::Pending)
                                    ->native(false),
                                TextInput::make('public_url')
                                    ->label('Public URL')
                                    ->disabled()
                                    ->dehydrated(false)
                                    ->hint('Save to generate the public link')
                                    ->formatStateUsing(fn ($state, ?Quote $record) => $record?->public_url),
                            ])
                            ->columns(2),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('client_name')
                    ->label('Client')
                    ->searchable(),
                TextColumn::make('status')
                    ->badge()
                    ->colors([
                        'warning' => QuoteStatus::Pending->value,
                        'info' => QuoteStatus::Approved->value,
                        'success' => QuoteStatus::Completed->value,
                        'danger' => QuoteStatus::Declined->value,
                    ]),
                TextColumn::make('start_date')
                    ->date()
                    ->label('Start'),
                TextColumn::make('end_date')
                    ->date()
                    ->label('End'),
                TextColumn::make('formatted_total')
                    ->label('Total')
                    ->formatStateUsing(function ($state, Quote $record): string {
                        $symbol = $record->currencyModel?->prefix ?? '$';
                        return $symbol . $record->formatted_total;
                    }),
                TextColumn::make('public_id')
                    ->label('Public ID')
                    ->copyable(),
            ])
            ->filters([
                SelectFilter::make('status')->options(QuoteStatus::class),
            ])
            ->actions([
                ActionGroup::make([
                    EditAction::make(),
                    DeleteAction::make(),
                ]),
            ])
            ->bulkActions([
                //
            ])
            ->modifyQueryUsing(fn (Builder $query) => $query->latest());
    }

    public static function getPages(): array
    {
        return [
            'index' => ListQuotes::route('/'),
            'create' => CreateQuote::route('/create'),
            'edit' => EditQuote::route('/{record}/edit'),
        ];
    }
}
