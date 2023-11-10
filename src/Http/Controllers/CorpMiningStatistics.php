<?php

namespace pyTonicis\Seat\SeatCorpMiningTax\Http\Controllers;

use pyTonicis\Seat\SeatCorpMiningTax\Services\SettingService;
use Seat\Web\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Js;

class CorpMiningStatistics extends Controller
{

    private $settingService;

    public function __construct()
    {
        $this->settingService = new SettingService();
    }

    public function getHome()
    {
        $act_m = (date('m', time()));
        $act_y = (date('Y', time()));

        DB::statement("SET SQL_MODE=''");
        $total_minings = DB::table('corp_mining_tax')
            ->selectRaw('sum(quantity) as total_quantity, sum(volume) as total_volume, sum(price) as total_price, sum(tax) as total_tax')
            ->get();
        $total_members = DB::table('corp_mining_tax')
            ->select('main_character_id')
            ->groupBy('main_character_id')
            ->get();

        DB::statement("SET SQL_MODE=''");
        $top_ten_miners = DB::table('corp_mining_tax as t')
            ->selectRaw('sum(t.quantity) as q, sum(t.volume) as volume, sum(t.price) as price, c.name as name')
            ->join('character_infos as c', 't.main_character_id', '=', 'c.character_id')
            ->groupBy('t.main_character_id')
            ->orderBy('t.q', 'desc')
            ->limit(5)
            ->get();

        DB::statement("SET SQL_MODE=''");
        $top_ten_miners_last_month = DB::table('corp_mining_tax as t')
            ->selectRaw('sum(t.quantity) as q, sum(t.volume) as volume, sum(t.price) as price, c.name as name')
            ->join('character_infos as c', 't.main_character_id', '=', 'c.character_id')
            ->where('month', '=', $act_m -1)
            ->where('year', '=', $act_y)
            ->groupBy('t.main_character_id')
            ->orderBy('t.q', 'desc')
            ->limit(5)
            ->get();

        DB::statement("SET SQL_MODE=''");
        $events = DB::table('corp_mining_tax_event_minings')
            ->selectRaw('sum(refined_price) as price')
            ->first();

        DB::statement("SET SQL_MODE=''");
        $chart_data_over_all = DB::table('corp_mining_tax')
            ->selectRaw('str_to_date(concat(month, "-", year), "%m-%Y") as date, sum(volume) as volume')
            ->groupBy('date')
            ->orderBy('date', 'desc')
            ->limit(12)
            ->get();

        DB::statement("SET SQL_MODE=''");
        $chart_data_moon_minings = DB::table('corporation_industry_mining_observer_data')
            ->selectRaw('str_to_date(concat(month(updated_at), "-", year(updated_at)), "%m-%Y") as date, sum(quantity)*10 as volume')
            ->where('corporation_id', '=', $this->settingService->getValue('corporation_id'))
            ->groupBy('date')
            ->orderBy('date', 'desc')
            ->limit(12)
            ->get();

        $chart_labels = [];
        $chart_data1 = [];
        $chart_data2 = [];

        foreach($chart_data_over_all as $data) {
            array_push($chart_labels, $data->date);
            array_push($chart_data1, $data->volume);
        }
        foreach($chart_data_moon_minings as $data) {
            array_push($chart_data2, $data->volume);
        }

        return view('corpminingtax::corpminingstatistics', [
            'total_minings' => $total_minings,
            'total_members' => $total_members,
            'total_event_price' => $events->price,
            'top_ten_miners' => $top_ten_miners,
            'top_ten_miners_last_month' => $top_ten_miners_last_month,
            'chart_labels' => $chart_labels,
            'chart_data_over_all' => $chart_data1,
            'chart_data_moon_minings' => $chart_data2,
        ]);
    }
}