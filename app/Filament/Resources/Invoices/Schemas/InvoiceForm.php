<?php

namespace App\Filament\Resources\Invoices\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class InvoiceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('code')
                    ->required(),
                TextInput::make('contract_id')
                    ->required()
                    ->numeric(),
                TextInput::make('customer_id')
                    ->required()
                    ->numeric(),
                TextInput::make('department_id')
                    ->numeric(),
                DatePicker::make('issue_date')
                    ->required(),
                DatePicker::make('due_date')
                    ->required(),
                TextInput::make('subtotal')
                    ->required()
                    ->numeric()
                    ->default(0.0),
                TextInput::make('vat_rate')
                    ->required()
                    ->numeric()
                    ->default(10.0),
                TextInput::make('vat_amount')
                    ->required()
                    ->numeric()
                    ->default(0.0),
                TextInput::make('total_amount')
                    ->required()
                    ->numeric()
                    ->default(0.0),
                TextInput::make('paid_amount')
                    ->required()
                    ->numeric()
                    ->default(0.0),
                TextInput::make('remaining')
                    ->numeric(),
                Select::make('status')
                    ->options([
            'draft' => 'Draft',
            'sent' => 'Sent',
            'paid' => 'Paid',
            'partial' => 'Partial',
            'overdue' => 'Overdue',
            'cancelled' => 'Cancelled',
        ])
                    ->default('draft')
                    ->required(),
                Select::make('payment_method')
                    ->options(['bank_transfer' => 'Bank transfer', 'cash' => 'Cash', 'check' => 'Check', 'other' => 'Other']),
                Textarea::make('bank_info')
                    ->columnSpanFull(),
                Textarea::make('notes')
                    ->columnSpanFull(),
                TextInput::make('created_by')
                    ->numeric(),
            ]);
    }
}
