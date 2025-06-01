{{-- Edit Equipment Modal - Improved Version --}}
<div class="modal fade" id="editEquipmentModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <form id="editEquipmentForm" method="POST" action="{{ route('admin.equipment.update') }}"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="modal-content shadow-lg border-0">
                {{-- Header --}}
                <input type="hidden" name="id" id="edit-id">

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
                                    <select class="form-control custom-select" id="edit-status" name="status" required>
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
