@extends('admin.index')

@section('title')
    Danh sách thành viên
@endsection

@section('customcss')
    <style>
        /* Custom modal styles */
        .custom-modal .modal-dialog {
            max-width: 700px;
            /* Wider modal */
            width: 90%;
            /* Responsive width */
        }

        .custom-modal .modal-body {
            padding: 15px 20px;
            /* Reduced padding */
        }

        .custom-modal .form-group {
            margin-bottom: 10px;
            /* Reduced spacing between form groups */
        }

        .custom-modal .row {
            margin-left: -5px;
            margin-right: -5px;
        }

        .custom-modal .col-md-6 {
            padding-left: 5px;
            padding-right: 5px;
        }

        /* Compact form controls */
        .custom-modal .form-control {
            padding: 0.375rem 0.75rem;
            height: calc(1.5em + 0.75rem + 2px);
        }

        .custom-modal textarea.form-control {
            height: 60px;
            /* Shorter textarea */
        }

        /* Avatar preview section */
        .custom-modal .avatar-section {
            display: flex;
            align-items: center;
        }

        .custom-modal .avatar-preview {
            margin-right: 15px;
        }

        .custom-modal .avatar-upload {
            flex: 1;
        }
    </style>
@endsection
@section('conten')
    <!-- Page Content  -->


    <div id="content-page" class="content-page">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <div class="iq-card">
                        <div class="iq-card-header d-flex justify-content-between">
                            <div class="iq-header-title">
                                <h4 class="card-title">Danh sách thành viên</h4>
                            </div>
                            <div class="iq-card-header-toolbar d-flex align-items-center">

                                <a href="{{ route('admin.members.create') }}" class="btn btn-primary"> Thêm thành viên</a>
                            </div>
                        </div>
                        <div class="iq-card-body">
                            <!-- Search and Filter Tools -->
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="memberSearch"
                                            placeholder="Tìm kiếm theo tên/SĐT">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex justify-content-end">
                                        <select id="statusFilter" class="form-control">
                                            <option value="">-- Lọc theo trạng thái --</option>
                                            <option value="active">Đang hoạt động</option>
                                            <option value="expired">Hết hạn</option>
                                            <option value="banned">Đã khóa</option>
                                        </select>

                                    </div>
                                </div>
                            </div>

                            <!-- Members Table -->
                            <div class="table-responsive">
                                <table id="member-table" class="table table-striped table-bordered" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th width="5%">ID</th>

                                            <th width="5%">Ảnh</th>
                                            <th width="20%">Họ tên</th>
                                            <th width="10%">SĐT</th>
                                            <th width="25%">Gói tập hiện tại</th>
                                            <th width="15%">Ngày hết hạn</th>
                                            <th width="10%">Mã thẻ</th>
                                            <th width="15%">Trạng thái</th>
                                            <th width="5%">Thao tác</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($results as $result)
                                            <tr>
                                                <td>
                                                    {{ $result['member_id'] }}
                                                </td>
                                                <td>
                                                    <img src="{{ asset($result['img']) }}"
                                                        class="img-fluid rounded-circle avatar-40" alt="image">
                                                </td>
                                                <td>{{ $result['full_name'] }}</td>
                                                <td>{{ $result['phone'] }}</td>
                                                <td>
                                                    @if (!empty($result['plans']))
                                                        @foreach ($result['plans'] as $plan)
                                                            <span class="badge bg-success">{{ $plan }}</span><br>
                                                        @endforeach
                                                    @else
                                                        <span class="text-muted">Chưa đăng ký</span>
                                                    @endif
                                                </td>

                                                <td>
                                                    @if (!empty($result['end_date']) && strtotime($result['end_date']))
                                                        {{ \Carbon\Carbon::parse($result['end_date'])->format('d/m/Y') }}
                                                    @else
                                                        ---
                                                    @endif
                                                </td>


                                                <td>{{ $result['rfid_card_id'] }}</td>
                                                <td data-status="{{ $result['status'] }}">
                                                    <span
                                                        class="badge badge-{{ $result['status'] === 'active' ? 'success' : ($result['status'] === 'expired' ? 'secondary' : 'danger') }}">
                                                        {{ $result['status'] === 'active'
                                                            ? 'Đang hoạt động'
                                                            : ($result['status'] === 'expired'
                                                                ? 'Hết hạn'
                                                                : 'Đã khóa') }}
                                                    </span>
                                                </td>


                                                <td>
                                                    <div class="d-flex align-items-center list-user-action">
                                                        <a class="bg-primary edit-member-btn" data-toggle="modal"
                                                            data-target="#editMemberModal"
                                                            data-id="{{ $result['member_id'] }}"
                                                            data-name="{{ $result['full_name'] }}"
                                                            data-phone="{{ $result['phone'] }}"
                                                            data-email="{{ $result['email'] }}"
                                                            data-image="{{ asset($result['img'] ?? 'images/default.png') }}"
                                                            data-notes="{{ $result['notes'] }}"
                                                            data-rfid="{{ $result['rfid_card_id'] }}"
                                                            data-status="{{ $result['status'] }}">

                                                            <i class="ri-pencil-line"></i>
                                                        </a>



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
    </div>


    @include('admin.pages.member.component.editmember')
