<?php

namespace App\Filament\Resources\Pacientes;

use App\Filament\Resources\Pacientes\Pages\CreatePaciente;
use App\Filament\Resources\Pacientes\Pages\EditPaciente;
use App\Filament\Resources\Pacientes\Pages\ListPacientes;
use App\Filament\Resources\Pacientes\Pages\ViewPaciente;
use App\Filament\Resources\Pacientes\Schemas\PacienteForm;
use App\Filament\Resources\Pacientes\Schemas\PacienteInfolist;
use App\Filament\Resources\Pacientes\Tables\PacientesTable;
use App\Filament\Resources\Pacientes\RelationManagers\PatientRelationManager;
use App\Models\Patient;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class PacienteResource extends Resource
{
    protected static ?string $model = Patient::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Paciente';

        // Añade esta línea para definir la etiqueta singular
    protected static ?string $modelLabel = 'Paciente';

    // Añade esta línea para definir la etiqueta plural
    protected static ?string $pluralModelLabel = 'Pacientes';

    // Añade esta línea para cambiar la etiqueta
    protected static ?string $navigationLabel = 'Pacientes';

    public static function form(Schema $schema): Schema
    {
        return PacienteForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return PacienteInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PacientesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            PatientRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPacientes::route('/'),
            'create' => CreatePaciente::route('/create'),
            'view' => ViewPaciente::route('/{record}'),
            'edit' => EditPaciente::route('/{record}/edit'),
        ];
    }
}
