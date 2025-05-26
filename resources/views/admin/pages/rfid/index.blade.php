@extends('admin.index')
@section('title')
    Tất cả thẻ RFID
@endsection
@section('conten')
    <div id="content-page" class="content-page">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card shadow mb-4">
                        <div class="card-header bg-primary text-white py-3">
                            <h4 class="m-0 font-weight-bold">
                                <i class="las la-id-card mr-2"></i>QUẢN LÝ THẺ RFID THÀNH VIÊN
                            </h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover" id="rfidTable" width="100%"
                                    cellspacing="0">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>Mã thẻ</th>
                                            <th>Tên thành viên</th>
                                            <th>SĐT</th>
                                            <th>Ngày tham gia</th>
                                            <th>Tháng đã đóng</th>
                                            <th>Trạng thái</th>
                                            <th>Hành động</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($members as $member)
                                            <tr>
                                                <td>{{ $member->rfid_card_id }}</td>
                                                <td>{{ $member->full_name }}</td>
                                                <td>{{ $member->phone }}</td>
                                                <td>
                                                    @if ($member->join_date)
                                                        {{ \Carbon\Carbon::parse($member->join_date)->format('d/m/Y') }}
                                                    @else
                                                        N/A
                                                    @endif
                                                </td>
                                                <td class="text-center">{{ $member->total_months_paid }}</td>
                                                <td>
                                                    <span
                                                        class="badge badge-{{ $member->status == 'active' ? 'success' : 'danger' }}">
                                                        {{ $member->status == 'active' ? 'Đang hoạt động' : 'Đã khóa' }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <div class="btn-group btn-group-sm">

                                                        {{-- Khóa thẻ --}}
                                                        @if ($member->status == 'active')
                                                            <form
                                                                action="{{ route('admin.rfid.update', $member->member_id) }}"
                                                                method="POST"
                                                                onsubmit="return confirm('Bạn có chắc chắn muốn khóa thẻ này không?')">
                                                                @csrf
                                                                @method('PUT')
                                                                <input type="hidden" name="status" value="banned">
                                                                <button type="submit" class="btn btn-warning"
                                                                    title="Khóa thẻ">
                                                                    <i class="las la-lock"></i>
                                                                </button>
                                                            </form>
                                                        @else
                                                            {{-- Mở khóa thẻ --}}
                                                            <form
                                                                action="{{ route('admin.rfid.update', $member->member_id) }}"
                                                                method="POST"
                                                                onsubmit="return confirm('Bạn có chắc chắn muốn mở khóa thẻ này không?')">
                                                                @csrf
                                                                @method('PUT')
                                                                <input type="hidden" name="status" value="active">
                                                                <button type="submit" class="btn btn-success"
                                                                    title="Mở khóa thẻ">
                                                                    <i class="las la-lock-open"></i>
                                                                </button>
                                                            </form>
                                                        @endif



                                                        {{-- Gỡ thẻ --}}
                                                        <form action="{{ route('admin.rfid.destroy', $member->member_id) }}"
                                                            method="POST"
                                                            onsubmit="return confirm('Bạn có chắc chắn muốn xóa thẻ này không?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger" title="Gỡ thẻ">
                                                                <i class="las la-id-card"></i>
                                                            </button>
                                                        </form>

                                                    </div>
                                                </td>

                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!--  Unlock Card Modal -->
        <div class="modal fade" id="unlockCardModal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-success text-white">
                        <h5 class="modal-title">Xác nhận mở khóa thẻ</h5>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Bạn có chắc chắn muốn mở khóa thẻ RFID này? Thành viên sẽ có thể sử dụng thẻ này để vào phòng
                            tập.
                        </p>
                        <form id="unlockCardForm" method="POST">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="status" value="active">
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                        <button type="button" class="btn btn-success" id="confirmUnlockCard">Xác nhận mở</button>
                    </div>
                </div>
            </div>
        </div>

        <!--  Delete Card Modal -->
        <div class="modal fade" id="deleteCardModal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title">Xác nhận xóa thẻ</h5>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Bạn có chắc chắn muốn xóa thẻ RFID này? Thao tác này không thể hoàn tác.</p>
                        <form id="deleteCardForm" method="POST">
                            @csrf
                            @method('DELETE')
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                        <button type="button" class="btn btn-danger" id="confirmDeleteCard">Xác nhận xóa</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('customjs')
    <script>
        $(document).ready(function() {
            // Initialize DataTable
            $('#rfidTable').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.25/i18n/Vietnamese.json"
                },
                "columnDefs": [{
                    "orderable": false,
                    "targets": [4]
                }]
            });

            // Initialize tooltips
            $('[data-toggle="tooltip"]').tooltip();




        });
    </script>
@endsection
