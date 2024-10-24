<x-layout>

    <div class="space-y-4 flex flex-col items-center p-10">
        @foreach ($events as $event)
            @if ($event->is_featured == 1)
                <div class="rounded bg-white border border-gray-300 shadow-lg">
                    <div class="flex flex-col pt-6 pb-1 px-6">
                        <div class="flex flex-row justify-between space-x-4 items-center">
                            <div class="text-xl">Истакнат евент</div>
                        </div>

                        <div class="mt-4 items-center">
                            <h1 class="font-bold italic text-xl">{{ $event->title }}
                            </h1>
                            <p class="text-sm font-semibold text-slate-700">
                                | {{ $event->date }}
                            </p>


                        </div>
                        <a class="self-end mt-4 bg-accent p-2 text-white rounded-xl text-xs"
                            href="{{ route('events.userShow', $event->id) }}">Прочитај
                            повеќе</a>

                    </div>
                </div>
            @else
                <div class="top-4 rounded bg-white border border-gray-300 shadow-lg">
                    <div class="flex pt-6 pb-1 px-6">
                        <div class="mt-4 items-center">
                            <h1 class="font-bold italic text-xl">{{ $event->title }}
                            </h1>
                            <p class="text-sm font-semibold text-slate-700">
                                {{ $event->date }}
                            </p>
                        </div>
                        <a class="self-end mt-4 bg-accent p-2 text-white rounded-xl text-xs"
                            href="{{ route('events.userShow', $event->id) }}">Прочитај
                            повеќе</a>
                    </div>
                </div>
            @endif
        @endforeach

    </div>




</x-layout>
