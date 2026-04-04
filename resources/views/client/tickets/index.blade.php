<?php
use App\Enums\TicketStatus;
?>
@extends('client.layouts.master')
@section('content')
    <table class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Tiêu đề</th>
                <th scope="col">Nội dung</th>
                <th scope="col">Người tạo</th>
                <th scope="col">Người được giao</th>
                <th scope="col">Trạng thái</th>
            </tr>
        </thead>
        <tbody>
            @foreach($tickets as $ticket)
                <tr>
                    <td>{{ $ticket->id }}</td>
                    <td>{{ $ticket->title }}</td>
                    <td>{{ $ticket->content }}</td>
                    <td>{{ $ticket->creator->name }}</td>
                    <td>{{ $ticket->assignee->name ?? 'Chưa giao' }}</td>
                    <td>
                        @php
                            // Lấy enum case từ giá trị database nếu chưa cast, 
                            // hoặc dùng trực tiếp nếu đã cast trong Model
                            $statusEnum = $ticket->status instanceof TicketStatus
                                ? $ticket->status
                                : TicketStatus::tryFrom($ticket->status);
                        @endphp
                        @if($statusEnum)
                            <span class="badge bg-{{ $statusEnum->getColor() }}">
                                {{ $statusEnum->getLabel() }}
                            </span>
                        @else
                            <span class="badge bg-warning">Lỗi: {{ $ticket->status }}</span>
                        @endif
                    </td>
                </tr>
            @endforeach

            <div class="mt-3">
                {{ $tickets->links() }}
            </div>
        </tbody>
    </table>

@endsection

@section('title')
    Danh sach ticket
@endsection