<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Reservation;
use App\Services\MyPageService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class MyPageController extends Controller
{
    public function index()
    {
        $events = Auth::user()->events;
        $fromTodayEvents = MyPageService::reservedEvent($events, 'fromToday');
        $pastEvents = MyPageService::reservedEvent($events, 'past');

        return view('mypage/index', compact('fromTodayEvents', 'pastEvents'));
    }

    public function show($id)
    {
        $event = Event::query()->findOrFail($id);

        return view('mypage/show', compact('event'));
    }

    public function cancel($id)
    {
        $reservation = Reservation::query()
            ->where('user_id', '=', Auth::id())
            ->where('event_id', '=', $id)
            ->latest()
            ->firstOrFail();

        $reservation->canceled_date = Carbon::now()->format('Y-m-d H:i:s');
        $reservation->save();

        session()->flash('status', 'キャンセルしました。');

        return to_route('dashboard');
    }
}
