<?php
namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\MembershipPlan;
use App\Models\MemberSubscription;
use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MemberSubscriptionController extends Controller
{

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
                'admin/js/slick.min.js',
                'admin/js/select2.min.js',
                'admin/js/owl.carousel.min.js',
                'admin/js/jquery.magnific-popup.min.js',
                'admin/js/smooth-scrollbar.js',
                'admin/js/lottie.js',

                'admin/js/flatpickr.js',
                'admin/js/style-customizer.js',
                'admin/js/chart-custom.js',
                'admin/js/custom.js',
                'admin/js/stylecustom.js',
            ],
        ];

        $members = Member::all();

        $packages = MembershipPlan::orderBy('price', 'asc')->paginate(10);
        return view(
            'admin.pages.subscriptions.create', compact('config', 'packages', 'members'));

    }

    public function store(Request $request)
    {

        $request->validate([
            'member_id'      => 'required|exists:members,member_id',
            'package_id'     => 'required|exists:membership_plans,plan_id',
            'start_date'     => 'required|date|after_or_equal:today',
            'payment_method' => 'required|in:cash,momo',
        ]);

        $package = MembershipPlan::findOrFail($request->package_id);

        $actualPrice = $package->price * (1 - $package->discount_percent / 100);

        $currentSubscription = MemberSubscription::where('member_id', $request->member_id)
            ->where('end_date', '>=', now())
            ->orderByDesc('end_date')
            ->first();

        if ($currentSubscription) {

            $startDate = Carbon::parse($currentSubscription->end_date)->addDay();
        } else {

            $startDate = Carbon::parse($request->start_date);
        }

        $endDate = $startDate->copy()->addDays($package->duration_days);

        if ($request->payment_method === 'cash') {

            $subscription = MemberSubscription::create([
                'member_id'      => $request->member_id,
                'plan_id'        => $package->plan_id,
                'start_date'     => $startDate->toDateString(),
                'end_date'       => $endDate->toDateString(),
                'actual_price'   => $actualPrice,
                'payment_status' => 'paid',
                'payment_date'   => now(),
            ]);

            Payment::create([
                'subscription_id' => $subscription->subscription_id,
                'amount'          => $actualPrice,
                'payment_date'    => now(),
                'payment_method'  => 'Cash',
                'notes'           => 'Thanh toán tiền mặt tại quầy',
            ]);

            return redirect()->back()->with('success', 'Đăng ký gói tập thành công và thanh toán tiền mặt!');
        }

        return redirect()->back()->with('error', 'Chức năng thanh toán MoMo đang được phát triển.');
    }

}
