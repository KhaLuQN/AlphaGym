<div class="iq-sidebar">
    <div class="iq-sidebar-logo d-flex justify-content-between">
        <a href="{{-- route('dashboard.index') --}}" class="header-logo">
            <img src="images/logo.png" class="img-fluid rounded-normal" alt="">
            <div class="logo-title">
                <span class="text-primary text-uppercase">AlphaGym</span>
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
                <li>
                    <a href="{{ route('dashboard.index') }}" class="iq-waves-effect">
                        <i class="las la-tachometer-alt iq-arrow-left"></i><span>Bảng Điều Khiển</span>
                    </a>
                </li>

                <li class="iq-menu-title">
                    <i class="ri-subtract-line"></i><span>Quản Lý Phòng Gym</span>
                </li>
                <li>
                    <a href="#memberManagement" class="iq-waves-effect" data-toggle="collapse" aria-expanded="false">
                        <i class="las la-users iq-arrow-left"></i><span>Hội Viên</span>
                        <i class="ri-arrow-right-s-line iq-arrow-right"></i>
                    </a>
                    <ul id="memberManagement" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                        <li><a href="{{ route('admin.members.index') }}"><i class="las la-list-ul"></i>Danh sách Hội
                                viên</a></li>
                        <li><a href="{{ route('admin.members.create') }}"><i class="las la-user-plus"></i>Thêm Hội viên
                                mới</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#subscriptionManagement" class="iq-waves-effect" data-toggle="collapse"
                        aria-expanded="false">
                        <i class="las la-id-badge iq-arrow-left"></i><span>Gói Đăng Ký</span>
                        <i class="ri-arrow-right-s-line iq-arrow-right"></i>
                    </a>
                    <ul id="subscriptionManagement" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                        <li><a href="{{-- route('admin.subscriptions.index') --}}"><i class="las la-list-alt"></i>DS Gói Đã Đăng Ký</a></li>
                        <li><a href="{{ route('admin.subscriptions.create') }}"><i class="las la-cart-plus"></i>Đăng ký
                                Gói mới</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#planManagement" class="iq-waves-effect" data-toggle="collapse" aria-expanded="false">
                        <i class="las la-cubes iq-arrow-left"></i><span>Gói Dịch Vụ</span>
                        <i class="ri-arrow-right-s-line iq-arrow-right"></i>
                    </a>
                    <ul id="planManagement" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                        <li><a href="{{ route('admin.package.index') }}"><i class="las la-list"></i>Danh sách Gói Dịch
                                Vụ</a></li>
                        <li><a href="{{ route('admin.package.create') }}"><i class="las la-plus-square"></i>Thêm Gói
                                Dịch Vụ</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#checkinManagement" class="iq-waves-effect" data-toggle="collapse" aria-expanded="false">
                        <i class="las la-calendar-check iq-arrow-left"></i><span>Check-in/Check-out</span>
                        <i class="ri-arrow-right-s-line iq-arrow-right"></i>
                    </a>
                    <ul id="checkinManagement" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                        <li><a href="{{ route('admin.checkin.index') }}"><i class="las la-history"></i>Lịch sử
                                Ra/Vào</a></li>
                        <li><a href="{{ route('admin.checkin.checkinPage') }}"><i class="las la-tv"></i>Trang
                                Check-in</a></li>
                    </ul>
                </li>
                <li>
                    <a href="{{-- route('admin.payments.index') --}}" class="iq-waves-effect">
                        <i class="las la-file-invoice-dollar iq-arrow-left"></i><span>Thanh Toán</span>
                    </a>
                </li>
                <li>
                    <a href="#equipmentManagement" class="iq-waves-effect" data-toggle="collapse" aria-expanded="false">
                        <i class="las la-dumbbell iq-arrow-left"></i><span>Thiết Bị</span>
                        <i class="ri-arrow-right-s-line iq-arrow-right"></i>
                    </a>
                    <ul id="equipmentManagement" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                        <li><a href="{{ route('admin.equipment.index') }}"><i class="las la-list"></i>Danh sách Thiết
                                bị</a></li>
                        <li><a href="{{ route('admin.equipment.create') }}"><i class="las la-plus"></i>Thêm Thiết bị</a>
                        </li>
                    </ul>
                </li>

                <li class="iq-menu-title">
                    <i class="ri-subtract-line"></i><span>Quản Lý Website</span>
                </li>
                <li>
                    <a href="#articleManagement" class="iq-waves-effect" data-toggle="collapse" aria-expanded="false">
                        <i class="las la-newspaper iq-arrow-left"></i><span>Bài Viết & Tin Tức</span>
                        <i class="ri-arrow-right-s-line iq-arrow-right"></i>
                    </a>
                    <ul id="articleManagement" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                        <li><a href="{{-- route('admin.articles.index') --}}"><i class="las la-list-alt"></i>Tất cả Bài Viết</a></li>
                        <li><a href="{{-- route('admin.articles.create') --}}"><i class="las la-pen-nib"></i>Viết Bài Mới</a></li>
                        <li><a href="{{-- route('admin.article_categories.index') --}}"><i class="las la-sitemap"></i>Danh Mục Bài Viết</a></li>
                    </ul>
                </li>
                <li>
                    <a href="{{-- route('admin.trial_registrations.index') --}}" class="iq-waves-effect">
                        <i class="las la-user-clock iq-arrow-left"></i><span>Đăng Ký Tập Thử</span>
                    </a>
                </li>
                <li>
                    <a href="{{-- route('admin.testimonials.index') --}}" class="iq-waves-effect">
                        <i class="las la-comments iq-arrow-left"></i><span>Phản Hồi Khách Hàng</span>
                    </a>
                </li>
                <li>
                    <a href="{{-- route('admin.ai_knowledge_base.index') --}}" class="iq-waves-effect">
                        <i class="las la-robot iq-arrow-left"></i><span>Cơ Sở Tri Thức AI</span>
                    </a>
                </li>
                <li>
                    <a href="{{-- route('admin.website_settings.index') --}}" class="iq-waves-effect">
                        <i class="las la-cog iq-arrow-left"></i><span>Cấu Hình Website</span>
                    </a>
                </li>


                <li class="iq-menu-title">
                    <i class="ri-subtract-line"></i><span>Quản Lý Hệ Thống</span>
                </li>
                <li>
                    <a href="{{-- route('admin.users.index') --}}" class="iq-waves-effect">
                        <i class="las la-user-shield iq-arrow-left"></i><span>Tài Khoản Nhân Viên</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.rfid.index') }}" class="iq-waves-effect"> <i
                            class="lab la-ello iq-arrow-left"></i><span>Quản Lý Thẻ RFID</span>
                    </a>
                </li>
                <li>
                    <a href="{{-- route('admin.reports.index') --}}" class="iq-waves-effect">
                        <i class="las la-chart-bar iq-arrow-left"></i><span>Báo Cáo & Thống Kê</span>
                    </a>
                </li>

            </ul>
        </nav>
        <div class="p-3"></div>
    </div>
</div>
