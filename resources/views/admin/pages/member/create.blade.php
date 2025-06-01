@extends('admin.index')

@section('title')
    Thêm khách hàng
@endsection
@section('conten')
    <div id="content-page" class="content-page">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card shadow mb-4">
                        <div class="card-header bg-primary text-white py-3">
                            <h4 class="m-0 font-weight-bold">
                                <i class="las la-user-plus mr-2"></i>THÊM THÀNH VIÊN MỚI
                            </h4>
                        </div>
                        <div class="card-body">
                            <form id="addMemberForm" method="POST" action="{{ route('admin.members.store') }}"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <!-- Left Column - Personal Info -->
                                    <div class="col-md-6 border-right pr-3">
                                        <div class="form-group">
                                            <label for="memberName" class="font-weight-bold">Họ tên <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" name="full_name" class="form-control form-control-lg"
                                                id="memberName" placeholder="Nhập họ tên đầy đủ" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="memberPhone" class="font-weight-bold">Số điện thoại <span
                                                    class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="las la-mobile-alt"></i></span>
                                                </div>
                                                <input type="tel" name="phone" class="form-control form-control-lg"
                                                    id="memberPhone" placeholder="Nhập số điện thoại" required>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="memberEmail" class="font-weight-bold">Email</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="las la-envelope"></i></span>
                                                </div>
                                                <input type="email" name="email" class="form-control form-control-lg"
                                                    id="memberEmail" placeholder="Nhập email (nếu có)">
                                            </div>
                                        </div>



                                        <!-- Notes Section -->
                                        <div class="form-group mt-2">
                                            <label for="memberNotes" class="font-weight-bold">Ghi chú</label>
                                            <textarea class="form-control" id="memberNotes" name="notes" rows="2" placeholder="Nhập ghi chú (nếu cần)"></textarea>
                                        </div>
                                    </div>

                                    <!-- Right Column - Avatar & RFID -->
                                    <div class="col-md-6 pl-3">
                                        <!-- Avatar Section -->
                                        <div class="form-group">
                                            <label class="font-weight-bold">Ảnh đại diện</label>
                                            <div class="avatar-upload-box text-center p-3 border rounded mb-3">
                                                <div class="avatar-preview mb-2" id="avatarPreview" style="display: none;">
                                                    <img id="previewImage" src="#" alt="Avatar Preview"
                                                        class="img-thumbnail rounded-circle shadow-sm"
                                                        style="width: 120px; height: 120px; object-fit: cover;">
                                                </div>
                                                <div class="avatar-placeholder" id="avatarPlaceholder"
                                                    style="width: 120px; height: 120px; margin: 0 auto 15px; display: flex; align-items: center; justify-content: center; background-color: #f8f9fa; border-radius: 50%;">
                                                    <i class="las la-user fa-3x text-muted"></i>
                                                </div>
                                                <div class="custom-file w-auto d-inline-block">
                                                    <input type="file" class="custom-file-input" id="memberAvatar"
                                                        name="img" accept="image/*">
                                                    <label class="btn btn-outline-primary" for="memberAvatar">
                                                        <i class="las la-file-upload mr-2"></i>Chọn ảnh
                                                    </label>
                                                    <small class="form-text text-muted d-block mt-1">Ảnh JPG/PNG, tối đa
                                                        2MB</small>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- RFID Section -->
                                        <div class="form-group">
                                            <label class="font-weight-bold">Thẻ RFID</label>
                                            <div class="card border-primary">
                                                <div class="card-header bg-light py-2">
                                                    <h6 class="mb-0 font-weight-bold"><i
                                                            class="las la-id-card mr-2"></i>QUÉT
                                                        THẺ</h6>
                                                </div>
                                                <div class="card-body p-3">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" name="rfid_card_id"
                                                            id="memberRfid" placeholder="Quét thẻ RFID" readonly>
                                                        <div class="input-group-append">
                                                            <button class="btn btn-primary" type="button"
                                                                id="scanRfidBtn">
                                                                <i class="las la-rss mr-1"></i> Quét
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <small class="text-muted">Nhấn nút quét và đưa thẻ vào đầu đọc</small>
                                                </div>
                                            </div>
                                        </div>


                                    </div>
                                </div>

                                <div class="row mt-4">
                                    <div class="col-12 text-right">
                                        <a href="{{ route('admin.members.index') }}" class="btn btn-secondary mr-2">
                                            <i class="las la-times mr-1"></i> Hủy bỏ
                                        </a>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="las la-save mr-1"></i> Lưu thông tin
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

