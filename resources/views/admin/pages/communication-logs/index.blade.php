@extends('admin.index')

@section('conten')
    <div id="content-page" class="content-page">

        <div class="container-fluid">
            <h1>Lịch Sử Gửi Email</h1>

            <div class="card">

                <div class="card-body">
                    <table class="table table-striped" id="communication-logs">
                        <thead>
                            <tr>
                                <th>Người Nhận</th>
                                <th>Tên Chiến Dịch</th>
                                <th>Tiêu Đề</th>
                                <th>Người Gửi</th>
                                <th>Thời Gian Gửi</th>
                                <th>Trạng Thái</th>
                                <th>Hành Động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($logs as $log)
                                <tr>
                                    <td>{{ $log->member->full_name ?? '[Đã xóa]' }}</td>
                                    <td>{{ $log->campaign_name }}</td>
                                    <td>{{ Str::limit($log->subject, 40) }}</td>
                                    <td>{{ $log->sender->full_name ?? 'Hệ thống' }}</td>
                                    <td>{{ \Carbon\Carbon::parse($log->sent_at)->format('H:i d/m/Y') }}</td>

                                    <td>
                                        @if ($log->status == 'sent')
                                            <span class="badge badge-success">Thành công</span>
                                        @else
                                            <span class="badge badge-danger">Thất bại</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.communication-logs.show', $log->log_id) }}"
                                            class="btn btn-sm btn-info">Xem</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">Không có lịch sử nào.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
@endsection
@section('customjs')
    <script>
        $(document).ready(function() {
            $('#communication-logs').DataTable({
                pageLength: 5,
                order: [
                    [3, 'desc']
                ],
                language: {
                    lengthMenu: "Hiển thị _MENU_ bản ghi mỗi trang",
                    zeroRecords: "Không tìm thấy dữ liệu",
                    info: "Hiển thị _START_ đến _END_ của _TOTAL_ bản ghi",
                    infoEmpty: "Không có dữ liệu",
                    infoFiltered: "(lọc từ _MAX_ bản ghi)",
                    search: "Tìm kiếm:",
                    paginate: {
                        first: "Đầu",
                        last: "Cuối",
                        next: "Sau",
                        previous: "Trước"
                    }
                }
            });
        });
    </script>
@endsection
