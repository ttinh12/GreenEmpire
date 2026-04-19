<?php

namespace App\Filament\Resources\Tasks;

use App\Filament\Resources\Tasks\Pages\CreateTask;
use App\Filament\Resources\Tasks\Pages\EditTask;
use App\Filament\Resources\Tasks\Pages\ListTasks;
use App\Filament\Resources\Tasks\Pages\TaskKanban;
use App\Filament\Resources\Tasks\Tables\TasksTable;
use App\Filament\Resources\Tasks\Schemas\TaskForm;
use App\Models\Task;
use BackedEnum;
use UnitEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TaskResource extends Resource
{
    protected static ?string $model = Task::class;
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCheckCircle;
    protected static string|UnitEnum|null $navigationGroup = 'Chăm sóc & Hỗ trợ';
    protected static ?string $recordTitleAttribute = 'title';
    protected static ?string $navigationLabel = 'Công việc';

    public static function getPluralModelLabel(): string
    {
        return 'Công việc';
    }

    public static function getModelLabel(): string
    {
        return 'Công việc';
    }


    public static function form(Schema $schema): Schema
    {
        return TaskForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TasksTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListTasks::route('/'),
            'create' => CreateTask::route('/create'),
            'edit' => EditTask::route('/{record}/edit'),
            'kanban' => TaskKanban::route('/kanban'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([SoftDeletingScope::class]);
    }
}
