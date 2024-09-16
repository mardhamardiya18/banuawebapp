<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('category_id')
                    ->relationship('category', 'name')
                    ->label('Pilih kategori produk')
                    ->required(),

                TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->placeholder('isi nama produk')
                    ->label('Judul produk'),

                TextInput::make('price')
                    ->required()
                    ->placeholder('tentukan harga')
                    ->label('Tentukan harga')
                    ->prefix('Rp'),

                TextInput::make('caption')
                    ->required()
                    ->maxLength(40)
                    ->placeholder('buat sedikit caption')
                    ->label('Buat sedikit caption'),

                FileUpload::make('thumbnail')
                    ->image()
                    ->required()
                    ->label('Upload cover produk'),

                RichEditor::make('about')
                    ->label('Buat deskripsi produk')
                    ->required(),

                Toggle::make('is_recommend')
                    ->label('Rekomendasikan produk?'),


                Repeater::make('photos')
                    ->relationship('galleries')
                    ->schema([
                        FileUpload::make('photo')
                            ->required()
                    ])
                    ->label('Foto produk'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                TextColumn::make('category.name'),
                ImageColumn::make('thumbnail'),
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('price'),
                TextColumn::make('views'),
                IconColumn::make('is_recommend')
                    ->boolean()
                    ->trueColor('success')
                    ->falseColor('danger')
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->label('Rekomendasi'),

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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
