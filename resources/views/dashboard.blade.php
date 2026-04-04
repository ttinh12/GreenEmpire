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
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @foreach($tickets as $ticket)
                    <tr>
                        <td>{{ $ticket->id }}</td>
                        <td>{{ $ticket->title }}</td>
                        <td>{{ $ticket->creator->name }}</td>
                        <td><span class="badge bg-label-primary me-1">Hoạt động</span></td>
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