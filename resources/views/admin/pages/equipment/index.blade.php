@extends('admin.index')
@section('title')
    Tất cả thiết bị
@endsection
@section('conten')
    <div id="content-page" class="content-page">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card shadow mb-4">
                        <div
                            class="card-header bg-primary text-white py-3 d-flex justify-content-between align-items-center">
                            <h4 class="m-0 font-weight-bold">
                                <i class="las la-dumbbell mr-2"></i> QUẢN LÝ THIẾT BỊ PHÒNG GYM
                            </h4>
                            <a href="{{ route('admin.equipment.create') }}" class="btn btn-light">
                                <i class="las la-plus mr-1"></i> Thêm thiết bị mới
                            </a>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover" id="equipmentTable" width="100%"
                                    cellspacing="0">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>Hình ảnh</th>
                                            <th>Tên thiết bị</th>
                                            <th>Ngày mua</th>
                                            <th>Trạng thái</th>
                                            <th>Vị trí</th>
                                            <th>Hành động</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($equipments as $equipment)
                                            <tr>
                                                <td class="text-center">
                                                    @if ($equipment->img)
                                                        <img src="{{ asset($equipment->img) }}" alt="{{ $equipment->name }}"
                                                            class="img-thumbnail"
                                                            style="width: 80px; height: 80px; object-fit: cover;">
                                                    @else
                                                        <div class="bg-light d-flex align-items-center justify-content-center"
                                                            style="width: 80px; height: 80px;">
                                                            <i class="las la-dumbbell fa-2x text-muted"></i>
                                                        </div>
                                                    @endif
                                                </td>
                                                <td>{{ $equipment->name }}</td>
                                                <td>{{ $equipment->purchase_date->format('d/m/Y') }}</td>
                                                <td>
                                                    @if ($equipment->status == 'working')
                                                        <span class="badge badge-success">
                                                            <i class="las la-check-circle mr-1"></i> Đang hoạt động
                                                        </span>
                                                    @elseif($equipment->status == 'maintenance')
                                                        <span class="badge badge-warning">
                                                            <i class="las la-tools mr-1"></i> Bảo trì
                                                        </span>
                                                    @else
                                                        <span class="badge badge-danger">
                                                            <i class="las la-times-circle mr-1"></i> Hư hỏng
                                                        </span>
                                                    @endif
                                                </td>
                                                <td>{{ $equipment->location ?? 'Chưa xác định' }}</td>
                                                <td>
                                                    <div class="btn-group btn-group-sm">
                                                        <button type="button"
                                                            class="btn btn-primary btn-edit-equipment btn-sm" title="Sửa"
                                                            data-id="{{ $equipment->id }}"
                                                            data-name="{{ $equipment->name }}"
                                                            data-purchase_date="{{ $equipment->purchase_date->format('Y-m-d') }}"
                                                            data-status="{{ $equipment->status }}"
                                                            data-location="{{ $equipment->location }}"
                                                            data-notes="{{ $equipment->notes }}"
                                                            data-img="{{ $equipment->img ? asset($equipment->img) : '' }}"
                                                            title="Sửa">

                                                            <i class="las la-edit"></i>
                                                        </button>


                                                        <!-- Form xóa riêng cho mỗi thiết bị -->
                                                        <form
                                                            action="{{ route('admin.equipment.destroy', $equipment->id) }}"
                                                            method="POST" style="display:inline-block;"
                                                            onsubmit="return confirm('Bạn có chắc chắn muốn xóa thiết bị này?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger" title="Xóa">
                                                                <i class="las la-trash"></i>
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
    </div>
    @include('admin.pages.equipment.component.edit')
@endsection

@section('customcss')
    <style>
        .badge {
            font-size: 0.85rem;
            font-weight: 500;
            padding: 0.5em 0.75em;
            border-radius: 0.25rem;
        }

        .table th {
            white-space: nowrap;
            vertical-align: middle;
        }

        .btn-sm {
            padding: 0.25rem 0.5rem;
            font-size: 0.75rem;
        }

        .img-thumbnail {
            border-radius: 0.25rem;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        }

        .modal-lg {
            max-width: 900px;
        }

        .bg-gradient-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .form-label {
            font-size: 0.9rem;
            margin-bottom: 0.5rem;
        }

        .input-group-text {
            background-color: #f8f9fc;
            border-color: #e3e6f0;
        }

        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }

        .custom-file-label {
            font-size: 0.875rem;
        }

        .image-container {
            position: relative;
        }

        #current-img,
        #preview-img {
            transition: all 0.3s ease;
            border: 2px solid #e3e6f0;
        }

        #current-img:hover,
        #preview-img:hover {
            transform: scale(1.05);
            border-color: #667eea;
        }

        .card {
            transition: all 0.3s ease;
        }

        .btn {
            border-radius: 0.35rem;
            font-weight: 500;
        }

        .text-danger {
            color: #e74a3b !important;
        }

        .modal-content {
            border-radius: 0.5rem;
        }
    </style>
@endsection

@section('customjs')
    <script>
        $(document).ready(function() {
            // Khởi tạo DataTable (giữ nguyên)
            $('#equipmentTable').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.25/i18n/Vietnamese.json"
                },
                "columnDefs": [{
                        "orderable": false,
                        "targets": [0, 5]
                    },
                    {
                        "searchable": false,
                        "targets": [0, 5]
                    }
                ]
            });


            $('.btn-edit-equipment').click(function() {
                const button = $(this);

                // Lấy dữ liệu từ data attributes
                const id = button.data('id');
                const name = button.data('name');
                const purchaseDate = button.data('purchase_date');
                const status = button.data('status');
                const location = button.data('location');
                const notes = button.data('notes');
                const imgUrl = $(this).data('img');
                // Gán dữ liệu vào form trong modal
                $('#edit-id').val(id);
                $('#edit-name').val(name);
                $('#edit-purchase_date').val(purchaseDate);
                $('#edit-status').val(status);
                $('#edit-location').val(location);
                $('#edit-notes').val(notes);
                if (imgUrl) {
                    $('#current-img').attr('src', imgUrl).show();
                    $('#no-image-placeholder').hide();
                } else {
                    $('#current-img').hide();
                    $('#no-image-placeholder').show();
                }
                $('#edit-img').val('');
                $('#image-preview').hide();
                $('.custom-file-label').html('Chọn ảnh mới...');
                // Hiện modal
                $('#editEquipmentModal').modal('show');
            });

            $('#edit-img').on('change', function() {
                const file = this.files[0];

                if (file) {
                    // Cập nhật tên file (nếu có custom label)
                    $(this).next('.custom-file-label').html(file.name);

                    const reader = new FileReader();

                    reader.onload = function(e) {
                        $('#preview-img').attr('src', e.target.result);
                        $('#image-preview').show(); // Chỉ hiển thị ảnh mới, không ảnh hưởng ảnh cũ
                    };

                    reader.readAsDataURL(file);
                } else {
                    // Không chọn file
                    $(this).next('.custom-file-label').html('Chọn ảnh mới...');
                    $('#image-preview').hide();
                }
            });

            // Hủy xem trước ảnh mới
            $('#remove-preview').click(function() {
                $('#edit-img').val('');
                $('.custom-file-label').html('Chọn ảnh mới...');
                $('#image-preview').hide();
            });
        });
    </script>
@endsection
