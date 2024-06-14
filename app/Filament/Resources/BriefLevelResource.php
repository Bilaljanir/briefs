<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BriefLevelResource\Pages;
use App\Filament\Resources\BriefLevelResource\RelationManagers;
use App\Models\BriefLevel;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class BriefLevelResource extends Resource
{
    protected static ?string $model = BriefLevel::class;

    protected static ?string $navigationIcon = 'heroicon-o-presentation-chart-line';
    protected static ?string $navigationGroup ='Mandats';

    protected static ?string $pluralLabel = 'Mandats Niveau';



    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('number')
                    ->numeric()
                    ->required()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('number')->sortable()->searchable()
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListBriefLevels::route('/'),
            'create' => Pages\CreateBriefLevel::route('/create'),
            'edit' => Pages\EditBriefLevel::route('/{record}/edit'),
        ];
    }
}
