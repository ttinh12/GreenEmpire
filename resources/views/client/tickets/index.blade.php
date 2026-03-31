@extends('client.layouts.master')
@section('content')
    <table class="table">
        <thead>
            <tr>
                <th scope="col">STT</th>
                <th scope="col">Nội dung</th>
                <th scope="col">Người tạo</th>
                <th scope="col">Người được giao</th>
                <th scope="col">Trạng thái</th>
                <th scope="col">Ngày tạo</th>
            </tr>
        </thead>
        <tbody>
            @foreach($tickets as $ticket)
                <tr>
                    <td>{{ $ticket->id }}</td>
                    <td>{{ $ticket->title }}</td>
                    <td>{{ $ticket->creator->name }}</td>
                    <td>{{ $ticket->assignee->name ?? 'Chưa giao' }}</td>
                    <td>
                        @if($ticket->status == 'open')
                            <span class="badge bg-label-primary">Mới</span>
                        @elseif($ticket->status == 'processing')
                            <span class="badge bg-label-warning">Đang xử lý</span>
                        @else
                            <span class="badge bg-label-success">Hoàn thành</span>
                        @endif
                    </td>
                    <td>{{ $ticket->created_at->format('d/m/Y H:i') }}</td>
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