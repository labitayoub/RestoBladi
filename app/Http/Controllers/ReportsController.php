<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\Manager;
use App\Models\Waiter;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Exports\SalesExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;

class ReportsController extends Controller
{
    /**
     * Display a listing of reports.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Récupérer l'utilisateur authentifié et son manager_id
        $user = Auth::user();
        $manager = Manager::where('user_id', $user->id)->first();
        
        if (!$manager) {
            return redirect()->back()->with('error', 'Profil manager non trouvé.');
        }
        
        // Récupérer les IDs des serveurs associés à ce manager
        $waiterIds = Waiter::where('manager_id', $manager->id)->pluck('id')->toArray();
        
        // Filtrer les ventes pour n'inclure que celles faites par les serveurs de ce manager
        $dailySales = Sale::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('SUM(total_ttc) as total')
        )
            ->whereIn('waiter_id', $waiterIds)
            ->groupBy('date')
            ->orderBy('date', 'desc')
            ->take(7)
            ->get();
            
        return view('manager.rapport.index', compact('dailySales'));
    }

    /**
     * Générer un rapport entre deux dates données
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\View\View
     */
    public function generate(Request $request)
    {
        $request->validate([
            'from' => 'required|date',
            'to' => 'required|date|after_or_equal:from',
        ]);

        // Récupérer l'utilisateur authentifié et son manager_id
        $user = Auth::user();
        $manager = Manager::where('user_id', $user->id)->first();
        
        if (!$manager) {
            return redirect()->back()->with('error', 'Profil manager non trouvé.');
        }
        
        // Récupérer les IDs des serveurs associés à ce manager
        $waiterIds = Waiter::where('manager_id', $manager->id)->pluck('id')->toArray();

        $startDate = $request->from;
        $endDate = $request->to;

        // Récupérer les ventes dans l'intervalle de dates avec les relations nécessaires
        // et filtrer par les serveurs appartenant à ce manager
        $sales = Sale::whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
                    ->whereIn('waiter_id', $waiterIds)
                    ->with(['menus', 'tables', 'waiter.user'])
                    ->orderBy('created_at', 'desc')
                    ->get();

        $total = $sales->sum('total_ttc');

        return view('manager.rapport.rapport', [
            'sales' => $sales,
            'total' => $total,
            'startDate' => $startDate,
            'endDate' => $endDate
        ]);
    }

    /**
     * Exporter le rapport en Excel
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function export(Request $request)
    {
        $request->validate([
            'from' => 'required|date',
            'to' => 'required|date|after_or_equal:from',
        ]);

        // Récupérer l'utilisateur authentifié et son manager_id
        $user = Auth::user();
        $manager = Manager::where('user_id', $user->id)->first();
        
        if (!$manager) {
            return redirect()->back()->with('error', 'Profil manager non trouvé.');
        }
        
        // Récupérer les IDs des serveurs associés à ce manager
        $waiterIds = Waiter::where('manager_id', $manager->id)->pluck('id')->toArray();

        $from = $request->from;
        $to = $request->to;

        $fileName = 'rapport_ventes_' . $from . '_au_' . $to . '.xlsx';

        // Récupérer les ventes pour l'export et filtrer par les serveurs appartenant à ce manager
        $sales = Sale::whereBetween('created_at', [$from . ' 00:00:00', $to . ' 23:59:59'])
                    ->whereIn('waiter_id', $waiterIds)
                    ->with(['menus', 'tables', 'waiter.user'])
                    ->orderBy('created_at', 'desc')
                    ->get();

        $total = $sales->sum('total_ttc');

        // Utiliser la vue export.blade.php
        return Excel::download(
            new SalesExport($sales, $total, $from, $to),
            $fileName
        );
    }
}