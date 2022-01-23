<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Subscribe;
use App\Material;
use Carbon\Carbon;
class SubscribeController extends Controller
{
    public function index(){
        $subscribes = auth()->user()->subscribes;
        //$materials = Material::all();
        $last = auth()->user()->subscribes()->latest('end')->first();
        $active = $subscribes->where('end', '>=', Carbon::now())->first();
        $now = Carbon::now();
        return view('teacher.subscribe', compact('subscribes', 'last', 'active', 'now'));
    }
    public function store(Request $request){
        $prices = [
            '1' => 300,
            '3' => 850,
            '6' => 1650,
            '12' => 3300
        ];
        $request->validate([
            'months' => 'required|in:1,3,6,12'
        ]);
        $user = auth()->user();
        $active = $user->subscribes()->where('end', '>=', Carbon::now())->first();
        $months = $request->months;
        if($active){
            session()->flash('success', 'У вас уше имеется активная подписка.');
            return back();
        }
        if($user->balance < $prices[$months]){
            session()->flash('error', 'На вашем счету недостаточно средств.');
            return back();
        }
        $user->subscribes()->create([
            'start' => Carbon::now()->toDateTimeString(),
            'end' => Carbon::now()->addMonths($months)->toDateTimeString(),
            'months' => $months
        ]);
        session()->flash('success', 'Подписка успешно оформлена');
        return back();
    }
}
