@extends('admin.index')

@section('title')
    Gửi email thủ công
@endsection
@section('conten')
    <div id="content-page" class="content-page">
        <div class="container-fluid">
            <h1>Gửi Email Marketing / CSKH</h1>

            {{-- FORM LỌC --}}
            <form method="GET" action="{{ route('admin.engagement.index') }}" class="mb-4 p-3 bg-light border rounded">
                <div class="row">
                    <div class="col-md-4">
                        <label for="months">Số tháng đã tham gia</label>
                        <input type="number" name="months" id="months" class="form-control"
                            value="{{ $filters['months'] ?? '' }}" placeholder="Ví dụ: 3">
                    </div>
                    <div class="col-md-4">
                        <label for="campaign_name">Chiến dịch (để loại trừ)</label>
                        <input type="text" name="campaign_name" id="campaign_name" class="form-control"
                            value="{{ $filters['campaign_name'] ?? '' }}" placeholder="Ví dụ: feedback-3-thang">
                    </div>
                    <div class="col-md-4 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary">Lọc Danh Sách</button>
                    </div>
                </div>
            </form>

            {{-- FORM GỬI EMAIL --}}
            <form method="POST" action="{{ route('admin.engagement.send') }}"
                onsubmit="return confirm('Bạn có chắc chắn muốn gửi email cho các hội viên đã chọn?');">
                @csrf

                {{-- BẢNG DANH SÁCH HỘI VIÊN --}}
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Danh sách hội viên phù hợp</h5>
                        <input type="checkbox" id="select-all"> <label for="select-all">Chọn tất cả</label>
                    </div>
                    <div class="card-body">
                        <table class="table" id="engagementtables">
                            <thead>
                                <tr>
                                    <th>Chọn</th>
                                    <th>Tên Hội Viên</th>
                                    <th>Email</th>
                                    <th>Ngày Tham Gia</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($members as $member)
                                    <tr>
                                        <td><input type="checkbox" name="member_ids[]" value="{{ $member->member_id }}"
                                                class="member-checkbox"></td>
                                        <td>{{ $member->full_name }}</td>
                                        <td>{{ $member->email }}</td>
                                        <td>{{ \Carbon\Carbon::parse($member->join_date)->format('d/m/Y') }}</td>

                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center">Không tìm thấy hội viên nào phù hợp.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                {{ $members->links() }} {{-- Hiển thị phân trang --}}

                {{-- KHU VỰC SOẠN THẢO EMAIL --}}
                <div class="card mt-4">
                    <div class="card-header">
                        <h5 class="card-title">Soạn thảo Email</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="template-selector">Chọn mẫu email có sẵn:</label>
                            <select id="template-selector" class="form-control">
                                <option value="">-- Tự soạn --</option>
                                @foreach ($templates as $template)
                                    <option value="{{ $template->template_id }}" data-subject="{{ $template->subject }}"
                                        data-body="{{ $template->body }}">{{ $template->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="campaign_name_send">Tên chiến dịch (để lưu log):</label>
                            <input type="text" name="campaign_name" id="campaign_name_send" class="form-control" required
                                placeholder="Ví dụ: feedback-3-thang">
                        </div>
                        <div class="form-group">
                            <label for="subject">Tiêu đề email:</label>
                            <input type="text" name="subject" id="subject" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="body">Nội dung email:</label>
                            <textarea name="body" id="body" class="form-control" rows="10" required></textarea>
                            <small class="form-text text-muted">Sử dụng các biến: [TEN_HOI_VIEN], [NGAY_THAM_GIA]</small>
                        </div>
                        <button type="submit" class="btn btn-success">Gửi Email cho các hội viên đã chọn</button>
                    </div>
                </div>
            </form>
        </div>

        {{-- SCRIPT ĐỂ CHỌN MẪU EMAIL --}}
        <script>
            document.getElementById('select-all').addEventListener('click', function(event) {
                document.querySelectorAll('.member-checkbox').forEach(function(checkbox) {
                    checkbox.checked = event.target.checked;
                });
            });

            document.getElementById('template-selector').addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                if (selectedOption.value) {
                    document.getElementById('subject').value = selectedOption.getAttribute('data-subject');
                    // Nếu dùng Rich Text Editor, bạn cần dùng API của nó để set content
                    document.getElementById('body').value = selectedOption.getAttribute('data-body');
                } else {
                    document.getElementById('subject').value = '';
                    document.getElementById('body').value = '';
                }
            });
        </script>
    @endsection

    @section('customjs')
        <script>
            $(document).ready(function() {
                $('#engagementtables').DataTable({
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
