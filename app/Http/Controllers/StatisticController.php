<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Companies;

class StatisticController extends Controller
{
    public function show(Request $request) {

        $companieModel = new Companies();

        $statisticData = $request->only('userId', 'year', 'status');

        $statistic = $companieModel->getStatistic($statisticData);

        return response()->json(['status'=>'success', 'statistic'=> $statistic], 200);
    }
}
