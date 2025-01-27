<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CriterionResource\Pages;
use App\Filament\Resources\CriterionResource\RelationManagers;
use App\Models\Criterion;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CriterionResource extends Resource
{
    protected static ?string $model = Criterion::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
{
    return $form
        ->schema([
            Forms\Components\Select::make('vacancy_id')
                ->label('Lowongan Pekerjaan')
                ->relationship('vacancy', 'title')
                ->required(),

            Forms\Components\TextInput::make('name')
                ->label('Nama Kriteria')
                ->required(),

            Forms\Components\Repeater::make('categorical')
                ->label('Kategorikal')
                ->schema([
                    Forms\Components\TextInput::make('name')
                        ->label('Nama Kategori')
                        ->required(),
                        Forms\Components\TextInput::make('category_value')
                        ->label('Nilai')
                        ->required(),
                ])
                ->createItemButtonLabel('Tambah Kategori')
                ->required(),

            Forms\Components\TextInput::make('numerical')
                ->label('Numerikal')
                ->numeric()
                ->step(0.01)
                ->nullable(),
        ]);
}


public static function table(Table $table): Table
{
    return $table
        ->columns([
            Tables\Columns\TextColumn::make('vacancy.title')
                ->label('Lowongan Pekerjaan')
                ->sortable()
                ->searchable(),

            Tables\Columns\TextColumn::make('name')
                ->label('Nama Kriteria')
                ->sortable()
                ->searchable(),

            Tables\Columns\TextColumn::make('numerical')
                ->label('Numerikal')
                ->sortable(),
        ])
        ->filters([])
        ->filters([
            Tables\Filters\Filter::make('vacancy')
                ->label('Lowongan Pekerjaan')
                ->query(fn (Builder $query): Builder => $query->whereHas('vacancy')),
        ])
        ->actions([
            Tables\Actions\EditAction::make(),
        ])
        ->bulkActions([
            Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListCriteria::route('/'),
            'create' => Pages\CreateCriterion::route('/create'),
            'edit' => Pages\EditCriterion::route('/{record}/edit'),
        ];
    }
}
