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
    {{-- Edit Equipment Modal - Improved Version --}}
    <div class="modal fade" id="editEquipmentModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <form id="editEquipmentForm" method="POST" action="{{ route('admin.equipment.update') }}"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-content shadow-lg border-0">
                    {{-- Header --}}
                    <input type="hidden" name="id" id="editEquipmentId">

                    <div class="modal-header bg-gradient-primary text-white border-0">
                        <h5 class="modal-title font-weight-bold">
                            <i class="las la-edit mr-2"></i>Chỉnh sửa thiết bị
                        </h5>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Đóng">
                            <span aria-hidden="true" class="font-weight-light">&times;</span>
                        </button>
                    </div>

                    {{-- Body --}}
                    <div class="modal-body p-4">
                        <div class="row">
                            {{-- Left Column - Image --}}
                            <div class="col-md-4">
                                <div class="card border-light shadow-sm h-100">
                                    <div class="card-header bg-light py-2">
                                        <h6 class="mb-0 text-muted">
                                            <i class="las la-image mr-1"></i>Hình ảnh thiết bị
                                        </h6>
                                    </div>
                                    <div class="card-body text-center">
                                        {{-- Current Image Display --}}
                                        <div class="image-container mb-3">
                                            <!-- Ảnh hiện tại -->
                                            <img id="current-img" src="" alt="Ảnh thiết bị"
                                                class="img-fluid rounded shadow-sm border"
                                                style="max-height: 200px; object-fit: cover; display: none;">


                                        </div>

                                        {{-- Image Upload --}}
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="edit-img" name="img"
                                                accept="image/*">
                                            <label class="custom-file-label" for="edit-img">Chọn ảnh mới...</label>
                                        </div>
                                        <small class="text-muted mt-1 d-block">
                                            <i class="las la-info-circle"></i> JPG, PNG, GIF (tối đa 2MB)
                                        </small>

                                        <div id="image-preview" class="mt-3" style="display: none;">
                                            <img id="preview-img" src="" alt="Xem trước"
                                                class="img-fluid rounded shadow-sm border"
                                                style="max-height: 150px; object-fit: cover;">

                                            <button type="button" class="btn btn-sm btn-outline-danger mt-2"
                                                id="remove-preview">
                                                <i class="las la-times"></i> Hủy
                                            </button>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            {{-- Right Column - Form Fields --}}
                            <div class="col-md-8">
                                <div class="row">
                                    {{-- Equipment Name --}}
                                    <div class="col-md-12 mb-3">
                                        <label for="edit-name" class="form-label font-weight-semibold">
                                            <i class="las la-dumbbell text-primary mr-1"></i>Tên thiết bị
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text bg-light border-right-0">
                                                    <i class="las la-tag text-muted"></i>
                                                </span>
                                            </div>
                                            <input type="text" class="form-control border-left-0" id="edit-name"
                                                name="name" required placeholder="Nhập tên thiết bị">
                                        </div>
                                    </div>

                                    {{-- Purchase Date & Status --}}
                                    <div class="col-md-6 mb-3">
                                        <label for="edit-purchase_date" class="form-label font-weight-semibold">
                                            <i class="las la-calendar text-primary mr-1"></i>Ngày mua
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="date" class="form-control" id="edit-purchase_date"
                                            name="purchase_date" required>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="edit-status" class="form-label font-weight-semibold">
                                            <i class="las la-info-circle text-primary mr-1"></i>Trạng thái
                                            <span class="text-danger">*</span>
                                        </label>
                                        <select class="form-control custom-select" id="edit-status" name="status"
                                            required>
                                            <option value="working">
                                                🟢 Đang hoạt động
                                            </option>
                                            <option value="maintenance">
                                                🟡 Bảo trì
                                            </option>
                                            <option value="broken">
                                                🔴 Hư hỏng
                                            </option>
                                        </select>
                                    </div>

                                    {{-- Location --}}
                                    <div class="col-md-12 mb-3">
                                        <label for="edit-location" class="form-label font-weight-semibold">
                                            <i class="las la-map-marker text-primary mr-1"></i>Vị trí
                                        </label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text bg-light border-right-0">
                                                    <i class="las la-map-pin text-muted"></i>
                                                </span>
                                            </div>
                                            <input type="text" class="form-control border-left-0" id="edit-location"
                                                name="location" placeholder="Vị trí đặt thiết bị">
                                        </div>
                                    </div>

                                    {{-- Notes --}}
                                    <div class="col-md-12 mb-3">
                                        <label for="edit-notes" class="form-label font-weight-semibold">
                                            <i class="las la-sticky-note text-primary mr-1"></i>Ghi chú
                                        </label>
                                        <textarea class="form-control" id="edit-notes" name="notes" rows="3"
                                            placeholder="Thêm ghi chú về thiết bị..."></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Footer --}}
                    <div class="modal-footer bg-light border-0">
                        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">
                            <i class="las la-times mr-1"></i>Hủy bỏ
                        </button>
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="las la-save mr-1"></i>Lưu thay đổi
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
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