@endsection
@section('customjs')
    <script>
        $(document).ready(function() {
            // Initialize DataTable
            var memberTable = $('#member-table').DataTable({
                "language": {
                    "lengthMenu": "Hiển thị _MENU_ thành viên mỗi trang",
                    "zeroRecords": "Không tìm thấy thành viên nào",
                    "info": "Hiển thị trang _PAGE_ của _PAGES_",
                    "infoEmpty": "Không có thành viên nào",
                    "infoFiltered": "(lọc từ _MAX_ thành viên)",
                    "search": "Tìm kiếm:",
                    "paginate": {
                        "first": "Đầu",
                        "last": "Cuối",
                        "next": "Sau",
                        "previous": "Trước"
                    }
                }
            });

            // Custom search functionality
            $('#memberSearch').keyup(function() {
                memberTable.search($(this).val()).draw();
            });

            // Status filter functionality
            $('#statusFilter').change(function() {
                var selectedStatus = $(this).val();

                $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
                    if (!selectedStatus) return true;

                    // Truy cập trực tiếp DOM để lấy data-status thay vì text
                    var row = memberTable.row(dataIndex).node();
                    var rowStatus = $(row).find('td[data-status]').data('status');

                    return rowStatus === selectedStatus;
                });

                memberTable.draw();
                $.fn.dataTable.ext.search.pop(); // Xóa bộ lọc sau mỗi lần draw
            });

            // Initialize tooltips
            $('[data-toggle="tooltip"]').tooltip();

            // Handle file input change for avatar preview in Add Member modal
            $('#memberAvatar').change(function() {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        $('#previewImage').attr('src', e.target.result);
                        $('#avatarPreview').show();
                    }
                    reader.readAsDataURL(file);

                    // Update file input label with filename
                    $(this).next('.custom-file-label').html(file.name);
                }
            });

            // Handle file input change for avatar preview in Edit Member modal
            $('#editMemberAvatar').change(function() {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        $('#editPreviewImage').attr('src', e.target.result);
                        $('#editAvatarPreview').show();
                    }
                    reader.readAsDataURL(file);

                    // Update file input label with filename
                    $(this).next('.custom-file-label').html(file.name);
                }
            });



            // Reset form when Add Member modal is closed
            $('#addMemberModal').on('hidden.bs.modal', function() {
                $('#addMemberForm')[0].reset();
                $('#avatarPreview').hide();
                $('.custom-file-label').html('Chọn ảnh');
            });

            // Populate Edit Member modal with data
            $('#editMemberModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                var id = button.data('id');
                var name = button.data('name');
                var phone = button.data('phone');
                var email = button.data('email');
                var image = button.data('image');

                var modal = $(this);
                modal.find('#editMemberId').val(id);
                modal.find('#editMemberName').val(name);
                modal.find('#editMemberPhone').val(phone);
                modal.find('#editMemberEmail').val(email);
                modal.find('#currentAvatar').attr('src', image);

                // Reset file input and preview
                modal.find('#editMemberAvatar').next('.custom-file-label').html('Thay đổi ảnh');
                modal.find('#editAvatarPreview').hide();
            });

            // Handle update button click in Edit Member modal
            $('#updateMemberBtn').click(function() {
                // Check if required fields are filled
                if ($('#editMemberName').val() && $('#editMemberPhone').val()) {
                    // Here you would normally submit the form data to the server
                    // For demonstration, we'll just show an alert and close the modal
                    alert('Thông tin thành viên đã được cập nhật thành công!');
                    $('#editMemberModal').modal('hide');
                } else {
                    alert('Vui lòng điền đầy đủ thông tin bắt buộc!');
                }
            });
        });
    </script>
@endsection
