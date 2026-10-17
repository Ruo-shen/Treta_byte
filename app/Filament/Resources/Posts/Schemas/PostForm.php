<?php

namespace App\Filament\Resources\Posts\Schemas;

use App\Enums\PostStatus;
use App\Models\Post;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class PostForm
{
    public const IMAGE_TYPES = ['image/jpeg', 'image/png', 'image/webp'];

    public const IMAGE_MAX_KB = 2048;

    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make('Article')->schema([
                    TextInput::make('title')
                        ->required()
                        ->maxLength(200)
                        ->live(onBlur: true)
                        ->afterStateUpdated(function (Get $get, Set $set, ?string $state) {
                            if (blank($get('slug'))) {
                                $set('slug', Str::slug((string) $state));
                            }
                        }),
                    TextInput::make('slug')
                        ->required()
                        ->maxLength(200)
                        ->regex('/^[a-z0-9]+(?:-[a-z0-9]+)*$/')
                        ->unique(ignoreRecord: true)
                        ->validationMessages([
                            'regex' => 'Use lowercase letters, numbers and single hyphens only.',
                            'unique' => 'Another post already uses this slug.',
                        ]),
                    Select::make('category_id')
                        ->relationship('category', 'name')
                        ->searchable()
                        ->preload()
                        ->createOptionForm([
                            TextInput::make('name')->required()->maxLength(100),
                        ]),
                    Textarea::make('excerpt')->rows(3)->maxLength(500),
                    RichEditor::make('content')
                        ->toolbarButtons([
                            ['bold', 'italic', 'link'],
                            ['h2', 'h3'],
                            ['bulletList', 'orderedList', 'blockquote', 'codeBlock'],
                            ['undo', 'redo'],
                        ])
                        ->fileAttachments(false),
                    self::image('featured_image_path', 'Featured image')->directory('posts'),
                    TextInput::make('featured_image_alt')
                        ->label('Featured image alt text')
                        ->maxLength(200)
                        ->requiredWith('featured_image_path'),
                ]),
                Section::make('Publishing')->columns(2)->schema([
                    Select::make('status')
                        ->options(PostStatus::class)
                        ->default(PostStatus::Draft)
                        ->required(),
                    DateTimePicker::make('published_at')
                        ->helperText('Leave empty to publish immediately. A future date schedules the post.'),
                ]),
                Section::make('SEO')->collapsed()->schema([
                    TextInput::make('seo_title')->maxLength(70),
                    Textarea::make('meta_description')->rows(2)->maxLength(160),
                    self::image('social_image_path', 'Social image')->directory('posts/social'),
                    TextInput::make('canonical_url')
                        ->label('Canonical URL override')
                        ->url()
                        ->regex('#^https?://#i')
                        ->maxLength(255),
                    Select::make('robots')
                        ->label('Robots override')
                        ->options(Post::ROBOTS_OPTIONS)
                        ->placeholder('Default (index, follow)'),
                ]),
            ]);
    }

    // SVG is excluded on purpose: it can carry script.
    private static function image(string $name, string $label): FileUpload
    {
        return FileUpload::make($name)
            ->label($label)
            ->image()
            ->disk('public')
            ->visibility('public')
            ->acceptedFileTypes(self::IMAGE_TYPES)
            ->rules(['extensions:jpg,jpeg,png,webp'])
            ->maxSize(self::IMAGE_MAX_KB);
    }
}
