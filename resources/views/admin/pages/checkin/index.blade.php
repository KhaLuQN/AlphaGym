@extends('admin.index')

@section('conten')
    <div id="content-page" class="content-page">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card shadow mb-4">
                        <div class="card-header bg-primary text-white py-3">
                            <h4 class="m-0 font-weight-bold">
                                <i class="las la-user-clock mr-2"></i> LỊCH SỬ CHECK-IN THÀNH VIÊN
                            </h4>
                        </div>
                        <div class="card-body">
                            <!-- Filter Section -->
                            <form method="GET" action="{{ route('admin.checkin.index') }}">
                                <div class="row mb-4">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="startDate" class="font-weight-bold">Ngày bắt đầu</label>
                                            <input type="date" class="form-control" id="startDate" name="start_date"
                                                value="{{ request('start_date') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="endDate" class="font-weight-bold">Ngày kết thúc</label>
                                            <input type="date" class="form-control" id="endDate" name="end_date"
                                                value="{{ request('end_date') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6 d-flex align-items-end">
                                        <button class="btn btn-primary mr-2" type="submit">
                                            <i class="las la-filter mr-1"></i> Lọc
                                        </button>
                                        <a href="{{ route('admin.checkin.index') }}" class="btn btn-secondary mr-2">
                                            <i class="las la-redo mr-1"></i> Reset
                                        </a>
                                        <button class="btn btn-success mr-2" type="button">
                                            <i class="las la-file-excel mr-1"></i> Xuất Excel
                                        </button>
                                        <button class="btn btn-info" type="submit">
                                            <i class="las la-sync mr-1"></i> Làm mới
                                        </button>


                                    </div>
                                </div>
                            </form>

                            <!-- Loading indicator -->
                            <div id="loadingIndicator" class="text-center" style="display: none;">
                                <div class="spinner-border text-primary" role="status">
                                    <span class="sr-only">Đang tải...</span>
                                </div>
                                <p class="mt-2">Đang tải dữ liệu...</p>
                            </div>

                            <!-- Statistics -->
                            <div class="row mb-3" id="statsRow">
                                <div class="col-md-3">
                                    <div class="info-box bg-info">
                                        <div class="info-box-content text-white text-center p-3">
                                            <span class="info-box-text">Tổng lượt check-in</span>
                                            <span class="info-box-number" id="totalCheckins">{{ $checkins->total() }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="info-box bg-success">
                                        <div class="info-box-content text-white text-center p-3">
                                            <span class="info-box-text">Đã check-out</span>
                                            <span class="info-box-number" id="totalCheckouts">
                                                {{ $checkins->where('checkout_time', '!=', null)->count() }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="info-box bg-warning">
                                        <div class="info-box-content text-white text-center p-3">
                                            <span class="info-box-text">Đang tập</span>
                                            <span class="info-box-number" id="activeMembers">
                                                {{ $checkins->where('checkout_time', null)->count() }}
                                            </span>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <!-- Table -->
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover" id="checkinTable" width="100%"
                                    cellspacing="0">
                                    <thead class="thead-light">
                                        <tr>
                                            <th width="5%">STT</th>
                                            <th width="20%">Thành viên</th>
                                            <th width="15%">Mã thẻ</th>
                                            <th width="15%">Check-in</th>
                                            <th width="15%">Check-out</th>
                                            <th width="15%">Thời gian tập</th>
                                            <th width="15%">Hành động</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tableBody">
                                        @foreach ($checkins as $index => $checkin)
                                            <tr>
                                                <td>{{ ($checkins->currentPage() - 1) * $checkins->perPage() + $index + 1 }}
                                                </td>
                                                <td>
                                                    @if ($checkin->member)
                                                        <a href="{{ route('admin.members.show', $checkin->member_id) }}"
                                                            class="text-primary font-weight-bold">
                                                            {{ $checkin->member->full_name }}
                                                        </a>
                                                    @else
                                                        <span class="text-muted font-italic">Thành viên đã xóa</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <span class="badge badge-secondary">{{ $checkin->rfid_card_id }}</span>
                                                </td>
                                                <td>
                                                    <span class="text-info">
                                                        {{ \Carbon\Carbon::parse($checkin->checkin_time)->format('H:i d/m/Y') }}

                                                    </span>
                                                </td>
                                                <td>
                                                    @if ($checkin->checkout_time)
                                                        <span class="text-success">
                                                            {{ \Carbon\Carbon::parse($checkin->checkin_time)->format('H:i d/m/Y') }}

                                                        </span>
                                                    @else
                                                        <span class="badge badge-warning">
                                                            <i class="las la-dumbbell mr-1"></i>Đang tập
                                                        </span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($checkin->checkout_time)
                                                        @php
                                                            $checkinTime = \Carbon\Carbon::parse(
                                                                $checkin->checkin_time,
                                                            );
                                                            $checkoutTime = \Carbon\Carbon::parse(
                                                                $checkin->checkout_time,
                                                            );

                                                            $diff = $checkinTime->diff($checkoutTime);
                                                            $hours = $diff->h + $diff->days * 24;
                                                            $minutes = $diff->i;
                                                        @endphp
                                                        <span class="badge badge-info">
                                                            @if ($hours > 0)
                                                                {{ $hours }}h {{ $minutes }}m
                                                            @else
                                                                {{ $minutes }}m
                                                            @endif
                                                        </span>
                                                    @else
                                                        <span class="text-muted">--</span>
                                                    @endif
                                                </td>


                                                <td>
                                                    @if (!$checkin->checkout_time)
                                                        <form
                                                            action="{{ route('admin.checkin.forceCheckout', $checkin->checkin_id) }}"
                                                            method="POST" style="display:inline;"
                                                            id="forceCheckoutForm-{{ $checkin->checkin_id }}">
                                                            @csrf

                                                            <button type="submit" class="btn btn-sm btn-success"
                                                                title="Force Check-out"
                                                                onclick="return confirm('Bạn có chắc chắn muốn check-out cho thành viên này?');">
                                                                <i class="las la-door-open mr-1"></i> Check-out
                                                            </button>
                                                        </form>
                                                    @else
                                                        <span class="text-muted">--</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <form action="{{ route('admin.checkin.forceCheckoutAll') }}" method="POST"
                                class="d-inline">
                                @csrf
                                <button type="submit " class="btn btn-danger ml-2"
                                    onclick="return confirm('Bạn có chắc chắn muốn check-out tất cả thành viên đang tập không?');">
                                    <i class="las la-door-open"></i> Check-out tất cả
                                </button>
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
        .badge {
            font-size: 0.85rem;
            font-weight: 500;
            padding: 0.35em 0.65em;
        }

        .table th {
            white-space: nowrap;
            background-color: #f8f9fa;
            font-weight: 600;
        }

        .btn-sm {
            padding: 0.25rem 0.5rem;
            font-size: 0.75rem;
        }

        .info-box {
            border-radius: 0.5rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .spinner-border {
            width: 3rem;
            height: 3rem;
        }

        .table-responsive {
            border-radius: 0.5rem;
        }

        .force-checkout:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
        }

        .alert {
            border-radius: 0.5rem;
            margin-bottom: 0;
            margin-top: 1rem;
        }

        #loadingIndicator {
            padding: 3rem 0;
        }
    </style>
@endsection
