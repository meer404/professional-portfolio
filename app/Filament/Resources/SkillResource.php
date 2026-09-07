<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SkillResource\Pages;
use App\Models\Skill;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class SkillResource extends Resource
{
    protected static ?string $model = Skill::class;

    protected static ?string $navigationIcon = 'heroicon-o-sparkles';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('name')
                ->required()
                ->maxLength(255),

            Forms\Components\Select::make('category')
                ->options(array_combine(Skill::CATEGORIES, Skill::CATEGORIES))
                ->required()
                ->native(false)
                ->default('Backend'),

            Forms\Components\TextInput::make('sort_order')
                ->numeric()
                ->default(0)
                ->helperText('Lower numbers appear first within a category.'),

            Forms\Components\TextInput::make('proficiency')
                ->numeric()
                ->minValue(0)
                ->maxValue(100)
                ->suffix('%')
                ->helperText('Optional — leave blank to show a plain badge instead of a bar.'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->reorderable('sort_order')
            ->defaultGroup('category')
            ->defaultSort('sort_order')
            ->columns([
                Tables\Columns\TextColumn::make('name')->searchable()->sortable()->weight('bold'),
                Tables\Columns\TextColumn::make('category')->badge()->sortable(),
                Tables\Columns\TextColumn::make('proficiency')
                    ->suffix('%')
                    ->placeholder('—')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('category')
                    ->options(array_combine(Skill::CATEGORIES, Skill::CATEGORIES)),
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSkills::route('/'),
            'create' => Pages\CreateSkill::route('/create'),
            'edit' => Pages\EditSkill::route('/{record}/edit'),
        ];
    }
}
