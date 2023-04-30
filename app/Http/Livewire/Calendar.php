<?php

namespace App\Http\Livewire;

use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class Calendar extends Component
{
    public string $currentDate;
    public array $currentWeek = [];
    public string $day;
    public string $checkDay;
    public string $dayOfWeek;
    public Carbon $sevenDaysLater;
    public Collection $events;

    public function mount()
    {
        $this->currentDate = Carbon::today()->format('Y-m-d');
        $this->sevenDaysLater = Carbon::today()->addDays(7);

        for ($i = 0; $i < 7; $i++) {
            $this->day = Carbon::today()->addDays($i)->format('m月d日');
            $this->checkDay = Carbon::today()->addDays($i)->format('Y-m-d');
            $this->dayOfWeek = Carbon::today()->addDays($i)->dayName;
            array_push($this->currentWeek, [
                'day' => $this->day,
                'checkDay' => $this->checkDay,
                'dayOfWeek' => $this->dayOfWeek,
            ]);
        }
    }

    public function getDate(string $date)
    {
        $this->currentDate = $date;
        $this->sevenDaysLater = Carbon::parse($date)->addDays(7);
        $this->currentWeek = [];

        for ($i = 0; $i < 7; $i++) {
            $this->day = Carbon::parse($date)->addDays($i)->format('m月d日');
            $this->checkDay = Carbon::parse($date)->addDays($i)->format('Y-m-d');
            $this->dayOfWeek = Carbon::parse($date)->addDays($i)->dayName;
            array_push($this->currentWeek, [
                'day' => $this->day,
                'checkDay' => $this->checkDay,
                'dayOfWeek' => $this->dayOfWeek,
            ]);
        }
    }

    public function render()
    {
        $this->events = Event::query()
            ->whereBetween('start_date', [$this->currentDate, $this->sevenDaysLater->format('Y-m-d')])
            ->orderBy('start_date')
            ->get();

        return view('livewire.calendar');
    }
}
