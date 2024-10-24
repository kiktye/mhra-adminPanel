<x-layout>


    <div class="p-10">
        <div class="flex space-x-10">

            <div>
                <img class="w-60 h-60 mx-auto rounded-b-full" src="{{ asset('storage/' . $president->photo_path) }}"
                    alt="" />
            </div>

            <div>
                <h2 class="text-2xl font-semibold text-gray-700"> {{ $president->name }}
                    {{ $president->surname }} </h2>
                <span class="text-accent text-sm block mb-2"> {{ $president->title }} </span>

                <div class="flex flex-col max-w-[850px] border-b border-black">
                    <h1 class=" font-medium">
                        @php
                            $descriptions = json_decode($president->description, true);
                        @endphp
                        @foreach ($descriptions as $description)
                            <div class="flex flex-col mb-3">
                                {{ $description }}
                            </div>
                        @endforeach
                    </h1>

                </div>
            </div>

        </div>

        <!-- component -->
        <div id="container" class="w-4/5 mx-auto">
            <div class="flex flex-col sm:flex-row">

                @foreach ($employees as $employee)
                    <div class="sm:w-1/4 p-2">
                        <div class="bg-white px-6 py-8 rounded-lg shadow-lg text-center">
                            <div class="mb-3">
                                {{ $employee->role->name }}

                                <img class="w-auto mx-auto rounded-full"
                                    src=" {{ asset('storage/' . $employee->photo_path) }}" alt="" />
                            </div>
                            <h2 class="text-xl font-medium text-gray-700">{{ $employee->name }} {{ $employee->surname }}
                            </h2>
                            <span class="text-accent block mb-5"> {{ $employee->title }} </span>

                            @php
                                $socialLinks = json_decode($employee->social_links, true);
                            @endphp
                            @foreach ($socialLinks as $link)
                                <a href="{{ $link['link'] }}" target="_blank"><i
                                        class="fa-brands fa-{{ $link['platform'] }}"></i></a>
                            @endforeach
                        </div>
                    </div>
                @endforeach



            </div>
        </div>
    </div>

</x-layout>
