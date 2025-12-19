<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RoomResource\Pages;
use App\Filament\Resources\RoomResource\RelationManagers;
use App\Models\Room;
use App\Models\Panorama;
use App\Models\Hotspot;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class RoomResource extends Resource
{
    protected static ?string $model = Room::class;

    protected static ?string $navigationIcon = 'heroicon-o-flag';
    protected static ?string $navigationGroup = 'Virtual Tour';
    protected static ?string $navigationLabel = 'Room Map';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Nama Ruangan')
                    ->required()
                    ->maxLength(255)
                    ->live()
                    ->afterStateUpdated(fn ($state, callable $set) => $set('slug', Str::slug($state))),

                Forms\Components\TextInput::make('slug')
                    ->required()
                    ->unique(ignoreRecord: true),

                Forms\Components\Select::make('category')
                    ->label('Kategori Ruangan')
                    ->options([
                        'dosen'         => 'Dosen',
                        'rapat'         => 'Rapat',
                        'kelas'         => 'Kelas',
                        'kantin'        => 'Kantin',
                        'open-space'    => 'Open Space',
                        'auditorium'    => 'Auditorium'
                    ])
                    ->required(),

                Forms\Components\Select::make('panorama_id')
                    ->label('Panorama Tujuan')
                    ->options(
                        Panorama::query()->pluck('name', 'id')
                    )
                    ->searchable()
                    ->required(),

                Forms\Components\Select::make('hotspot_id')
                    ->label('Hotspot Label')
                    ->options(
                        Hotspot::query()->pluck('label', 'id')
                    )
                    ->searchable()
                    ->required(),

                
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),

                Tables\Columns\TextColumn::make('category')
                    ->badge(),

                Tables\Columns\TextColumn::make('panorama.name')
                    ->label('Panorama Target'),

                Tables\Columns\TextColumn::make('hotspot.label')
                    ->label('Hotspot Label'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
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
            'index' => Pages\ListRooms::route('/'),
            'create' => Pages\CreateRoom::route('/create'),
            'edit' => Pages\EditRoom::route('/{record}/edit'),
        ];
    }
}
