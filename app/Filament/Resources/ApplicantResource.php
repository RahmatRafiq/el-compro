<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ApplicantResource\Pages;
use App\Filament\Resources\ApplicantResource\RelationManagers;
use App\Models\Applicant;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ApplicantResource extends Resource
{
    protected static ?string $model = Applicant::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('reference')
                ->label('Referensi')
                ->disabled() 
                ->unique(ignoreRecord: true), 

                Forms\Components\Select::make('user_id')
                    ->label('Pengguna')
                    ->relationship('user', 'name') 
                    ->searchable()
                    ->required(),

                Forms\Components\TextInput::make('experience')
                    ->label('Pengalaman (Tahun)')
                    ->numeric()
                    ->required(),

                Forms\Components\Textarea::make('education')
                    ->label('Riwayat Pendidikan')
                    ->required(),

                    Forms\Components\Repeater::make('certification')
                    ->label('Sertifikasi')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Nama Sertifikasi')
                            ->required(),

                        Forms\Components\FileUpload::make('file')
                            ->label('File Sertifikasi')
                            ->disk('public')  
                            ->required(),
                    ])
                    ->createItemButtonLabel('Tambah Sertifikasi')
                    ->required(),
                Forms\Components\FileUpload::make('photo')
                    ->label('Foto')
                    ->image()
                    ->required(),

                Forms\Components\TextInput::make('contact')
                    ->label('Kontak')
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

                Tables\Columns\TextColumn::make('user.name')
                    ->label('Nama Pengguna')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('experience')
                    ->label('Pengalaman (Tahun)')
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat Pada')
                    ->date()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\Filter::make('experience')
                    ->label('Pengalaman')
                    ->form([
                        Forms\Components\TextInput::make('experience')
                            ->label('Pengalaman (Tahun)')
                            ->numeric(),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query->when(
                            $data['experience'],
                            fn (Builder $query, $experience) => $query->where('experience', '>=', $experience)
                        );
                    }),
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
            'index' => Pages\ListApplicants::route('/'),
            'create' => Pages\CreateApplicant::route('/create'),
            'edit' => Pages\EditApplicant::route('/{record}/edit'),
        ];
    }
}
