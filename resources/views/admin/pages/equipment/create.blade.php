@extends('admin.index')

@section('conten')
    <div id="content-page" class="content-page">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card shadow mb-4">
                        <div class="card-header bg-primary text-white py-3">
                            <h4 class="m-0 font-weight-bold">
                                <i class="las la-dumbbell mr-2"></i> THÊM THIẾT BỊ MỚI
                            </h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.equipment.store') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf

                                <div class="row">
                                    <!-- Cột trái - Thông tin cơ bản -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name" class="font-weight-bold">Tên thiết bị <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control form-control-lg" id="name"
                                                name="name" value="{{ old('name') }}" required>
                                            @error('name')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="purchase_date" class="font-weight-bold">Ngày mua <span
                                                    class="text-danger">*</span></label>
                                            <input type="date" class="form-control form-control-lg" id="purchase_date"
                                                name="purchase_date" value="{{ old('purchase_date') }}" required>
                                            @error('purchase_date')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="status" class="font-weight-bold">Trạng thái <span
                                                    class="text-danger">*</span></label>
                                            <select class="form-control form-control-lg" id="status" name="status"
                                                required>
                                                <option value="working" {{ old('status') == 'working' ? 'selected' : '' }}>
                                                    Đang
                                                    hoạt động</option>
                                                <option value="maintenance"
                                                    {{ old('status') == 'maintenance' ? 'selected' : '' }}>Bảo trì</option>
                                                <option value="broken" {{ old('status') == 'broken' ? 'selected' : '' }}>Hư
                                                    hỏng
                                                </option>
                                            </select>

                                        </div>
                                    </div>

                                    <!-- Cột phải - Ảnh và thông tin bổ sung -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="font-weight-bold">Hình ảnh thiết bị</label>
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="img"
                                                    name="img" accept="image/*">
                                                <label class="custom-file-label" for="img">Chọn hình ảnh...</label>
                                            </div>
                                            <small class="text-muted">Ảnh JPG/PNG, tối đa 2MB</small>

                                            <!-- Ảnh xem trước -->
                                            <div class="mt-3">
                                                <img id="img-preview" src="#" alt="Ảnh xem trước"
                                                    class="img-thumbnail d-none" style="max-width: 300px;">
                                            </div>
                                        </div>


                                        <div class="form-group">
                                            <label for="location" class="font-weight-bold">Vị trí đặt thiết bị</label>
                                            <input type="text" class="form-control form-control-lg" id="location"
                                                name="location" value="{{ old('location') }}">

                                        </div>

                                        <div class="form-group">
                                            <label for="notes" class="font-weight-bold">Ghi chú</label>
                                            <textarea class="form-control" id="notes" name="notes" rows="3">{{ old('notes') }}</textarea>

                                        </div>
                                    </div>
                                </div>

                                <div class="row mt-4">
                                    <div class="col-12 text-right">
                                        <a href="{{ route('admin.equipment.index') }}" class="btn btn-secondary mr-2">
                                            <i class="las la-times mr-1"></i> Hủy bỏ
                                        </a>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="las la-save mr-1"></i> Lưu thiết bị
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('customcss')
    <style>
        .form-control-lg {
            height: calc(2.5em + 1rem + 2px);
            padding: 0.5rem 1rem;
            font-size: 1.1rem;
        }

        .custom-file-label::after {
            content: "Duyệt";
        }

        .card {
            border-radius: 0.5rem;
        }

        .card-header {
            border-radius: 0.5rem 0.5rem 0 0 !important;
        }

        .btn {
            border-radius: 0.25rem;
        }
    </style>
@endsection
@section('customjs')
    <script>
        $(document).ready(function() {
            $('#img').on('change', function(e) {
                const file = e.target.files[0];

                if (file) {
                    const reader = new FileReader();

                    reader.onload = function(e) {
                        $('#img-preview')
                            .attr('src', e.target.result)
                            .removeClass('d-none'); // Hiện ảnh
                    };

                    reader.readAsDataURL(file);

                    // Cập nhật tên file hiển thị
                    $(this).next('.custom-file-label').html(file.name);
                }
            });
        });
    </script>
@endsection
