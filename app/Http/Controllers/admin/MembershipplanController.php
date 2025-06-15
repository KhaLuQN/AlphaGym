<?php
namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\MembershipPlan;
use Illuminate\Http\Request;

class MembershipplanController extends Controller
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
        $packages = MembershipPlan::orderBy('price', 'asc')->paginate(10);

        return view(
            'admin.pages.package.index', compact('config', 'packages'));
    }

    public function update(Request $request)
    {

        $request->validate([
            'plan_id'          => 'required|integer|exists:membership_plans,plan_id',

            'plan_name'        => 'required|string|max:255',
            'duration_days'    => 'required|integer|min:1',
            'price'            => 'required|numeric|min:0',
            'discount_percent' => 'required|numeric|min:0|max:100',
        ]);

        try {
            $package = MembershipPlan::findOrFail($request->plan_id);

            $package->update([
                'plan_name'        => $request->plan_name,
                'duration_days'    => $request->duration_days,
                'price'            => $request->price,
                'discount_percent' => $request->discount_percent,
            ]);

            return redirect()->back()->with('success', 'Cập nhật gói tập thành công!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
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

        return view('admin.pages.package.create', compact('config'));

    }

    public function store(Request $request)
    {
        $request->validate([
            'plan_name'        => 'required|string|max:255',
            'duration_days'    => 'required|integer|min:1',
            'price'            => 'required|numeric|min:0',
            'discount_percent' => 'nullable|numeric|min:0|max:100',
        ]);

        try {
            MembershipPlan::create([
                'plan_name'        => $request->plan_name,
                'duration_days'    => $request->duration_days,
                'price'            => $request->price,
                'discount_percent' => $request->discount_percent ?? 0,
            ]);

            return redirect()->route('admin.package.index')->with('success', 'Thêm gói tập thành công!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }
    public function destroy($id)
    {
        try {
            $plan = MembershipPlan::findOrFail($id);
            $plan->delete();

            return redirect()->back()->with('success', 'Xoá gói tập thành công!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi xoá: ' . $e->getMessage());
        }
    }

}
