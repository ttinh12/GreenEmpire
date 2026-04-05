<?php
use App\Enums\TicketStatus;
?>
@extends('client.layouts.master')

@section('title')
    Danh sách Ticket
@endsection

@section('content')
    <div class="container mt-4">
        <h2 class="mb-4">Danh sách hỗ trợ (Tickets)</h2>

        <table class="table table-hover">
            <thead class="table-light">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Tiêu đề</th>
                    <th scope="col">Người tạo</th>
                    <th scope="col">Người được giao</th>
                    <th scope="col">Trạng thái</th>
                    <th scope="col" class="text-center">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @foreach($tickets as $ticket)
                    <tr>
                        <td>{{ $ticket->id }}</td>
                        <td>{{ $ticket->title }}</td>
                        <td>{{ Str::limit($ticket->content, 30) }}</td>
                        <td>{{ $ticket->creator->name ?? 'N/A' }}</td>
                        <td>{{ $ticket->assignee->name ?? 'Chưa giao' }}</td>
                        <td>
                            @php
                                $statusEnum = $ticket->status instanceof TicketStatus
                                    ? $ticket->status
                                    : TicketStatus::tryFrom($ticket->status);
                            @endphp

                            @if($statusEnum)
                                <span class="badge bg-{{ $statusEnum->getColor() }}">
                                    {{ $statusEnum->getLabel() }}
                                </span>
                            @else
                                <span class="badge bg-secondary">N/A</span>
                            @endif
                        </td>

                        <td class="text-center">
                            <a href="{{ route('tickets.show', $ticket->id) }}" class="btn btn-sm btn-info text-white">
                                <i class="fas fa-search"></i> Xem chi tiết
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>    

        <div class="d-flex justify-content-center mt-4">
            {{ $tickets->links() }}
        </div>
    </div>
@endsection