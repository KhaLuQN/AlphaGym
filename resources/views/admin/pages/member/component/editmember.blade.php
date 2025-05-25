 <!-- Edit Member Modal -->
 <div class="modal fade custom-modal" id="editMemberModal" tabindex="-1" role="dialog"
     aria-labelledby="editMemberModalTitle" aria-hidden="true">
     <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
         <div class="modal-content">
             <div class="modal-header bg-primary text-white">
                 <h5 class="modal-title" id="editMemberModalTitle">CẬP NHẬT THÔNG TIN THÀNH VIÊN</h5>
                 <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                 </button>
             </div>
             <div class="modal-body">
                 <form id="editMemberForm" method="POST" action="{{ route('admin.members.update') }}"
                     enctype="multipart/form-data">
                     @csrf



                     <div class="row">
                         <!-- Cột thông tin cá nhân -->
                         <div class="col-md-6 border-right">
                             <input type="hidden" name="member_id" id="editMemberId">
                             <div class="form-group">
                                 <label for="editMemberName" name="full_name" class="font-weight-bold">Họ tên <span
                                         class="text-danger">*</span></label>
                                 <input type="text" class="form-control form-control-lg" name="full_name"
                                     id="editMemberName" required>

                             </div>

                             <div class="form-group">
                                 <label for="editMemberPhone" name="phone" class="font-weight-bold">Số điện thoại
                                     <span class="text-danger">*</span></label>
                                 <input type="tel" class="form-control form-control-lg" name="phone"
                                     id="editMemberPhone" required>
                             </div>

                             <div class="form-group">
                                 <label for="editMemberEmail" name="email" class="font-weight-bold">Email</label>
                                 <input type="email" class="form-control form-control-lg" name="email"
                                     id="editMemberEmail">
                             </div>

                             <div class="form-group">
                                 <label for="editMemberNotes" name="notes" class="font-weight-bold">Ghi chú</label>
                                 <textarea class="form-control" name="notes" id="editMemberNotes" rows="2"></textarea>
                             </div>

                             <div class="form-group">
                                 <label for="editMemberStatus" name="status" class="font-weight-bold">Trạng thái
                                     <span class="text-danger">*</span></label>
                                 <select id="editMemberStatus" name="status" class="form-control">
                                     <option value="active">Hoạt động</option>
                                     <option value="expired">Hết hạn</option>
                                     <option value="banned">Bị khóa</option>
                                 </select>

                             </div>
                         </div>

                         <!-- Cột ảnh đại diện và RFID -->
                         <div class="col-md-6">
                             <!-- Phần ảnh đại diện -->
                             <div class="form-group">
                                 <label class="font-weight-bold">Ảnh đại diện</label>
                                 <div class="d-flex align-items-center">
                                     <div class="avatar-preview mr-3">
                                         <img id="currentAvatar" src="#" alt="Current Avatar"
                                             class="img-thumbnail rounded-circle"
                                             style="width: 120px; height: 120px; object-fit: cover;">
                                     </div>
                                     <div class="flex-grow-1">
                                         <div class="custom-file">
                                             <input type="file" name="img" class="custom-file-input"
                                                 id="editMemberAvatar" accept="image/*">
                                             <label class="custom-file-label" for="editMemberAvatar">Chọn ảnh
                                                 mới</label>
                                         </div>
                                         <small class="form-text text-muted">Ảnh JPG/PNG, tối đa 2MB</small>
                                     </div>
                                 </div>
                                 <div class="mt-2 text-center" id="editAvatarPreview" style="display: none;">
                                     <img id="editPreviewImage" src="#" alt="Avatar Preview"
                                         class="img-thumbnail rounded-circle"
                                         style="width: 120px; height: 120px; object-fit: cover;">
                                     <div class="mt-1">
                                         <button type="button" class="btn btn-sm btn-outline-danger"
                                             id="cancelAvatarChange">Hủy</button>
                                     </div>
                                 </div>
                             </div>

                             <!-- Phần quản lý thẻ RFID -->
                             <div class="card mt-3 border-primary">
                                 <div class="card-header bg-light">
                                     <h6 class="mb-0 font-weight-bold">QUẢN LÝ THẺ RFID</h6>
                                 </div>
                                 <div class="card-body">
                                     <div class="form-group">
                                         <label class="font-weight-bold">Thẻ hiện tại</label>
                                         <div class="input-group mb-2">
                                             <input type="text" value="{{ $result['rfid_card_id'] }}" disabled
                                                 class="form-control">


                                         </div>
                                         <small class="text-muted">Thẻ RFID đang được liên kết với thành viên
                                             này</small>
                                     </div>

                                     <div class="form-group mt-3">
                                         <label class="font-weight-bold">Thêm thẻ mới</label>
                                         <div class="input-group">
                                             <input type="text" name="rfid_card_id" class="form-control"
                                                 id="newRfid" placeholder="Quẹt thẻ RFID vào đây" readonly>

                                             <div class="input-group-append">
                                                 <button class="btn btn-primary" type="button" id="scanRfidBtn">
                                                     Quét thẻ
                                                 </button>
                                             </div>
                                         </div>
                                         <small class="text-muted">Nhấn nút quét và quẹt thẻ RFID vào đầu đọc</small>
                                     </div>
                                 </div>
                             </div>
                         </div>
                     </div>
                     <div class="modal-footer">
                         <button type="button" class="btn btn-secondary" data-dismiss="modal">
                             <i class="las la-ban"></i> Hủy
                         </button>
                         <button type="submit" class="btn btn-primary">
                             <i class="las la-save"></i> Lưu thay đổi
                         </button>

                     </div>
                 </form>

             </div>

         </div>
     </div>
 </div>
 <script>
     // Thêm script xử lý RFID (giả lập bàn phím)
     document.addEventListener('DOMContentLoaded', function() {
         // Xử lý quét thẻ RFID
         let scanning = false;
         const newRfidInput = document.getElementById('newRfid');
         const scanRfidBtn = document.getElementById('scanRfidBtn');

         scanRfidBtn.addEventListener('click', function() {
             scanning = true;
             newRfidInput.value = '';
             newRfidInput.placeholder = 'Đang chờ quét thẻ...';
             scanRfidBtn.disabled = true;
             scanRfidBtn.innerHTML = '<i class="fas fa-circle-notch fa-spin"></i> Đang chờ thẻ';

             // Hủy quét sau 30 giây nếu không có thẻ
             setTimeout(() => {
                 if (scanning) {
                     scanning = false;
                     newRfidInput.placeholder = 'Quẹt thẻ RFID vào đây';
                     scanRfidBtn.disabled = false;
                     scanRfidBtn.innerHTML = '<i class="fas fa-rss"></i> Quét thẻ';
                     alert('Hết thời gian chờ quét thẻ. Vui lòng thử lại.');
                 }
             }, 30000);
         });

         document.addEventListener('keypress', function(e) {
             if (scanning) {

                 if (e.key === 'Enter') {
                     scanning = false;
                     scanRfidBtn.disabled = false;
                     scanRfidBtn.innerHTML = '<i class="fas fa-rss"></i> Quét thẻ';


                     console.log('Thẻ RFID đã quét:', newRfidInput.value);


                 } else {

                     newRfidInput.value += e.key;
                 }
             }
         });


         document.getElementById('removeRfidBtn').addEventListener('click', function() {
             if (confirm('Bạn có chắc chắn muốn xóa thẻ RFID này?')) {
                 document.getElementById('currentRfid').value = '';

             }
         });

         document.getElementById('editMemberAvatar').addEventListener('change', function(e) {
             const file = e.target.files[0];
             if (file) {
                 const reader = new FileReader();
                 reader.onload = function(event) {
                     document.getElementById('editPreviewImage').src = event.target.result;
                     document.getElementById('editAvatarPreview').style.display = 'block';
                 };
                 reader.readAsDataURL(file);
             }
         });

         document.getElementById('cancelAvatarChange').addEventListener('click', function() {
             document.getElementById('editMemberAvatar').value = '';
             document.getElementById('editAvatarPreview').style.display = 'none';
         });
     });
 </script>
 <script>
     $('#editMemberStatus').val(btn.data('status'));
 </script>
