<?php

namespace App\Http\Livewire;

use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class Calendar extends Component
{
    public Carbon $currentDate;
    public array $currentWeek = [];
    public string $day;
    public Carbon $sevenDaysLater;
    public Collection $events;

    public function mount()
    {
        $this->currentDate = Carbon::today();
        $this->sevenDaysLater = Carbon::today()->addDays(7);

        for ($i = 0; $i < 7; $i++) {
            $this->day = Carbon::today()->addDays($i)->format('m月d日');
            array_push($this->currentWeek, $this->day);
        }
    }

    public function getDate(string $date)
    {
        $this->currentDate = Carbon::parse($date);
        $this->sevenDaysLater = Carbon::parse($date)->addDays(7);
        $this->currentWeek = [];

        for ($i = 0; $i < 7; $i++) {
            $this->day = Carbon::parse($date)->addDays($i)->format('m月d日');
            array_push($this->currentWeek, $this->day);
        }
    }

    public function render()
    {
        $this->events = Event::query()
            ->whereBetween('start_date', [$this->currentDate->format('Y-m-d'), $this->sevenDaysLater->format('Y-m-d')])
            ->orderBy('start_date')
            ->get();

        return view('livewire.calendar');
    }
}
