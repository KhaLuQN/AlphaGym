@extends('admin.index')
@section('title')
    Đăng ký gói tập
@endsection
@section('conten')
    <div id="content-page" class="content-page">
        <div class="container-fluid">
            <div class="container py-5">
                <div class="row justify-content-center">
                    <div class="col-md-10">
                        <div class="card shadow-lg">
                            <div class="card-header bg-primary text-white">
                                <h3 class="mb-0"><i class="ri-account-pin-box-line"></i> Đăng ký gói tập</h3>
                            </div>

                            <div class="card-body">

                                <form id="registerPackageForm" action="{{ route('admin.subscriptions.store') }}"
                                    method="POST">
                                    @csrf
                                    <!-- Phần chọn hội viên -->
                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label">Hội viên <span
                                                class="text-danger">*</span></label>
                                        <div class="col-md-9">
                                            <select name="member_id" class="form-control select2-member" required>
                                                <option value="">-- Chọn hội viên --</option>
                                                @foreach ($members as $member)
                                                    <option value="{{ $member->member_id }}"
                                                        data-name="{{ strtolower($member->full_name) }}"
                                                        data-phone="{{ $member->phone }}"
                                                        data-rfid="{{ $member->rfid_card_id }}">
                                                        {{ $member->full_name }} - {{ $member->phone }}
                                                        @if ($member->rfid_card_id)
                                                            - RFID: {{ $member->rfid_card_id }}
                                                        @endif
                                                    </option>
                                                @endforeach
                                            </select>
                                            <small class="form-text text-muted">
                                                <i class="ri-information-line"></i>
                                                Có thể tìm kiếm theo tên, số điện thoại hoặc mã thẻ RFID
                                            </small>
                                        </div>
                                    </div>

                                    <!-- Phần chọn gói tập -->
                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label">Gói tập <span
                                                class="text-danger">*</span></label>
                                        <div class="col-md-9">
                                            <div class="row">
                                                @foreach ($packages as $package)
                                                    <div class="col-md-6 mb-3">

                                                        <label for="package-{{ $package->plan_id }}" class="package-label">
                                                            <input type="radio" id="package-{{ $package->plan_id }}"
                                                                name="package_id" value="{{ $package->plan_id }}"
                                                                class="package-radio d-none"
                                                                data-price="{{ $package->price }}"
                                                                data-discount="{{ $package->discount_percent }}"
                                                                data-duration="{{ $package->duration_days }}"
                                                                {{ $loop->first ? 'checked' : '' }}>
                                                            <div
                                                                class="package-card card h-100 {{ $loop->first ? 'selected' : '' }}">
                                                                <div class="card-body">
                                                                    <div class="package-header">
                                                                        <h5 class="text-primary mb-3">
                                                                            <i class="ri-vip-crown-line"></i>
                                                                            {{ $package->plan_name }}
                                                                        </h5>
                                                                    </div>
                                                                    <div class="package-details">
                                                                        <div class="d-flex justify-content-between mb-2">
                                                                            <span><i class="ri-time-line"></i> Thời
                                                                                hạn:</span>
                                                                            <strong>{{ $package->duration_days }}
                                                                                ngày</strong>
                                                                        </div>
                                                                        <div class="d-flex justify-content-between mb-2">
                                                                            <span><i
                                                                                    class="ri-money-dollar-circle-line"></i>
                                                                                Giá gốc:</span>
                                                                            <strong>{{ number_format($package->price) }}đ</strong>
                                                                        </div>
                                                                        @if ($package->discount_percent > 0)
                                                                            <div
                                                                                class="d-flex justify-content-between mb-2 text-success">
                                                                                <span><i
                                                                                        class="ri-discount-percent-line"></i>
                                                                                    Giảm giá:</span>
                                                                                <strong>{{ $package->discount_percent }}%</strong>
                                                                            </div>
                                                                            <hr class="my-2">
                                                                            <div
                                                                                class="d-flex justify-content-between text-danger">
                                                                                <span><strong><i
                                                                                            class="ri-price-tag-3-line"></i>
                                                                                        Thành tiền:</strong></span>
                                                                                <strong class="h6">
                                                                                    {{ number_format($package->price * (1 - $package->discount_percent / 100)) }}đ
                                                                                </strong>
                                                                            </div>
                                                                        @else
                                                                            <hr class="my-2">
                                                                            <div
                                                                                class="d-flex justify-content-between text-primary">
                                                                                <span><strong><i
                                                                                            class="ri-price-tag-3-line"></i>
                                                                                        Thành tiền:</strong></span>
                                                                                <strong
                                                                                    class="h6">{{ number_format($package->price) }}đ</strong>
                                                                            </div>
                                                                        @endif
                                                                    </div>
                                                                    <div class="selected-indicator">
                                                                        <i class="ri-check-line"></i>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Phần thông tin thanh toán -->
                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label">Phương thức TT <span
                                                class="text-danger">*</span></label>
                                        <div class="col-md-9">
                                            <div class="btn-group btn-group-toggle w-100" data-toggle="buttons">
                                                <label class="btn btn-outline-primary active">
                                                    <input type="radio" name="payment_method" value="cash" checked> Tiền
                                                    mặt
                                                </label>
                                                <label class="btn btn-outline-primary">
                                                    <input type="radio" name="payment_method" value="momo"> Chuyển khoản
                                                    momo
                                                </label>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label">Ngày bắt đầu <span
                                                class="text-danger">*</span></label>
                                        <div class="col-md-9">
                                            <input type="date" name="start_date" class="form-control"
                                                value="{{ date('Y-m-d') }}" min="{{ date('Y-m-d') }}" required>
                                        </div>
                                    </div>



                                    <!-- Tóm tắt thanh toán -->
                                    <div class="alert alert-info">
                                        <div class="d-flex justify-content-between">
                                            <h5 class="mb-0">Tổng cộng:</h5>
                                            <h4 class="mb-0 text-danger" id="totalAmount">
                                                {{ number_format($packages[0]->price * (1 - $packages[0]->discount_percent / 100)) }}đ
                                            </h4>
                                        </div>
                                        <hr>
                                        <div class="text-right">
                                            <small class="text-muted">Ngày hết hạn:
                                                <span id="expiryDate">
                                                    {{ date('d/m/Y', strtotime('+' . $packages[0]->duration_days . ' days')) }}
                                                </span>
                                            </small>
                                        </div>
                                    </div>

                                    <div class="form-group row mb-0">
                                        <div class="col-md-9 offset-md-3">
                                            <button type="submit" class="btn btn-primary px-4" id="submitBtn">
                                                <i class="ri-check-line"></i> Xác nhận đăng ký
                                            </button>
                                            <button type="reset" class="btn btn-outline-secondary ml-2">
                                                <i class="ri-eraser-line"></i> Nhập lại
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
    </div>
