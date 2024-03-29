<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            イベント詳細
        </h2>
    </x-slot>

    <div class="pt-4 pb-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="max-w-2xl py-4 mx-auto">
                    <x-validation-errors class="mb-4" />

                    @if (session('status'))
                    <div class="mb-4 font-medium text-sm text-green-600">
                        {{ session('status') }}
                    </div>
                    @endif

                    <div>
                        <x-label for="event_name" value="イベント名" />
                        {{ $event->name }}
                    </div>

                    <div class="mt-4">
                        <x-label for="information" value="イベント詳細" />
                        {!! nl2br(e($event->information)) !!}
                    </div>

                    <div class="md:flex justify-between">
                        <div class="mt-4">
                            <x-label for="event_date" value="イベント日付" />
                            {{ $event->eventDate }}
                        </div>

                        <div class="mt-4">
                            <x-label for="start_time" value="開始時間" />
                            {{ $event->startTime }}
                        </div>

                        <div class="mt-4">
                            <x-label for="end_time" value="終了時間" />
                            {{ $event->endTime }}
                        </div>
                    </div>

                    <form method="post" action="{{ route('mypage.cancel', ['id' => $event->id]) }}">
                        @csrf
                        <div class="md:flex justify-between items-end">
                            <div class="mt-4">
                                <x-label value="予約人数" />
                                {{ $event->reservedPeople }}
                            </div>

                            @if ($event->eventDate >= \Carbon\Carbon::today()->format('Y年m月d日'))
                            <x-button class="ml-4" onclick="return confirm('本当にキャンセルしてもよろしいですか？');">
                                キャンセルする
                            </x-button>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>