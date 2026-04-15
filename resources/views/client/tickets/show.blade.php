@extends('client.layouts.master')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4">Chi tiết Ticket</h4>

        <div class="card">
            <div class="card-body">
                <h5>{{ $ticket->title }}</h5>
                <p><strong>Nội dung:</strong> {{ $ticket->content }}</p>
                <p><strong>Người tạo:</strong> {{ $ticket->user->name ?? 'N/A' }}</p>
                <p><strong>Người được giao:</strong> {{ $ticket->assignee->name ?? 'Chưa giao' }}</p>
                <p><strong>Trạng thái:</strong>
                    @if($ticket->status)
                        <span class="badge bg-{{ $ticket->status->getColor() }}">{{ $ticket->status->getLabel() }}</span>
                    @else
                        N/A
                    @endif
                </p>
                <p><strong>Ưu tiên:</strong> {{ $ticket->priority ? $ticket->priority->getLabel() : 'N/A' }}</p>
                <a href="{{ route('dashboard') }}" class="btn btn-secondary">Quay lại</a>
            </div>
        </div>
    </div>
@endsection