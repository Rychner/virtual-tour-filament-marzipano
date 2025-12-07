<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PanoramaResource\Pages;
use App\Models\Panorama;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class PanoramaResource extends Resource
{
    protected static ?string $model = Panorama::class;

    protected static ?string $navigationIcon = 'heroicon-o-photo';
    protected static ?string $navigationGroup = 'Virtual Tour';
    protected static ?string $navigationLabel = 'Panorama';

    public static function form(Form $form): Form
    {
        return $form->schema([

            Forms\Components\TextInput::make('name')
                ->label('Nama Panorama')
                ->required()
                ->maxLength(255)
                ->live()
                ->afterStateUpdated(fn ($state, callable $set) => $set('slug', Str::slug($state))),

            Forms\Components\TextInput::make('slug')
                ->required()
                ->unique(ignoreRecord: true),

            Forms\Components\FileUpload::make('image_path')
                ->label('Panorama Image (2:1)')
                ->image()
                ->required()
                ->directory('panoramas'),

            Forms\Components\Textarea::make('description')
                ->columnSpanFull(),

            Forms\Components\Section::make('Initial View')
                ->schema([
                    Forms\Components\TextInput::make('initial_yaw')
                        ->numeric()
                        ->default(0),

                    Forms\Components\TextInput::make('initial_pitch')
                        ->numeric()
                        ->default(0),

                    Forms\Components\TextInput::make('initial_fov')
                        ->numeric()
                        ->default(90),
                ])
                ->columns(3),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image_path')
                    ->disk('public')
                    ->label('Image')
                    ->circular(),

                Tables\Columns\TextColumn::make('name')
                    ->searchable(),

                Tables\Columns\TextColumn::make('slug'),

                Tables\Columns\TextColumn::make('created_at')
                    ->date(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
            // Jika ingin nanti membuat HotspotRelationManager:
            // HotspotsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListPanoramas::route('/'),
            'create' => Pages\CreatePanorama::route('/create'),
            'edit'   => Pages\EditPanorama::route('/{record}/edit'),
        ];
    }
}
