<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (! Schema::hasColumn('tickets', 'ticket_code')) {
            Schema::table('tickets', function (Blueprint $table) {
                $table->string('ticket_code')->nullable()->after('id');
            });
        }

        if (! Schema::hasColumn('tickets', 'completed_at')) {
            Schema::table('tickets', function (Blueprint $table) {
                $table->timestamp('completed_at')->nullable()->after('updated_at');
            });
        }

        // Generate ticket codes for existing records that are blank or null
        $tickets = DB::table('tickets')
            ->whereNull('ticket_code')
            ->orWhere('ticket_code', '')
            ->orderBy('id')
            ->get();

        foreach ($tickets as $ticket) {
            $year = date('Y', strtotime($ticket->created_at));
            $lastTicket = DB::table('tickets')
                ->where('ticket_code', 'like', "TK-{$year}-%")
                ->whereNotNull('ticket_code')
                ->orderBy('id', 'desc')
                ->first();

            if ($lastTicket) {
                $lastNumber = (int) substr($lastTicket->ticket_code, -3);
                $newNumber = $lastNumber + 1;
            } else {
                $newNumber = 1;
            }

            DB::table('tickets')
                ->where('id', $ticket->id)
                ->update(['ticket_code' => sprintf('TK-%s-%03d', $year, $newNumber)]);
        }

        $driver = Schema::getConnection()->getDriverName();

        $existingIndex = match ($driver) {
            'sqlite' => collect(DB::select("PRAGMA index_list('tickets')"))
                ->contains(fn ($index) => ($index->name ?? null) === 'tickets_ticket_code_unique'),
            'mysql' => ! empty(DB::select("SHOW INDEX FROM tickets WHERE Key_name = 'tickets_ticket_code_unique'")),
            default => false,
        };

        if (! $existingIndex) {
            Schema::table('tickets', function (Blueprint $table) {
                $table->unique('ticket_code');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->dropColumn(['ticket_code', 'completed_at']);
        });
    }
};
