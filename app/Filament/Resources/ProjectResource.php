<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProjectResource\Pages;
use App\Models\Project;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Concerns\Translatable;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class ProjectResource extends Resource
{
    use Translatable;

    protected static ?string $model = Project::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Overview')
                ->columns(2)
                ->schema([
                    Forms\Components\TextInput::make('title')
                        ->required()
                        ->maxLength(255)
                        ->live(onBlur: true)
                        ->afterStateUpdated(function (string $operation, $state, Forms\Set $set) {
                            if ($operation === 'create') {
                                $set('slug', Str::slug($state));
                            }
                        }),

                    Forms\Components\TextInput::make('slug')
                        ->required()
                        ->maxLength(255)
                        ->unique(ignoreRecord: true)
                        ->helperText('Used in the URL: /projects/{slug}. Same across languages.'),

                    Forms\Components\TextInput::make('my_role')
                        ->label('My role')
                        ->placeholder('e.g. Solo full-stack developer')
                        ->maxLength(255)
                        ->columnSpanFull(),
                ]),

            Forms\Components\Section::make('Case study')
                ->description('Shown on the project detail page, in this order.')
                ->schema([
                    Forms\Components\Textarea::make('problem')
                        ->label('1. Problem')
                        ->rows(3)
                        ->helperText('What challenge existed?'),

                    Forms\Components\Textarea::make('what_i_built')
                        ->label('2. What I built')
                        ->rows(3)
                        ->helperText('The solution, in plain terms.'),

                    Forms\Components\Repeater::make('key_features')
                        ->label('3. Key features')
                        ->simple(
                            Forms\Components\TextInput::make('feature')->required(),
                        )
                        ->addActionLabel('Add feature')
                        ->reorderable()
                        ->default([]),

                    Forms\Components\Textarea::make('outcome')
                        ->label('9. Outcome')
                        ->rows(3)
                        ->helperText('Closing result / impact statement.'),
                ]),

            Forms\Components\Section::make('Tech & links')
                ->description('Not translated — the same in every language.')
                ->columns(2)
                ->schema([
                    Forms\Components\TagsInput::make('tech_stack')
                        ->label('Tech stack')
                        ->placeholder('Add a technology')
                        ->columnSpanFull(),

                    Forms\Components\TextInput::make('live_demo_url')
                        ->label('Live demo URL')
                        ->url()
                        ->prefixIcon('heroicon-m-globe-alt'),

                    Forms\Components\TextInput::make('github_url')
                        ->label('GitHub URL')
                        ->url()
                        ->prefixIcon('heroicon-m-code-bracket'),

                    Forms\Components\Toggle::make('is_public_github')
                        ->label('GitHub repo is public')
                        ->helperText('If off, the GitHub button is hidden.')
                        ->default(true),

                    Forms\Components\Toggle::make('featured')
                        ->helperText('Show in the homepage highlights.'),

                    Forms\Components\TextInput::make('sort_order')
                        ->numeric()
                        ->default(0)
                        ->helperText('Lower numbers appear first.'),
                ]),

            Forms\Components\Section::make('Screenshots')
                ->schema([
                    Forms\Components\SpatieMediaLibraryFileUpload::make('screenshots')
                        ->collection('screenshots')
                        ->multiple()
                        ->reorderable()
                        ->appendFiles()
                        ->image()
                        ->imageEditor()
                        ->panelLayout('grid')
                        ->helperText('Drag to reorder. First image is used as the card thumbnail.'),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->reorderable('sort_order')
            ->defaultSort('sort_order')
            ->columns([
                Tables\Columns\SpatieMediaLibraryImageColumn::make('screenshots')
                    ->collection('screenshots')
                    ->conversion('thumb')
                    ->limit(1)
                    ->label('')
                    ->square(),

                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->description(fn (Project $record): string => $record->slug),

                Tables\Columns\TextColumn::make('tech_stack')
                    ->badge()
                    ->limitList(3),

                Tables\Columns\IconColumn::make('featured')
                    ->boolean()
                    ->sortable(),

                Tables\Columns\IconColumn::make('is_public_github')
                    ->label('Public repo')
                    ->boolean()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->since()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('featured'),
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProjects::route('/'),
            'create' => Pages\CreateProject::route('/create'),
            'edit' => Pages\EditProject::route('/{record}/edit'),
        ];
    }
}
