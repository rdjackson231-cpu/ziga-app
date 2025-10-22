<?php

namespace App\Filament\Pages;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Pages\BasePage;
use Filament\Schemas\Schema;

class RegisterFrom extends BasePage implements HasForms
{
    use InteractsWithForms;

    protected string $view = "filament.pages.register-from";

    protected static ?string $title = "Custom Page Title";

    public function hasLogo(): bool
    {
        return false;
    }

    public function form(Schema $schema): Schema
    {
        return $schema->schema([TextInput::make("name")]);
    }
}
