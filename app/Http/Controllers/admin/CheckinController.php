<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Checkin;
use App\Models\Member;
use Illuminate\Http\Request;

class CheckinController extends Controller
{
    public function index(Request $request)
    {
        $config = [
            'js'  => [
                'admin/js/jquery.min.js',
                'admin/js/popper.min.js',
                'admin/js/bootstrap.min.js',
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
            ],
            'css' => [
                'admin/css/bootstrap.min.css',
                'admin/css/typography.css',
                'admin/css/style.css',
                'admin/css/responsive.css',
            ],
        ];

        $query = Checkin::with('member');

        if ($request->filled('start_date')) {
            $query->whereDate('checkin_time', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('checkin_time', '<=', $request->end_date);
        }

        $checkins = $query->orderByDesc('checkin_time')->paginate(10)->withQueryString();

        return view('admin.pages.checkin.index', compact('checkins', 'config'));
    }
    public function forceCheckout($checkinId)
    {
        $checkin = Checkin::findOrFail($checkinId);

        if ($checkin->checkout_time) {
            return redirect()->back()->with('error', 'Thành viên đã check-out rồi.');
        }

        $checkin->checkout_time = now();
        $checkin->save();

        return redirect()->back()->with('success', 'Check-out thành công.');
    }

    public function forceCheckoutAll()
    {

        $updatedCount = Checkin::whereNull('checkout_time')
            ->update(['checkout_time' => now()]);

        return redirect()->back()->with('success', "Đã check-out $updatedCount thành viên.");
    }

    public function checkinPage()
    {
        $config = [
            'js'  => [
                'admin/js/jquery.min.js',
                'admin/js/popper.min.js',
                'admin/js/bootstrap.min.js',
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
            ],
            'css' => [
                'admin/css/bootstrap.min.css',
                'admin/css/typography.css',
                'admin/css/style.css',
                'admin/css/responsive.css',
            ],
        ];

        return view('admin.pages.checkin.checkinPage', compact('config'));

    }
    public function machineCheckin(Request $request)
    {
        $request->validate([
            'rfid_card_id' => 'required|string',
        ]);

        $rfid = $request->input('rfid_card_id');

        $member = Member::where('rfid_card_id', $rfid)->first();

        if (! $member) {
            return back()->with('message', 'Không tìm thấy thành viên với mã thẻ này.');
        }

        $existingCheckin = Checkin::where('member_id', $member->member_id)
            ->whereNull('checkout_time')
            ->orderBy('checkin_time', 'desc') // hoặc created_at
            ->first();

        if ($existingCheckin) {
            // Nếu tìm thấy checkin chưa checkout thì update checkout_time
            $existingCheckin->update(['checkout_time' => now()]);
            return back()->with('message', 'Đã check-out cho ' . $member->full_name);
        } else {
            // Nếu chưa có checkin chưa checkout thì tạo mới checkin
            Checkin::create([
                'member_id'    => $member->member_id,
                'rfid_card_id' => $member->rfid_card_id,
                'checkin_time' => now(),
            ]);
            return back()->with('message', 'Đã check-in cho ' . $member->full_name);
        }

    }

}
