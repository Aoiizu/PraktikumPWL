<?php

namespace App\Filament\Resources\Posts\Schemas;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Group;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DateTimePicker;
use Illuminate\Validation\Rules\Unique;

class PostForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                Section::make("Post Details")
                    ->description("Fill in the post details")
                    ->icon('heroicon-o-document-text')
                    ->schema([

                        Group::make([
                            TextInput::make("title")->required(),
                        TextInput::make('slug')
                            ->required()
                            ->unique(ignoreRecord: true),

                            Select::make('category_id')
                                ->relationship("category", "name")
                                ->preload()
                                ->searchable()
                                ->required(),

                            ColorPicker::make('color'),
                        ])->columns(2),

                        MarkdownEditor::make("body"),

                    ])
                    ->columnSpan(2),

                Group::make([
                    Section::make("Image Upload")
                        ->schema([
                            FileUpload::make("image")
                                ->disk("public")
                                ->directory("posts"),
                        ]),

                    Section::make("Meta Info")
                        ->schema([
                            TagsInput::make("tags"),
                            Checkbox::make("published"),
                            DateTimePicker::make("published_at"),
                        ]),
                ])->columnSpan(1),

            ])
            ->columns(3);
    }
}

