<x-app-layout>
    <div class="card">
        <h5 class="card-header">Danh sách hỗ trợ (Tickets)</h5>
        <div class="table-responsive text-nowrap">
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Tiêu đề</th>
                        <th>Người tạo</th>
                        <th>Trạng thái</th>
                        <th class="text-center">Thao tác</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @foreach($tickets as $ticket)
                    <tr>
                        <td>{{ $ticket->id }}</td>
                        <td>{{ $ticket->title }}</td>
                        <td>{{ $ticket->user->name }}</td>
                        <td>
                            @if($ticket->status)
                                <span class="badge bg-{{ $ticket->status->getColor() }}">{{ $ticket->status->getLabel() }}</span>
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
        </div>  
        <div class="p-3">
            {{ $tickets->links() }}
        </div>
    </div>
</x-app-layout>