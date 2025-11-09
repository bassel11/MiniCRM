<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Communication;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // 1️⃣ إجمالي العملاء حسب الحالة
        $clientsByStatus = Client::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->get();

        // 2️⃣ أفضل 5 مندوبي مبيعات حسب العملاء النشطين
        $topSalesReps = User::role('sales_rep')
            ->withCount(['clients as active_clients_count' => function($q){
                $q->where('status', '!=', 'Inactive');
            }])
            ->orderByDesc('active_clients_count')
            ->limit(5)
            ->get(['id','name']);

        // 3️⃣ العملاء الذين يحتاجون متابعة اليوم
        $clientsNeedingFollowUp = Client::whereHas('followUps', function($q){
            $q->whereDate('due_at', today())->where('done', false);
        })->get(['id','name','email']);

        // 4️⃣ متوسط عدد الاتصالات لكل عميل
        $totalClients = Client::count();
        $totalComms = Communication::count();
        $avgCommunications = $totalClients ? round($totalComms / $totalClients, 2) : 0;

        return response()->json([
            'clients_by_status' => $clientsByStatus,
            'top_sales_reps' => $topSalesReps,
            'clients_needing_followup_today' => $clientsNeedingFollowUp,
            'average_communication_per_client' => $avgCommunications,
        ]);
    }
}
