<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CapitulomResource\Pages;
use App\Filament\Resources\CapitulomResource\RelationManagers;
use App\Models\Capitulom;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\RegistroResource;
use App\Models\User;

class CapitulomResource extends Resource
{
    protected static ?string $model = Capitulom::class;

    protected static ?string $navigationIcon = 'heroicon-s-document-minus';

    protected static ?string $navigationGroup = 'Investigación';

    protected static ?string $modelLabel = 'Capítulo de Memoria';

    protected static ?string $pluralModelLabel = "Capítulos de Memoria";

    protected static ?string $slug = "Capitulos-Memoria";

    public static $revision = ["Sin Arbitraje", "Arbitrado"];

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Forms\Components\Hidden::make('user_id')
                ->default(auth()->user()->id),

                Forms\Components\Section::make('Información de Registro')
                    ->relationship('registro')
                    ->schema(RegistroResource::form($form)->getComponents())
                    ->columns(2),

                    Forms\Components\Section::make('Información Adicional')
                ->schema([

                    Forms\Components\Grid::make()
                    ->schema([

                
                Forms\Components\TextInput::make('congreso')
                    ->required()
                    ->maxLength(255)
                    ->label('Congreso'),
                Forms\Components\Select::make('revision')
                    ->required()
                    ->options(CapitulomResource::$revision)
                    ->label('Revisión'),
                Forms\Components\TextInput::make('estado_region')
                    ->required()
                    ->maxLength(255)
                    ->label('Lugar'),
                Forms\Components\TextInput::make('ciudad')
                    ->required()
                    ->maxLength(255)
                    ->label('Ciudad'),
                

                    ])
                    ->columns(2),

                    Forms\Components\Grid::make()
                    ->schema([
                Forms\Components\TextInput::make('pagina_inicio')
                    ->required()
                    ->numeric()
                    ->minValue(0)
                    ->label('Página Inicio'),
                Forms\Components\TextInput::make('pagina_fin')
                    ->required()
                    ->numeric()
                    ->minValue(0)
                    ->label('Página Fin'),
                Forms\Components\TextInput::make('isbn')
                    ->label('ISBN')
                    ->maxLength(255),
                Forms\Components\TextInput::make('issn')
                    ->label('ISSN')
                    ->maxLength(255),
                    ])
                    ->columns(4),

                ])
                
              
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                
                Tables\Columns\TextColumn::make('congreso')
                    ->searchable(),
                Tables\Columns\TextColumn::make('estado_region')
                    ->label('Estado')
                    ->searchable(),
                Tables\Columns\TextColumn::make('ciudad')
                    ->searchable()
                    ->label('Ciudad'),
                Tables\Columns\TextColumn::make('revision')

                    ->searchable()
                    ->label('Revisión')
                    ->formatStateUsing(fn(string $state): string => CapitulomResource::$revision[$state])
                    ->searchable(),

                 

                Tables\Columns\TextColumn::make('pagina_inicio')
                    ->numeric()
                    ->sortable()
                    ->label('Página Inicio'),
                Tables\Columns\TextColumn::make('pagina_fin')
                    ->numeric()
                    ->sortable()
                    ->label('Página Fin'),
                Tables\Columns\TextColumn::make('isbn')
                    ->label('ISBN')
                    ->searchable(),
                Tables\Columns\TextColumn::make('issn')
                    ->label('ISSN')
                    ->searchable(),

                    
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
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
            'index' => Pages\ListCapituloms::route('/'),
            'create' => Pages\CreateCapitulom::route('/create'),
            'edit' => Pages\EditCapitulom::route('/{record}/edit'),
        ];
    }
    public static function getEloquentQuery(): Builder
{
    return parent::getEloquentQuery()->where('user_id', auth()->user()->id);
}

    public static function shouldRegisterNavigation(): bool
    {
        return !auth()->user()->es_admin;
    }

    public static function canViewAny(): bool
    {
        return !auth()->user()->es_admin;
    }
}
