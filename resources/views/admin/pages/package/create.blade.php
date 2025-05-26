@extends('admin.index')

@section('title')
    Thêm Gói tập
@endsection
@section('conten')
    <div id="content-page" class="content-page">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card shadow mb-4">
                        <div class="card-header bg-primary text-white py-3">
                            <h4 class="m-0 font-weight-bold">
                                <i class="las la-plus-circle"></i> THÊM GÓI TẬP
                            </h4>
                        </div>
                        <div class="card-body">
                            <form id="addPackageForm" method="POST" action="{{ route('admin.package.store') }}"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6 border-right pr-3">
                                        <div class="form-group">
                                            <label for="plan_name" class="font-weight-bold">Tên gói tập <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" name="plan_name" class="form-control" id="plan_name"
                                                placeholder="Nhập tên gói tập" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="duration_days" class="font-weight-bold">Số ngày hiệu lực <span
                                                    class="text-danger">*</span></label>
                                            <input type="number" name="duration_days" class="form-control"
                                                id="duration_days" placeholder="VD: 30" required min="1">
                                        </div>

                                        <div class="form-group">
                                            <label for="price" class="font-weight-bold">Giá tiền (VNĐ) <span
                                                    class="text-danger">*</span></label>
                                            <input type="number" name="price" class="form-control" id="price"
                                                placeholder="VD: 500000" required min="0">
                                        </div>

                                        <div class="form-group">
                                            <label for="discount_percent" class="font-weight-bold">Phần trăm giảm giá
                                                (%)</label>
                                            <input type="number" name="discount_percent" class="form-control"
                                                id="discount_percent" placeholder="VD: 10" min="0" max="100">
                                        </div>
                                    </div>
                                </div>

                                <div class="row mt-4">
                                    <div class="col-12 text-right">
                                        <a href="{{ route('admin.package.index') }}" class="btn btn-secondary mr-2">
                                            <i class="las la-times mr-1"></i> Hủy bỏ
                                        </a>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="las la-save mr-1"></i> Lưu thông tin
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div> <!-- card-body -->
                    </div> <!-- card -->
                </div>
            </div>
        </div>
    </div>
@endsection
