<?php
namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\MembershipPlan;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MemberController extends Controller
{
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
        $members = Member::with([
            'latestSubscription.plan',
        ])->get();

        $results = $members->map(function ($member) {
            return [
                'member_id'    => $member->member_id,
                'img'          => $member->img,
                'full_name'    => $member->full_name,
                'phone'        => $member->phone,
                'email'        => $member->email,
                'notes'        => $member->notes,
                'plans'        => $member->subscriptions->map(function ($sub) {
                    return optional($sub->plan)->plan_name;
                })->filter()->values()->all(),
                'end_date'     => optional($member->latestSubscription)->end_date ?? '---',

                'status'       => $member->status,
                'rfid_card_id' => $member->rfid_card_id,
            ];
        });

        return view('admin.pages.member.index', compact('config', 'results'));

    }

    public function create()
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
                // Core JS
                'admin/js/jquery.min.js',
                'admin/js/popper.min.js',
                'admin/js/bootstrap.min.js',
                'admin/js/jquery.dataTables.min.js',
                'admin/js/dataTables.bootstrap4.min.js',

                // Hiệu ứng và thư viện khác
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
        $packages = MembershipPlan::select('plan_id', 'plan_name', 'duration_days', 'price', 'discount_percent')->get();

        return view('admin.pages.member.create', compact('config', 'packages'));

    }
    public function update(Request $request)
    {
        $request->validate([
            'member_id'    => 'required|exists:members,member_id',
            'full_name'    => 'required|string|max:100',
            'phone'        => 'required|string|max:15',
            'email'        => 'nullable|email|max:100',
            'notes'        => 'nullable|string',
            'img'          => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'rfid_card_id' => 'nullable|string|max:50', // thẻ mới nếu có
        ]);

        $member = Member::findOrFail($request->member_id);

        $member->full_name = $request->full_name;
        $member->phone     = $request->phone;
        $member->email     = $request->email;
        $member->notes     = $request->notes;
        $member->status    = $request->status;

        // Nếu có thẻ mới thì kiểm tra trùng
        if ($request->filled('rfid_card_id')) {
            $existingRfid = Member::where('rfid_card_id', $request->rfid_card_id)
                ->where('member_id', '!=', $member->member_id)
                ->first();

            if ($existingRfid) {
                return redirect()->back()->with(['error' => 'Thẻ RFID này đã được sử dụng bởi thành viên khác.']);
            }

            $member->rfid_card_id = $request->rfid_card_id;
        }

        if ($request->hasFile('img')) {
            $file     = $request->file('img');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('admin/images/member'), $filename);
            $member->img = 'admin/images/member/' . $filename;
        }

        $member->save();

        return redirect()->back()->with('success', 'Cập nhật thông tin thành viên thành công!');
    }

    public function store(Request $request)
    {

        $request->validate([
            'full_name'    => 'required|string|max:100',
            'phone'        => 'required|string|max:15|unique:members,phone',
            'email'        => 'nullable|email|max:100|unique:members,email',
            'notes'        => 'nullable|string',
            'rfid_card_id' => 'nullable|string|max:50|',
            'img'          => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->filled('rfid_card_id')) {
            $exists = Member::where('rfid_card_id', $request->rfid_card_id)->exists();
            if ($exists) {
                return redirect()->back()->with(['error' => 'Thẻ RFID này đã được sử dụng bởi thành viên khác.'])->withInput();
            }
        }
        $member               = new Member();
        $member->full_name    = $request->full_name;
        $member->phone        = $request->phone;
        $member->email        = $request->email;
        $member->notes        = $request->notes;
        $member->rfid_card_id = $request->rfid_card_id;
        $member->status       = 'active';

        if ($request->hasFile('img')) {
            $file     = $request->file('img');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('admin/images/member'), $filename);
            $member->img = 'admin/images/member/' . $filename;
        }

        $member->save();

        return redirect()->back()->with('success', 'Thêm thành viên thành công!');
    }
    public function show($id)
    {$config = [

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

        // Lấy thông tin thành viên
        $member = Member::with(['checkins' => function ($query) {
            $query->orderBy('checkin_time', 'desc')->limit(10);
        }])->findOrFail($id);

        // Thống kê
        $totalCheckins     = $member->checkins()->count();
        $lastMonthCheckins = $member->checkins()
            ->where('checkin_time', '>=', Carbon::now()->subMonth())
            ->count();
        $avgSessionTime = $this->calculateAvgSessionTime($member);

        return view('admin.pages.member.show', compact(
            'member',
            'totalCheckins',
            'lastMonthCheckins',
            'config',
            'avgSessionTime'
        ));}

    private function calculateAvgSessionTime($member)
    {
        $sessions = $member->checkins()
            ->whereNotNull('checkout_time')
            ->get();

        if ($sessions->isEmpty()) {
            return null;
        }

        $totalSeconds = 0;
        foreach ($sessions as $session) {
            $totalSeconds += $session->checkin_time->diffInSeconds($session->checkout_time);
        }

        $avgSeconds = $totalSeconds / $sessions->count();

        return [
            'hours'   => floor($avgSeconds / 3600),
            'minutes' => floor(($avgSeconds % 3600) / 60),
        ];
    }
}
