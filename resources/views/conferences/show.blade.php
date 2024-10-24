<x-layout>

    <div class="flex flex-row p-4 space-x-4 items-start w-screen">
        <div class="flex-grow rounded bg-white border border-gray-300 shadow-lg">
            <div class="flex flex-col p-6">

                <span class="text-xl text-center">Настан : {{ $conference->title }} </span>      



                <div class="mt-4 mx-auto">
                    <div class="flex justify-around items-center space-x-10">
                        {{-- image --}}
                        <div class="flex flex-col items-center">
                            <img src="{{ asset('storage/' . $conference->photo_path) }}" alt=""
                                class="w-[550px] h-[350px] object-contain rounded-xl">
                        </div>

                        {{-- info --}}
                        <div class="mt-4 ">
                            <h1 class="font-bold italic text-md"> {{ $conference->location }} </h1>
                            <p class="text-sm font-semibold text-slate-700 flex flex-col">
                                Конференцијата се оддржува на:
                                <span>{{ \Carbon\Carbon::parse($conference->start_date)->format('d') }} -
                                    {{ \Carbon\Carbon::parse($conference->end_date)->format('d M Y') }}</span>
                            </p>
                        </div>
                    </div>

                    <div class="my-5 border-b border-gray-300"></div>

                    {{-- title --}}
                    <div class="flex justify-center space-x-10 items-center">
                        <h1 class="font-bold text-xl min-w-[200px]">{{ $conference->title }}</h1>
                    </div>

                    <div class="my-5 border-b border-gray-300"></div>

                    {{-- objective and description --}}
                    <div class="my-10 flex justify-center">
                        <p class="max-w-[800px]"> Опис: {{ $conference->description }}</p>
                    </div>


                    <x-page-heading>Агенда</x-page-heading>
                    <div class="my-6 p-4">
                        @foreach ($conference->agenda->days as $day)
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
                        <div class="flex flex-col items-center">
                            <h3 class="text-xl font-semibold">{{ $ticket['type'] }}</h3>

                            <p class="text-gray-700 text-xl text-center border-b-2 border-slate-300">
                                {{ $ticket['price'] }}</p>

                            <ul class="list-disc">
                                @foreach ($ticket['option'] as $option)
                                    <li>{{ $option }}</li>
                                @endforeach
                            </ul>

                        </div>
                    @endforeach
                </div>

                <x-forms.divider />

                <x-page-heading>Говорници на настанот</x-page-heading>
                <div class="flex items-center justify-around mb-4">
                    @foreach ($conference->speakers->where('is_special_guest', 0) as $speaker)
                        <div class="top-4 rounded bg-white border border-gray-300 shadow-lg">
                            <div class="flex flex-col p-6">
                                <div class="flex flex-row justify-between space-x-4 items-center">
                                    <div class="text-xl">Информации за говорник</div>
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


                <x-page-heading>Специјални гости на настанот</x-page-heading>
                <div class="flex items-center justify-around">
                    @foreach ($conference->speakers->where('is_special_guest', true) as $speaker)
                        <div class="top-4 rounded bg-white border border-gray-300 shadow-lg">
                            <div class="flex flex-col p-6">
                                <div class="flex flex-row justify-between space-x-4 items-center">
                                    <div class="text-xl">Информации за специјален гостин</div>
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
