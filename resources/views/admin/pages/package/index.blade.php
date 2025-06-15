@extends('admin.index')

@section('title')
    Danh sách gói tập
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
                                <h4 class="card-title">Danh sách gói tập</h4>
                            </div>

                        </div>
                        <div class="iq-card-body">
                            <! <!-- Members Table -->
                                <div class="table-responsive">
                                    <table id="member-table" class="table table-striped table-bordered" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th width="5%">ID</th>

                                                <th width="20%">Tên gói</th>
                                                <th width="10%">Thời hạn (ngày)</th>
                                                <th width="10%">Giá tiền</th>
                                                <th width="10%">Giảm giá (%)</th>
                                                <th width="10%">Giá sau giảm</th>

                                                <th width="15%">Thao tác</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($packages as $package)
                                                <tr>
                                                    <td>{{ $package->plan_id }}</td>
                                                    <td><strong>{{ $package->plan_name }}</strong></td>
                                                    <td>{{ $package->duration_days }} ngày</td>
                                                    <td>{{ number_format($package->price) }}đ</td>
                                                    <td>
                                                        @if ($package->discount_percent > 0)
                                                            <span
                                                                class="text-success">{{ $package->discount_percent }}%</span>
                                                        @else
                                                            <span class="text-muted">0%</span>
                                                        @endif
                                                    </td>
                                                    <td class="font-weight-bold">
                                                        @php
                                                            $discountedPrice =
                                                                $package->price *
                                                                (1 - $package->discount_percent / 100);
                                                        @endphp
                                                        {{ number_format($discountedPrice) }}đ
                                                    </td>


                                                    <td>
                                                        <div class="d-flex align-items-center list-user-action">
                                                            <a href="#" class="bg-primary edit-package-btn"
                                                                data-toggle="modal" data-target="#editPackageModal"
                                                                data-id="{{ $package->plan_id }}"
                                                                data-name="{{ $package->plan_name }}"
                                                                data-duration="{{ $package->duration_days }}"
                                                                data-price="{{ $package->price }}"
                                                                data-discount="{{ $package->discount_percent }}">
                                                                <i class="ri-pencil-line"></i>
                                                            </a>
                                                            <form
                                                                action="{{ route('admin.package.destroy', $package->plan_id) }}"
                                                                method="POST"
                                                                onsubmit="return confirm('Bạn có chắc chắn muốn xóa gói tập này không?');">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit"
                                                                    class="btn btn-sm bg-danger ml-2 text-white">
                                                                    <i class="ri-delete-bin-line"
                                                                        style="font-size: 1.2rem;"></i>
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
@endsection


<!-- Modal -->
@include('admin.pages.package.component.editpackage')
@section('customjs')
    <script>
        $(document).ready(function() {
            $('.edit-package-btn').on('click', function() {
                const btn = $(this);


                $('#edit-plan-id').val(btn.data('id'));
                $('#edit-plan-name').val(btn.data('name'));
                $('#edit-duration').val(btn.data('duration'));
                $('#edit-price').val(btn.data('price'));
                $('#edit-discount').val(btn.data('discount'));

            });
        });
    </script>
@endsection