@endsection

@section('customcss')
    <style>
        .package-label {
            cursor: pointer;
            display: block;
            margin: 0;
        }

        .package-card {
            cursor: pointer;
            transition: all 0.3s ease;
            border: 2px solid #e9ecef;
            position: relative;
            overflow: hidden;
        }

        .package-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(0, 123, 255, 0.15);
            border-color: #007bff;
        }

        .package-card.selected {
            border-color: #007bff !important;
            background: linear-gradient(135deg, #f8f9ff 0%, #e3f2fd 100%);
            box-shadow: 0 4px 15px rgba(0, 123, 255, 0.2);
        }

        .package-radio {
            position: absolute;
            opacity: 0;
            cursor: pointer;
        }

        .selected-indicator {
            position: absolute;
            top: 10px;
            right: 10px;
            width: 25px;
            height: 25px;
            background: #007bff;
            border-radius: 50%;
            display: none;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 14px;
        }

        .package-card.selected .selected-indicator {
            display: flex;
        }

        .package-header {
            text-align: center;
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
            margin-bottom: 15px;
        }

        .package-details {
            position: relative;
        }

        .select2-container--default .select2-selection--single {
            height: 38px;
            padding: 5px;
        }

        .select2-member+.select2-container {
            width: 100% !important;
        }
    </style>
@endsection

@section('customjs')
    <script>
        $(document).ready(function() {
            // Khởi tạo select2 với tùy chọn tìm kiếm nâng cao
            $('.select2-member').select2({
                placeholder: "Tìm hội viên theo tên, SĐT hoặc mã RFID...",
                allowClear: true,
                width: '100%',
                matcher: function(params, data) {
                    // Nếu không có từ khóa tìm kiếm, hiển thị tất cả
                    if ($.trim(params.term) === '') {
                        return data;
                    }

                    // Chuyển từ khóa tìm kiếm về chữ thường
                    var term = params.term.toLowerCase();

                    // Lấy text của option
                    var text = data.text.toLowerCase();

                    // Lấy các data attributes
                    var $option = $(data.element);
                    var name = ($option.data('name') || '').toString().toLowerCase();
                    var phone = ($option.data('phone') || '').toString().toLowerCase();
                    var rfid = ($option.data('rfid') || '').toString().toLowerCase();

                    // Kiểm tra xem từ khóa có khớp với bất kỳ trường nào không
                    if (text.indexOf(term) > -1 ||
                        name.indexOf(term) > -1 ||
                        phone.indexOf(term) > -1 ||
                        rfid.indexOf(term) > -1) {
                        return data;
                    }

                    // Trả về null nếu không khớp
                    return null;
                },
                templateResult: function(data) {
                    if (data.loading) {
                        return data.text;
                    }

                    // Nếu là option mặc định (chưa chọn)
                    if (!data.id) {
                        return data.text;
                    }

                    var $option = $(data.element);
                    var name = $option.text().split(' - ')[0];
                    var phone = $option.data('phone') || '';
                    var rfid = $option.data('rfid') || '';

                    var $result = $('<div>');
                    $result.append('<div class="font-weight-bold">' + name + '</div>');

                    if (phone) {
                        $result.append('<small class="text-muted"><i class="ri-phone-line"></i> ' +
                            phone + '</small>');
                    }

                    if (rfid) {
                        $result.append(
                            '<br><small class="text-info"><i class="ri-bank-card-line"></i> RFID: ' +
                            rfid + '</small>');
                    }

                    return $result;
                },
                templateSelection: function(data) {
                    if (!data.id) {
                        return data.text;
                    }

                    var $option = $(data.element);
                    var name = $option.text().split(' - ')[0];
                    var phone = $option.data('phone') || '';

                    return name + (phone ? ' - ' + phone : '');
                }
            });

            // Xử lý click chọn gói tập
            $('.package-label').click(function(e) {
                e.preventDefault();

                // Bỏ chọn tất cả các gói khác
                $('.package-card').removeClass('selected');
                $('.package-radio').prop('checked', false);

                // Chọn gói hiện tại
                $(this).find('.package-card').addClass('selected');
                $(this).find('.package-radio').prop('checked', true);

                // Trigger change event để cập nhật giá
                $(this).find('.package-radio').trigger('change');
            });

            // Tính toán lại khi chọn gói khác
            $('.package-radio').change(function() {
                const price = $(this).data('price');
                const discount = $(this).data('discount');
                const duration = $(this).data('duration');

                const total = price * (1 - discount / 100);
                $('#totalAmount').text(total.toLocaleString('vi-VN') + 'đ');

                const startDate = $('input[name="start_date"]').val();
                if (startDate) {
                    const expiryDate = new Date(startDate);
                    expiryDate.setDate(expiryDate.getDate() + parseInt(duration));
                    $('#expiryDate').text(expiryDate.toLocaleDateString('vi-VN'));
                }
            });

            // Tính lại ngày hết hạn khi thay đổi ngày bắt đầu
            $('input[name="start_date"]').change(function() {
                const duration = $('.package-radio:checked').data('duration');
                const expiryDate = new Date($(this).val());
                expiryDate.setDate(expiryDate.getDate() + parseInt(duration));
                $('#expiryDate').text(expiryDate.toLocaleDateString('vi-VN'));
            });
        });
    </script>
@endsection
