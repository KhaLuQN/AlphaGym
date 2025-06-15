<?php
namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Mail\CustomCampaignMail;
use App\Models\CommunicationLog;
use App\Models\EmailTemplate;
use App\Models\Member;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

// Sẽ tạo ở Bước 4

class MemberEngagementController extends Controller
{
    /**
     * Hiển thị trang quản lý gửi email với bộ lọc
     */
    public function index(Request $request)
    {
        $query  = Member::query();
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

        // Lọc theo số tháng tham gia
        if ($request->filled('months')) {
            $months = (int) $request->months;
            if ($months > 0) {

                $targetDate = Carbon::now()->subMonths($months);
                $query->whereMonth('join_date', $targetDate->month)
                    ->whereYear('join_date', $targetDate->year);
            }
        }

        // Lọc theo log
        if ($request->filled('campaign_name')) {
            $campaignName = $request->campaign_name;

            $sentMemberIds = CommunicationLog::where('campaign_name', $campaignName)->pluck('member_id');

            $query->whereNotIn('member_id', $sentMemberIds);
        }

        $members   = $query->with('subscriptions')->paginate(20)->withQueryString();
        $templates = EmailTemplate::all();

        return view('admin.pages.engagement.index', array_merge(
            compact('config'),
            [
                'members'   => $members,
                'templates' => $templates,
                'filters'   => $request->all(),
            ]
        ));

    }

    /**
     * Xử lý gửi email cho các hội viên đã chọn
     */
    public function send(Request $request)
    {
        $request->validate([
            'member_ids'    => 'required|array|min:1',
            'member_ids.*'  => 'exists:members,member_id',
            'campaign_name' => 'required|string|max:100',
            'subject'       => 'required|string|max:255',
            'body'          => 'required|string',

        ]);

        $members   = Member::whereIn('member_id', $request->member_ids)->get();
        $sentCount = 0;

        foreach ($members as $member) {
            try {

                $personalizedBody = str_replace('[TEN_HOI_VIEN]', $member->full_name, $request->body);
                $personalizedBody = str_replace(
                    '[NGAY_THAM_GIA]',
                    \Carbon\Carbon::parse($member->join_date)->format('d/m/Y'),
                    $personalizedBody
                );

                Mail::to($member->email)->send(new CustomCampaignMail($request->subject, $personalizedBody));

                CommunicationLog::create([
                    'member_id'     => $member->member_id,
                    'user_id'       => Auth::id(),
                    'campaign_name' => $request->campaign_name,
                    'subject'       => $request->subject,
                    'body'          => $personalizedBody,
                    'status'        => 'sent',
                    'sent_at'       => now(),
                ]);

                $sentCount++;
            } catch (\Exception $e) {
                Log::error("Gửi email chiến dịch '{$request->campaign_name}' thất bại đến {$member->email}: " . $e->getMessage());
            }
        }

        return redirect()->back()->with('success', "Đã gửi email thành công cho {$sentCount}/" . count($request->member_ids) . " hội viên.");
    }
}
