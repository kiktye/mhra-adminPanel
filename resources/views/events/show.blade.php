<x-layout>

    <div class="flex flex-row p-4 space-x-4 items-start w-screen">
        <div class="flex-grow rounded bg-white border border-gray-300 shadow-lg">
            <div class="flex flex-col p-6">

                <span class="text-xl text-center">Настан (Event) {{ $event->title }} </span>

                <div class="mt-4 mx-auto">
                    <div class="flex justify-around items-center">
                        {{-- image --}}
                        <div class="flex flex-col items-center">
                            <img src="{{ asset('storage/' . $event->photo_path) }}" alt=""
                                class="w-[550px] h-[350px] object-contain rounded-xl">
                        </div>

                        {{-- main title --}}
                        <div class="my-2 max-w-[800px]">
                            <h1 class="font-bold text-xl">{{ $event->title }}</h1>
                        </div>
                    </div>

                    <div class="mt-5 border-b border-gray-300"></div>

                    {{-- title and thene --}}
                    <div class="my-2 flex justify-center space-x-10 items-center">
                        <h1 class="font-bold text-xl min-w-[200px]">{{ $event->title }}</h1>
                        <p class="text-sm font-semibold text-slate-700 max-w-[800px]">
                            Тема на настанот: <span class="text-accent"> {{ $event->theme }}</span>
                        </p>
                    </div>

                    <div class="mt-5 border-b border-gray-300"></div>

                    {{-- objective and description --}}
                    <div class="my-2 flex justify-center">
                        <p class="max-w-[800px]"> Опис: {{ $event->description }}</p>
                        <p class="max-w-[800px]"> Цел: {{ $event->objective }}</p>
                    </div>


                    <x-page-heading>Агенда</x-page-heading>
                    <div class="my-6 p-4">
                        @foreach ($event->agenda->days as $day)
                            <div class="mb-6">
                                <h2 class="text-2xl font-bold">{{ $day['date'] }}</h2>
                                {{-- Loop through sections within the day --}}
                                @foreach ($day['sections'] as $section)
                                    <div class="flex items-center space-x-4">
                                        <h3 class="text-xl font-semibold">{{ $section['hour'] }}</h3>
                                        <div class="flex flex-col">
                                            <p class="font-semibold text-md max-w-[800px]">{{ $section['title'] }}</p>

                                            {{-- Check if subtitles exist --}}
                                            @if (isset($section['subtitle']) && is_array($section['subtitle']))
                                                @foreach ($section['subtitle'] as $subtitle)
                                                    <p class="max-w-[800px]">{{ $subtitle }}</p>
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endforeach
                    </div>
                </div>

                <x-forms.divider />

                <x-page-heading>Цена на карти</x-page-heading>
                <div class="flex items-center justify-around">
                    @foreach ($tickets as $ticket)
                        <div>
                            <h3 class="text-xl font-semibold">{{ $ticket['type'] }}</h3>

                            <p class="text-gray-700 text-xl text-center">{{ $ticket['price'] }}</p>
                        </div>
                    @endforeach
                </div>

                <x-forms.divider />

                <x-page-heading>Говорници на настанот</x-page-heading>
                <div class="flex items-center">
                    @foreach ($event->speakers as $speaker)
                        <div class="w-[20%] mx-auto rounded border border-gray-300 shadow-lg mt-2">
                            <div class="flex flex-col p-6">
                                <div class="flex flex-row justify-between space-x-4 items-center">
                                    <img src="{{ $speaker->photo_path }}" alt="will upload later"
                                        class="relative inline-block h-12 w-12 rounded-full object-cover object-center" />
                                </div>

                                <div class="self-start items-start">
                                    <h1 class="font-bold italic text-xl">{{ $speaker->name }}
                                        {{ $speaker->surname }}</h1>
                                    <p>{{ $speaker->title }}</p>
                                    <p class="text-sm font-semibold text-slate-700">
                                        @php
                                            $socialLinks = json_decode($speaker->social_links, true);
                                        @endphp
                                        @foreach ($socialLinks as $link)
                                            <a href="{{ $link['link'] }}" target="_blank">{{ $link['platform'] }}</a>
                                        @endforeach
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>


            </div>
        </div>
    </div>

</x-layout>
