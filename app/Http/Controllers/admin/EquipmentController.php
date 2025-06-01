<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Equipment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EquipmentController extends Controller
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

        $equipments = Equipment::orderBy('status')->orderBy('purchase_date', 'desc')->get();
        return view('admin.pages.equipment.index', compact('equipments', 'config'));
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

        return view('admin.pages.equipment.create', compact('config'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'          => 'required|string|max:255',
            'img'           => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'purchase_date' => 'required|date',
            'status'        => 'required|in:working,maintenance,broken',
            'location'      => 'nullable|string|max:255',
            'notes'         => 'nullable|string',
        ]);

        if ($request->hasFile('img')) {
            $file     = $request->file('img');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('admin/images/equipment'), $filename);
            $validated['img'] = 'admin/images/equipment/' . $filename;
        }

        Equipment::create($validated);

        return redirect()->route('admin.equipment.index')
            ->with('success', 'Thêm thiết bị mới thành công!');
    }

    public function update(Request $request, Equipment $equipment)
    {

        $request->validate([
            'id'            => 'required|exists:equipment,id',
            'name'          => 'required|string|max:255',
            'img'           => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'purchase_date' => 'required|date',
            'status'        => 'required|in:working,maintenance,broken',
            'location'      => 'nullable|string|max:255',
            'notes'         => 'nullable|string',
        ]);
        $equipment = Equipment::findOrFail($request->id);

        $equipment->name          = $request->name;
        $equipment->purchase_date = $request->purchase_date;
        $equipment->status        = $request->status;
        $equipment->location      = $request->location;
        $equipment->notes         = $request->notes;
        if ($request->hasFile('img')) {
            $file     = $request->file('img');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('admin/images/equipment'), $filename);
            $equipment->img = 'admin/images/equipment/' . $filename;
        }

        $equipment->save();

        return redirect()->route('admin.equipment.index')
            ->with('success', 'Cập nhật thông tin thiết bị thành công!');
    }

    public function destroy(Equipment $equipment)
    {

        if ($equipment->img) {
            Storage::disk('public')->delete($equipment->img);
        }

        $equipment->delete();

        return redirect()->route('admin.equipment.index')
            ->with('success', 'Xóa thiết bị thành công!');
    }
}
