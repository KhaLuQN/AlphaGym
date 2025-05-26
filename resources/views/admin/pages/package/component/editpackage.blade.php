<div class="modal fade" id="editPackageModal" tabindex="-1" role="dialog" aria-labelledby="editPackageLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form id="editPackageForm" action="{{ route('admin.package.update') }}" method="POST">
            @csrf

            <input type="hidden" name="plan_id" id="edit-plan-id">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Sửa gói tập</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Đóng">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <label>Tên gói</label>
                        <input type="text" name="plan_name" id="edit-plan-name" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Thời hạn (ngày)</label>
                        <input type="number" name="duration_days" id="edit-duration" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Giá (VND)</label>
                        <input type="number" name="price" id="edit-price" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Giảm giá (%)</label>
                        <input type="number" name="discount_percent" id="edit-discount" class="form-control">
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Cập nhật</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                </div>
            </div>
        </form>
    </div>
</div>
