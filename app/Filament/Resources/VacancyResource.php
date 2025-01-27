<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VacancyResource\Pages;
use App\Filament\Resources\VacancyResource\RelationManagers;
use App\Models\Vacancy;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class VacancyResource extends Resource
{
    protected static ?string $modelLabel = 'Lowongan Pekerjaan';

    protected static ?string $model = Vacancy::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('reference')
                ->label('Referensi')
                ->disabled() 
                ->required() 
                ->unique(ignoreRecord: true), 
                
                Forms\Components\TextInput::make('title')
                    ->label('Judul')
                    ->unique(ignoreRecord: true)
                    ->validationMessages([
                        'unique' => 'Judul sudah digunakan.',
                    ])
                    ->live(onBlur: true)
                    ->afterStateUpdated(function (Set $set, ?string $state){
                        $slug = Str::slug($state);

                        // Check if the slug is unique
                        $count = Vacancy::where('slug', $slug)->count();
                        if ($count > 0) {
                            $slug = $slug . '-' . ($count + 1);
                        }

                        $set('slug', $slug);
                    })
                    ->required(),
                Forms\Components\TextInput::make('slug')
                    ->label('Slug')
                    ->unique(ignoreRecord: true)
                    ->validationMessages([
                        'unique' => 'Slug sudah digunakan.',
                    ])
                    ->readOnly()
                    ->required(),
                Forms\Components\RichEditor::make('description')
                    ->label('Deskripsi'),
                Forms\Components\Select::make('status')
                    ->label('Status')
                    ->default('closed')
                    ->options([
                        'open' => 'Buka',
                        'closed' => 'Tutup',
                    ])
                    ->required(),
                Forms\Components\DateTimePicker::make('date_start')
                    ->label('Tanggal Mulai')
                    ->default(now()->addWeek())
                    ->required(),
                Forms\Components\DateTimePicker::make('date_end')
                    ->default(now()->addWeeks(2))
                    ->label('Tanggal Selesai')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('reference')
                    ->label('Referensi')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('slug')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('date_start')->date()
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('date_end')->date()
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'open' => 'Buka',
                        'closed' => 'Tutup',
                        'pending' => 'Tertunda',
                    ]),
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
            'index' => Pages\ListVacancies::route('/'),
            'create' => Pages\CreateVacancy::route('/create'),
            'edit' => Pages\EditVacancy::route('/{record}/edit'),
        ];
    }
}
