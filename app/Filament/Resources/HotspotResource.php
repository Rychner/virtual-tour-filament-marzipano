<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HotspotResource\Pages;
use App\Models\Hotspot;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class HotspotResource extends Resource
{
    protected static ?string $model = Hotspot::class;

    protected static ?string $navigationIcon = 'heroicon-o-map-pin';
    protected static ?string $navigationGroup = 'Virtual Tour';
    protected static ?string $navigationLabel = 'Hotspot';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('panorama_id')
                ->relationship('panorama', 'name')
                ->searchable()
                ->required(),

            Forms\Components\TextInput::make('title')
                ->required(),

            Forms\Components\TextInput::make('yaw')
                ->numeric()
                ->required(),

            Forms\Components\TextInput::make('pitch')
                ->numeric()
                ->required(),

            Forms\Components\Select::make('target_panorama_id')
                ->label('Target Panorama')
                ->relationship(
                    name: 'target',
                    titleAttribute: 'name'
                )
                ->searchable()
                ->nullable(),
            
            Forms\Components\FileUpload::make('icon_path')
                ->label('Hotspot Icon')
                ->directory('hotspot-icons')
                ->image()
                ->nullable(),

            Forms\Components\Textarea::make('label')
                ->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->sortable(),

                Tables\Columns\TextColumn::make('panorama.name')
                    ->label('Panorama')
                    ->sortable()
                    ->searchable(),                

                Tables\Columns\TextColumn::make('yaw'),
                Tables\Columns\TextColumn::make('pitch'),

                Tables\Columns\TextColumn::make('target.name')
                    ->label('Target Panorama'),
                
                Tables\Columns\TextColumn::make('label')
                    ->label('Label'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListHotspots::route('/'),
            'create' => Pages\CreateHotspot::route('/create'),
            'edit' => Pages\EditHotspot::route('/{record}/edit'),
        ];
    }
}