@section('customjs')
    <script>
        // Xử lý hiển thị ảnh preview khi chọn file
        document.getElementById('memberAvatar').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    document.getElementById('previewImage').src = event.target.result;
                    document.getElementById('avatarPreview').style.display = 'block';
                    document.getElementById('avatarPlaceholder').style.display = 'none';
                };
                reader.readAsDataURL(file);
            }
        });

        // Xử lý quét thẻ RFID
        let isScanning = false;
        document.getElementById('scanRfidBtn').addEventListener('click', function() {
            isScanning = true;
            const rfidInput = document.getElementById('memberRfid');
            rfidInput.placeholder = 'Đang chờ quét thẻ...';
            this.innerHTML = '<i class="las la-circle-notch la-spin mr-1"></i> Đang quét';
            this.disabled = true;

            // Timeout sau 30 giây nếu không quét được
            setTimeout(() => {
                if (isScanning) {
                    isScanning = false;
                    rfidInput.placeholder = 'Quét thẻ RFID';
                    this.innerHTML = '<i class="las la-rss mr-1"></i> Quét';
                    this.disabled = false;
                    alert('Không nhận được tín hiệu thẻ. Vui lòng thử lại.');
                }
            }, 30000);
        });

        // Giả lập nhận tín hiệu từ đầu đọc RFID (bàn phím)
        document.addEventListener('keypress', function(e) {
            if (isScanning) {
                const rfidInput = document.getElementById('memberRfid');

                // Giả sử kết thúc bằng Enter (có thể điều chỉnh theo thiết bị thực tế)
                if (e.key === 'Enter') {
                    isScanning = false;
                    document.getElementById('scanRfidBtn').innerHTML = '<i class="las la-rss mr-1"></i> Quét';
                    document.getElementById('scanRfidBtn').disabled = false;

                    // Xử lý dữ liệu thẻ ở đây (có thể validate hoặc gửi AJAX kiểm tra)
                    console.log('RFID scanned:', rfidInput.value);
                } else {
                    // Thêm ký tự vào input
                    rfidInput.value += e.key;
                }
            }
        });

        // Xử lý khi trang được tải
        document.addEventListener('DOMContentLoaded', function() {
            // Focus vào trường họ tên khi trang load
            document.getElementById('memberName').focus();

            // Validate form trước khi submit
            document.getElementById('addMemberForm').addEventListener('submit', function(e) {
                const phone = document.getElementById('memberPhone').value;
                if (!/^\d{10,15}$/.test(phone)) {
                    e.preventDefault();
                    alert('Số điện thoại không hợp lệ. Vui lòng nhập từ 10-15 chữ số.');
                    document.getElementById('memberPhone').focus();
                }
            });
        });
    </script>

    <style>
        .avatar-upload-box {
            transition: all 0.3s ease;
        }

        .custom-file-input:focus~.custom-file-label {
            box-shadow: none;
            border-color: #80bdff;
        }

        .border-right {
            border-right: 1px solid #dee2e6 !important;
        }

        .custom-radio .custom-control-label::before {
            border-radius: 50%;
        }

        .package-option {
            border-left: 3px solid #4e73df;
            padding-left: 10px;
            margin-bottom: 10px;
        }
    </style>
@endsection
