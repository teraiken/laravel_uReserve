<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    public function dashboard()
    {
        return view('dashboard');
    }

    public function detail($id)
    {
        $event = Event::query()->findOrFail($id);

        return view('event-detail', compact('event'));
    }

    public function reserve(Request $request)
    {
        $event = Event::query()->findOrFail($request->id);

        if ($event->max_people >= $event->reservedPeople + $request->reserved_people) {
            Reservation::create([
                'user_id' => Auth::id(),
                'event_id' => $event->id,
                'number_of_people' => $request->reserved_people,
            ]);

            session()->flash('status', '登録okです');

            return to_route('dashboard');
        } else {
            session()->flash('status', 'この人数は予約できません。');

            return view('dashboard');
        }
    }
}
