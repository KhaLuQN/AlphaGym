<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Member;
use Illuminate\Http\Request;

class RFIDController extends Controller
{
    /**
     * Hiển thị danh sách thẻ RFID
     */
    public function index()
    {
        $config = [

            'css' => [
                'admin/css/bootstrap.min.css',
                'admin/css/dataTables.bootstrap4.min.css',
                'admin/css/typography.css',
                'admin/css/style.css',
                'admin/css/responsive.css',

            ],
            'js'  => [

                'admin/js/jquery.min.js',
                'admin/js/popper.min.js',
                'admin/js/bootstrap.min.js',
                'admin/js/jquery.dataTables.min.js',
                'admin/js/dataTables.bootstrap4.min.js',
                'admin/js/jquery.appear.js',
                'admin/js/countdown.min.js',
                'admin/js/waypoints.min.js',
                'admin/js/jquery.counterup.min.js',
                'admin/js/wow.min.js',
                'admin/js/apexcharts.js',
                'admin/js/slick.min.js',
                'admin/js/select2.min.js',
                'admin/js/owl.carousel.min.js',
                'admin/js/jquery.magnific-popup.min.js',
                'admin/js/smooth-scrollbar.js',
                'admin/js/lottie.js',
                'admin/js/core.js',
                'admin/js/charts.js',
                'admin/js/animated.js',
                'admin/js/kelly.js',
                'admin/js/maps.js',
                'admin/js/worldLow.js',
                'admin/js/raphael-min.js',
                'admin/js/morris.js',
                'admin/js/morris.min.js',
                'admin/js/flatpickr.js',
                'admin/js/style-customizer.js',
                'admin/js/chart-custom.js',
                'admin/js/custom.js',
                'admin/js/stylecustom.js',
            ],
        ];

        // Lấy danh sách thành viên có thẻ RFID, sắp xếp theo trạng thái và ngày tham gia
        $members = Member::whereNotNull('rfid_card_id')
            ->orderBy('status', 'desc')
            ->orderBy('join_date', 'desc')
            ->get();

        return view('admin.pages.rfid.index', compact('members', 'config'));
    }

    /**
     * Cập nhật trạng thái thẻ RFID (khóa/mở)
     */
    public function update(Request $request, $id)
    {
        $member = Member::findOrFail($id);

        // Validate nếu member có thẻ RFID
        if (empty($member->rfid_card_id)) {
            return redirect()->back()
                ->with('error', 'Thành viên này không có thẻ RFID!');
        }

        $member->update([
            'status'     => $request->status,
            'updated_at' => now(),
        ]);

        return redirect()->back()
            ->with('success', 'Cập nhật trạng thái thẻ thành công!');
    }

    /**
     * Gỡ thẻ RFID khỏi thành viên
     */
    public function destroy($id)
    {
        $member = Member::findOrFail($id);

        // Kiểm tra nếu thành viên không có thẻ
        if (empty($member->rfid_card_id)) {
            return redirect()->back()
                ->with('error', 'Thành viên này không có thẻ RFID!');
        }

        $member->update([
            'rfid_card_id' => null,
            'updated_at'   => now(),
        ]);

        return redirect()->back()
            ->with('success', 'Đã gỡ thẻ RFID khỏi thành viên!');
    }

}
