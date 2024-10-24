<x-layout>


    @php
        $generalInfo = \App\Models\GeneralInfo::first();
    @endphp

    <div class="p-4 text-center w-full mx-auto">
        <x-page-heading>Добредојде</x-page-heading>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">

            <a href=" {{ route('blogs.userIndex') }} ">
                <div class="text-xl font-medium  rounded bg-white border border-gray-300 p-6 shadow-lg">
                    Блогови
                </div>
            </a>

            <a href=" {{ route('events.userIndex') }} ">
                <div class="text-xl font-medium  rounded bg-white border border-gray-300 p-6 shadow-lg">
                    Настани
                </div>
            </a>

            @php
                $conference = \App\Models\Conference::all()->first();
            @endphp


            @if ($conference->status == 'active')
                <a href="{{ route('conferences.userShow', $conference) }}">
                    <div class="text-xl font-medium rounded bg-white border border-gray-300 p-6 shadow-lg">
                        Годишна Конференција
                    </div>
                </a>
            @else
                <div class="text-xl font-medium rounded bg-white border border-gray-300 p-6 shadow-lg">
                    Нема активна конференција
                </div>
            @endif


            <a href=" {{ route('employees.userIndex') }} ">
                <div class="text-xl font-medium  rounded bg-white border border-gray-300 p-6 shadow-lg">
                    Запознај не
                </div>
            </a>

        </div>

        <div class="flex flex-col items-center my-10">

            <img src="{{ asset('storage/' . $generalInfo->photo_path) }}" alt=""
                class="w-[550px] h-[350px] object-contain rounded-xl">


            <h1 class="font-bold text-xl">{{ $generalInfo->title }}</h1>
            <h1 class="font-bold uppercase text-2xl">{{ $generalInfo->subtitle }}</h1>

            <p class="text-sm font-semibold text-slate-700">
                @php
                    $socialLinks = json_decode($generalInfo->social_links, true);

                @endphp

                @foreach ($socialLinks as $link)
                    <a href="{{ $link['link'] }}" target="_blank" class="text-3xl space-x-4 hover:text-accent"> <i
                            class="fa-brands fa-{{ $link['platform'] }}"></i></a>
                @endforeach
            </p>
        </div>

    </div>

</x-layout>
