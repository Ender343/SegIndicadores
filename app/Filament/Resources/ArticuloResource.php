<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ArticuloResource\Pages;
use App\Filament\Resources\ArticuloResource\RelationManagers;
use App\Models\Articulo;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ArticuloResource extends Resource
{
    protected static ?string $model = Articulo::class;

    protected static ?string $navigationIcon = 'heroicon-o-newspaper';
    
    protected static ?string $modelLabel = 'Artículo';

    protected static ?string $pluralModelLabel = "Artículos";    
    protected static ?string $slug = "Articulos";

    public static $estatus = ["Sometido","Aceptado","Publicado"];

    public static $tipos = ["Divulgacion","Arbitrado","Indexado"];

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('revista')
                    ->label('Revista')     
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('estatus')
                    ->label('Estatus')
                    ->required()
                    ->options(ArticuloResource::$estatus),
                Forms\Components\Select::make('tipo')
                    ->label('Tipo')
                    ->required()
                    ->options(ArticuloResource::$tipos),
                Forms\Components\TextInput::make('volumen')
                    ->label('Volumen')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('indice')
                    ->label('Indice')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('url')
                    ->label('URL')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('pagina_inicio')
                    ->label('Pagina inicio')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('pagina_fin')
                    ->label('Pagina fin')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('isbn')
                    ->label('ISBN')    
                    ->maxLength(255),
                Forms\Components\TextInput::make('issn')
                    ->label('ISSN')
                    ->maxLength(255),
                Forms\Components\TextInput::make('casa_editorial')
                    ->label('Casa editorial')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('Revista')
                    ->searchable(),
                Tables\Columns\TextColumn::make('Estatus')
                    ->searchable(),
                Tables\Columns\TextColumn::make('Tipo')
                    ->searchable(),
                Tables\Columns\TextColumn::make('Volumen')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('Indice')
                    ->searchable(),
                Tables\Columns\TextColumn::make('Url')
                    ->searchable(),
                Tables\Columns\TextColumn::make('Pagina Inicio')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('Pagina Fin')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('ISBN')
                    ->searchable(),
                Tables\Columns\TextColumn::make('ISSN')
                    ->searchable(),
                Tables\Columns\TextColumn::make('Casa editorial')
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
            'index' => Pages\ListArticulos::route('/'),
            'create' => Pages\CreateArticulo::route('/create'),
            'edit' => Pages\EditArticulo::route('/{record}/edit'),
        ];
    }    
}
