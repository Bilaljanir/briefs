<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BriefResource\Pages;
use App\Models\Brief;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class xBriefResource extends Resource
{
    protected static ?string $model = Brief::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-duplicate';
    protected static ?string $navigationGroup = 'Mandats';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(250),
                Forms\Components\Select::make('brief_branch_id')
                    ->relationship('briefBranch', 'name')
                    ->required()
                    ->preload()
                    ->searchable()
                    ->createOptionForm([
                        Forms\Components\TextInput::make('name')->required()->maxLength(20),
                        Forms\Components\Textarea::make('description')->rows(4)->required()
                    ]),
                Forms\Components\Select::make('brief_level_id')
                    ->relationship('briefLevel', 'number')
                    ->required()
                    ->preload()
                    ->searchable(),
                Forms\Components\Select::make('year')
                    ->options(['1' => 'Year 1', '2' => 'Year 2', '3' => 'Year 3'])
                    ->required(),
                Forms\Components\FileUpload::make('attachment')
                    ->directory('form-attachments')
                    ->required()->openable()
                    ->reactive(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('briefBranch.name')->sortable()->label('Branche'),
                Tables\Columns\TextColumn::make('year')->sortable()->label('Année'),
                Tables\Columns\TextColumn::make('briefLevel.number')->sortable()->label('Niveau'),
                Tables\Columns\IconColumn::make('attachment')
                    ->label('PDF')
                    ->trueIcon('heroicon-o-document')
                    ->url(fn ($record) => asset('storage/' . $record->attachment), shouldOpenInNewTab: true)
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('briefBranch')
                    ->relationship('briefBranch', 'name')->preload()
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
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBriefs::route('/'),
            'create' => Pages\CreateBrief::route('/create'),
            'edit' => Pages\EditBrief::route('/{record}/edit'),
        ];
    }
}
