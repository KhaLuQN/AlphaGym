 <!-- Sidebar  -->
 <div class="iq-sidebar">
     <div class="iq-sidebar-logo d-flex justify-content-between">
         <a href="admin-dashboard.html" class="header-logo">
             <img src="images/logo.png" class="img-fluid rounded-normal" alt="">
             <div class="logo-title">
                 <span class="text-primary text-uppercase">NHASACHTV</span>
             </div>
         </a>
         <div class="iq-menu-bt-sidebar">
             <div class="iq-menu-bt align-self-center">
                 <div class="wrapper-menu">
                     <div class="main-circle"><i class="las la-bars"></i></div>
                 </div>
             </div>
         </div>
     </div>
     <div id="sidebar-scrollbar">
         <nav class="iq-sidebar-menu">
             <ul id="iq-sidebar-toggle" class="iq-menu">
                 <li><a href="admin-dashboard.html"><i class="las la-home iq-arrow-left"></i>Bảng Điều Khiển</a></li>
                 <li><a href="{{ route('members.index') }}"><i class="ri-record-circle-line"></i>Danh sách thành
                         viên</a>
                 </li>
                 <li><a href="admin-packages.html"><i class="ri-record-circle-line"></i>Danh sách gói tập</a></li>
                 <li><a href="admin-device.html"><i class="ri-record-circle-line"></i>Thiết bị</a></li>
                 <li><a href="admin-rfid-cards.html"><i class="ri-record-circle-line"></i>Thẻ RFID</a></li>
                 <li><a href="admin-checkin.html"><i class="ri-record-circle-line"></i>Quản Lý Vào Ra</a></li>
                 <li><a href="admin-payments.html"><i class="ri-record-circle-line"></i>Thanh Toán</a></li>
                 <li><a href="sign-in.html"><i class="ri-record-circle-line"></i>Đăng Xuất</a></li>
         </nav>
         <div id="sidebar-bottom" class="p-3 position-relative">
             <div class="iq-card">
                 <div class="iq-card-body">
                     <div class="sidebarbottom-content">
                         <div class="image"><img src="images/page-img/side-bkg.png" alt=""></div>
                         <button type="submit" class="btn w-100 btn-primary mt-4 view-more">Become Membership</button>
                     </div>
                 </div>
             </div>
         </div>
     </div>
 </div>
