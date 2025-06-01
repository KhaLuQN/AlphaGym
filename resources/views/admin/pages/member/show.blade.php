@extends('admin.index')

@section('conten')
    <div id="content-page" class="content-page">

        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card shadow mb-4">
                        <div
                            class="card-header bg-primary text-white py-3 d-flex justify-content-between align-items-center">
                            <h4 class="m-0 font-weight-bold">
                                <i class="las la-user mr-2"></i> THÔNG TIN THÀNH VIÊN
                            </h4>

                        </div>
                        <div class="card-body">
                            <div class="row">
                                <!-- Thông tin cá nhân -->
                                <div class="col-md-4">
                                    <div class="text-center mb-4">
                                        @if ($member->img)
                                            <img src="{{ asset('storage/' . $member->img) }}"
                                                class="img-thumbnail rounded-circle"
                                                style="width: 150px; height: 150px; object-fit: cover;">
                                        @else
                                            <div class="bg-light rounded-circle d-flex align-items-center justify-content-center"
                                                style="width: 150px; height: 150px; margin: 0 auto;">
                                                <i class="las la-user text-muted fa-4x"></i>
                                            </div>
                                        @endif
                                        <h4 class="mt-3">{{ $member->full_name }}</h4>
                                        <p class="text-muted">
                                            Thành viên từ: {{ \Carbon\Carbon::parse($member->join_date)->format('d/m/Y') }}
                                        </p>

                                    </div>

                                    <div class="card mb-4">
                                        <div class="card-header bg-light">
                                            <h6 class="m-0 font-weight-bold">THÔNG TIN CÁ NHÂN</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="mb-3">
                                                <p class="mb-1"><strong><i class="las la-mobile-alt mr-2"></i>
                                                        SĐT:</strong>
                                                </p>
                                                <p>{{ $member->phone }}</p>
                                            </div>
                                            <div class="mb-3">
                                                <p class="mb-1"><strong><i class="las la-envelope mr-2"></i>
                                                        Email:</strong>
                                                </p>
                                                <p>{{ $member->email ?? 'Chưa có' }}</p>
                                            </div>
                                            <div class="mb-3">
                                                <p class="mb-1"><strong><i class="las la-id-card mr-2"></i> Mã thẻ
                                                        RFID:</strong></p>
                                                <p>{{ $member->rfid_card_id ?? 'Chưa có' }}</p>
                                            </div>
                                            <div>
                                                <p class="mb-1"><strong><i class="las la-info-circle mr-2"></i> Trạng
                                                        thái:</strong></p>
                                                <span
                                                    class="badge badge-{{ $member->status == 'active' ? 'success' : 'danger' }}">
                                                    {{ $member->status == 'active' ? 'Đang hoạt động' : 'Đã khóa' }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Thống kê và lịch sử -->
                                <div class="col-md-8">
                                    <div class="row mb-4">
                                        <div class="col-md-4">
                                            <div class="info-box bg-info text-white">
                                                <div class="info-box-content text-center p-3">
                                                    <span class="info-box-text">Tổng lượt check-in</span>
                                                    <span class="info-box-number">{{ $totalCheckins }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="info-box bg-success text-white">
                                                <div class="info-box-content text-center p-3">
                                                    <span class="info-box-text">Check-in tháng này</span>
                                                    <span class="info-box-number">{{ $lastMonthCheckins }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="info-box bg-warning text-white">
                                                <div class="info-box-content text-center p-3">
                                                    <span class="info-box-text">Thời gian tập TB</span>
                                                    <span class="info-box-number">
                                                        @if ($avgSessionTime)
                                                            {{ $avgSessionTime['hours'] }}h
                                                            {{ $avgSessionTime['minutes'] }}m
                                                        @else
                                                            Chưa có dữ liệu
                                                        @endif
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card mb-4">
                                        <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                            <h6 class="m-0 font-weight-bold">LỊCH SỬ CHECK-IN GẦN ĐÂY</h6>
                                            <a href="{{ route('admin.checkin.index') }}?member_id={{ $member->member_id }}"
                                                class="btn btn-sm btn-primary">
                                                <i class="las la-history mr-1"></i> Xem tất cả
                                            </a>
                                        </div>
                                        <div class="card-body p-0">
                                            <div class="table-responsive">
                                                <table id="checkin-history-table" class="table table-hover mb-0">

                                                    <thead>
                                                        <tr>
                                                            <th>Thời gian</th>
                                                            <th>Trạng thái</th>
                                                            <th>Thời gian tập</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @forelse($member->checkins as $checkin)
                                                            <tr>
                                                                <td>
                                                                    <div class="font-weight-bold">
                                                                        {{ $checkin->checkin_time->format('H:i d/m/Y') }}
                                                                    </div>
                                                                    @if ($checkin->checkout_time)
                                                                        <small class="text-muted">
                                                                            Check-out:
                                                                            {{ $checkin->checkout_time->format('H:i d/m/Y') }}
                                                                        </small>
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    @if ($checkin->checkout_time)
                                                                        <span class="badge badge-success">
                                                                            <i class="las la-check-circle"></i> Hoàn thành
                                                                        </span>
                                                                    @else
                                                                        <span class="badge badge-warning">
                                                                            <i class="las la-dumbbell"></i> Đang tập
                                                                        </span>
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    @if ($checkin->checkout_time)
                                                                        @php
                                                                            $diff = $checkin->checkin_time->diff(
                                                                                $checkin->checkout_time,
                                                                            );
                                                                            $hours = $diff->h + $diff->days * 24;
                                                                            $minutes = $diff->i;
                                                                        @endphp
                                                                        @if ($hours > 0)
                                                                            {{ $hours }}h {{ $minutes }}m
                                                                        @else
                                                                            {{ $minutes }}m
                                                                        @endif
                                                                    @else
                                                                        --
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                        @empty
                                                            <tr>
                                                                <td colspan="3" class="text-center py-4">Chưa có lịch sử
                                                                    check-in</td>
                                                            </tr>
                                                        @endforelse
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Ghi chú -->
                                    <div class="card">
                                        <div class="card-header bg-light">
                                            <h6 class="m-0 font-weight-bold">GHI CHÚ</h6>
                                        </div>
                                        <div class="card-body">
                                            @if ($member->notes)
                                                <p>{{ $member->notes }}</p>
                                            @else
                                                <p class="text-muted">Không có ghi chú</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
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
        .info-box {
            border-radius: 0.5rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            height: 100%;
        }

        .info-box-content {
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .info-box-text {
            font-size: 0.9rem;
            margin-bottom: 0.25rem;
        }

        .info-box-number {
            font-size: 1.5rem;
            font-weight: bold;
        }

        .badge {
            font-size: 0.85rem;
            padding: 0.5em 0.75em;
        }

        .table th {
            white-space: nowrap;
        }
    </style>
@endsection


@section('customjs')
    <script>
        $(document).ready(function() {
            $('#checkin-history-table').DataTable({
                pageLength: 5,
                "language": {
                    "lengthMenu": "Hiển thị _MENU_ dòng mỗi trang",
                    "zeroRecords": "Không có dữ liệu",
                    "info": "Hiển thị _START_ đến _END_ của _TOTAL_ dòng",
                    "infoEmpty": "Không có dữ liệu phù hợp",
                    "infoFiltered": "(lọc từ _MAX_ dòng)",
                    "search": "Tìm kiếm:",
                    "paginate": {
                        "first": "Đầu",
                        "last": "Cuối",
                        "next": "Sau",
                        "previous": "Trước"
                    }
                }
            });
        });
    </script>
@endsection
