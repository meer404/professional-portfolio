<?php

namespace App\Filament\Pages;

use App\Settings\SiteSettings;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Pages\SettingsPage;

class ManageSiteSettings extends SettingsPage
{
    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static string $settings = SiteSettings::class;

    protected static ?string $navigationLabel = 'Site Settings';

    protected static ?string $title = 'Site Settings';

    protected static ?int $navigationSort = 9;

    public function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Tabs::make('Settings')->columnSpanFull()->tabs([

                Forms\Components\Tabs\Tab::make('Identity')->icon('heroicon-m-user')->schema([
                    Forms\Components\TextInput::make('name')
                        ->label('Full name')
                        ->required(),

                    Forms\Components\FileUpload::make('profile_photo')
                        ->label('Profile photo')
                        ->image()
                        ->avatar()
                        ->imageEditor()
                        ->imageEditorAspectRatios(['1:1', '4:5'])
                        ->disk('public')
                        ->directory('site')
                        ->helperText('A real headshot. Square or 4:5 works best.'),

                    Forms\Components\TextInput::make('contact_email')
                        ->label('Public contact email')
                        ->email(),

                    self::localePair('location', 'Location', fn ($f) => $f),
                ]),

                Forms\Components\Tabs\Tab::make('Hero')->icon('heroicon-m-bolt')->schema([
                    self::localePair('hero_tagline', 'Tagline', fn (Forms\Components\TextInput $f) => $f->maxLength(255)),

                    Forms\Components\TagsInput::make('hero_phrases.en')
                        ->label('Rotating phrases (English)')
                        ->helperText('Cycled in the hero animation. Press Enter after each.')
                        ->default([]),

                    Forms\Components\TagsInput::make('hero_phrases.ckb')
                        ->label('Rotating phrases (Kurdish)')
                        ->default([]),

                    Forms\Components\FileUpload::make('hero_artifact')
                        ->label('Hero screenshot')
                        ->image()
                        ->imageEditor()
                        ->disk('public')
                        ->directory('site')
                        ->helperText('A screenshot of one of your projects, shown in a framed window in the hero. Landscape (16:9) works best.'),

                    Forms\Components\TextInput::make('hero_artifact_label')
                        ->label('Hero screenshot label')
                        ->maxLength(60)
                        ->helperText('Shown in the window title bar. Defaults to your name.'),
                ]),

                Forms\Components\Tabs\Tab::make('About')->icon('heroicon-m-identification')->schema([
                    Forms\Components\RichEditor::make('about_me.en')->label('About me (English)'),
                    Forms\Components\RichEditor::make('about_me.ckb')->label('About me (Kurdish)'),
                ]),

                Forms\Components\Tabs\Tab::make('CV / Résumé')->icon('heroicon-m-document-text')->schema([
                    Forms\Components\RichEditor::make('resume_summary.en')->label('Summary (English)'),
                    Forms\Components\RichEditor::make('resume_summary.ckb')->label('Summary (Kurdish)'),

                    Forms\Components\FileUpload::make('cv_en')
                        ->label('CV — English (PDF)')
                        ->acceptedFileTypes(['application/pdf'])
                        ->disk('public')->directory('site'),

                    Forms\Components\FileUpload::make('cv_ckb')
                        ->label('CV — Kurdish (PDF)')
                        ->acceptedFileTypes(['application/pdf'])
                        ->disk('public')->directory('site'),
                ]),

                Forms\Components\Tabs\Tab::make('Social links')->icon('heroicon-m-link')->schema([
                    Forms\Components\Repeater::make('social_links')
                        ->label('')
                        ->schema([
                            Forms\Components\Select::make('platform')
                                ->options([
                                    'github' => 'GitHub',
                                    'linkedin' => 'LinkedIn',
                                    'email' => 'Email',
                                    'twitter' => 'X / Twitter',
                                    'instagram' => 'Instagram',
                                    'facebook' => 'Facebook',
                                    'website' => 'Website',
                                ])
                                ->required()
                                ->native(false),
                            Forms\Components\TextInput::make('label')->required(),
                            Forms\Components\TextInput::make('url')
                                ->required()
                                ->helperText('Full URL, or mailto: for email.'),
                        ])
                        ->columns(3)
                        ->reorderable()
                        ->default([]),
                ]),
            ]),
        ]);
    }

    /**
     * Two side-by-side inputs for an EN/CKB translatable string setting.
     */
    protected static function localePair(string $key, string $label, callable $configure): Forms\Components\Grid
    {
        return Forms\Components\Grid::make(2)->schema([
            $configure(Forms\Components\TextInput::make("{$key}.en")->label("{$label} (English)")),
            $configure(Forms\Components\TextInput::make("{$key}.ckb")->label("{$label} (Kurdish)")),
        ]);
    }
}
