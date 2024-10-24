<x-layout>
    {{-- @dd($speaker) --}}
    <div class="flex flex-col lg:flex-row p-4 space-y-4 lg:space-y-0 lg:space-x-4 items-start w-screen">
        <!-- info -->
        <div class="space-y-4 w-full lg:w-auto">

            {{-- Conference --}}
            <div class="top-4 rounded bg-white border border-gray-300 shadow-lg">
                <div class="flex flex-col p-6 space-y-0.5">
                    <div class="flex flex-col justify-between">
                        <div class="text-xl">Говорник за:</div>
                        <h2>
                            @if ($speaker->event == null && $speaker->conference == null)
                                <x-modal :trigger="$speaker->id" :button="'Запиши за настан'">
                                    <x-forms.form method="POST" action="{{ route('speakers.update', $speaker->id) }}">
                                        @method('PATCH')

                                        <x-forms.checkbox label="Запиши како Специјален гостин" name="is_special_guest"
                                            id="is_special_guest" value="1" />

                                        <x-forms.divider />

                                        {{-- define the speaker to event: --}}
                                        <div id="event-select">
                                            <x-forms.select label="Запиши за настан" name="event_id">
                                                <option value="">Одбери настан</option>
                                                {{-- displaying each event name in the dropdown --}}
                                                @foreach ($events as $event)
                                                    <option value="{{ $event->id }}">{{ $event->title }}
                                                        ({{ $event->date }})
                                                    </option>
                                                @endforeach
                                            </x-forms.select>
                                        </div>

                                        {{-- define the speaker to event: --}}
                                        <div id="conference-select">
                                            <x-forms.select label="Запиши за конференција" name="conference_id">
                                                <option value="">Одбери конференција</option>
                                                {{-- displaying each event name in the dropdown --}}
                                                @foreach ($conferences as $conference)
                                                    <option value="{{ $conference->id }}">
                                                        {{ $conference->title }}</option>
                                                @endforeach
                                            </x-forms.select>
                                        </div>
                                        <x-forms.button type="submit">Зачувај</x-forms.button>
                                    </x-forms.form>
                                </x-modal>
                            @else
                                @if ($speaker->conference && $speaker->event)
                                    <div class="flex flex-col text-sm font-bold">
                                        <span>{{ $speaker->event->title }} и</span>
                                        <span>{{ $speaker->conference->title }}
                                    </div>
                                    </span>
                                @elseif ($speaker->conference)
                                    <span class="font-bold">{{ $speaker->conference->title }}</span>
                                @elseif ($speaker->event)
                                    <span class="font-bold"> {{ $speaker->event->title }}</span>
                                @endif
                            @endif
                        </h2>
                    </div>
                </div>
            </div>

            <div class="top-4 rounded bg-white border border-gray-300 shadow-lg">
                <div class="flex flex-col p-6 space-y-0.5">
                    <div class="flex flex-col justify-between">
                        <div class="text-xl">Говорникот е специјален гостин за:</div>
                        <h2 class="font-bold">
                            @if ($speaker->is_special_guest)
                                <span class="font-semibold">{{ $speaker->conference->title }}</span>
                            @else
                                <span class="text-sm font-medium text-gray-400 italic">Не е Special Guest.</span>
                            @endif
                        </h2>
                    </div>


                </div>
            </div>

            {{-- Back to usrs Button --}}
            <div class="top-4 rounded bg-white border border-gray-300 shadow-lg">
                <div class="flex flex-col justify-between p-4 text-center">
                    <a href="{{ route('speakers.index') }}" class="text-sm font-semibold">Назад кон сите говорници</a>
                </div>
            </div>
        </div>

        <!-- Manage User Info Section -->
        <div class="flex-grow w-full lg:w-auto rounded bg-white border border-gray-300 shadow-lg">
            <div class="flex flex-col p-4 lg:p-6">
                <span class="text-lg lg:text-xl">Управувај со податоци на говорник</span>
                <div class="mt-4">

                    {{-- section to show photo + delete/edit buttons --}}
                    <div class="flex flex-col items-center">

                        {{-- user photo --}}
                        <img src="{{ asset('storage/' . $speaker->photo_path) }}" alt=""
                            class="w-[550px] h-[350px] object-contain rounded-xl">
                        <div class="flex space-x-2 items-center">

                            {{-- If photo exists show delete button --}}
                            @if ($speaker->photo_path)
                                <x-forms.form method="POST"
                                    action="{{ route('speakers.delete.image', $speaker->id) }}">
                                    @method('DELETE')
                                    <button
                                        class="rounded-md bg-slate-800 py-1.5 px-2 text-2xs font-semibold text-white shadow-md">Избриши
                                        слика
                                    </button>
                                </x-forms.form>
                            @endif

                            {{-- Edit photo pop up with form in it --}}
                            <x-modal :trigger="$speaker->id" :button="'Промени слика'">
                                <x-forms.form method="POST"
                                    action="{{ route('speakers.update.image', $speaker->id) }}"
                                    enctype="multipart/form-data">
                                    @method('PATCH')

                                    <x-forms.input label="Слика на говорник" name="photo_path" type="file" />

                                    <x-forms.button type="submit">Зачувај</x-forms.button>
                                </x-forms.form>
                            </x-modal>
                        </div>
                    </div>
                </div>

                <div class="mt-5 border-b border-gray-300"></div>

                {{-- section to manage informations --}}
                <div class="flex flex-col lg:flex-row justify-center items-center my-6 space-y-4 lg:space-y-0">
                    <div class="my-2 text-center lg:text-left">
                        <h1 class="font-bold text-lg lg:text-xl"> <span class="text-sm italic">Име |</span>
                            {{ $speaker->name }}</h1>

                        <h1 class="font-bold text-lg lg:text-xl"> <span class="text-sm italic">Презиме |</span>
                            {{ $speaker->surname }}</h1>

                        <h1 class="font-bold text-lg lg:text-xl"> <span class="text-sm italic">Title |</span>
                            {{ $speaker->title }}</h1>

                        {{-- edit form modal pop up --}}
                        <x-modal :trigger="$speaker->id" :button="'Измени'">
                            <x-forms.form method="POST"
                                action="{{ route('speakers.update.credentials', $speaker->id) }}">
                                @method('PATCH')

                                <x-forms.input label="Име" name="name"
                                    value="{{ old('name', $speaker->name) }}" />

                                <x-forms.input label="Презиме" name="surname"
                                    value="{{ old('surname', $speaker->surname) }}" />

                                <x-forms.input label="Title" name="title"
                                    value="{{ old('title', $speaker->title) }}" />

                                <x-forms.button type="submit">Зачувај промени</x-forms.button>
                            </x-forms.form>
                        </x-modal>
                    </div>
                </div>

                <div class="mt-5 border-b border-gray-300"></div>

                <div class="flex flex-col items-center">
                    {{-- social media links --}}
                    <div class="flex flex-col items-center justify-center my-6">
                        <p class="text-sm font-semibold text-slate-700 flex items-center space-x-4">

                            @foreach ($socialLinks as $link)
                                <a href="{{ $link['link'] }}" target="_blank" class="text-3xl hover:text-accent"> <i
                                        class="fa-brands fa-{{ $link['platform'] }}"></i></a>
                            @endforeach

                        </p>

                        <x-modal :trigger="$speaker->id" :button="'Промени линкови'">
                            <x-forms.form method="POST" action="{{ route('speakers.update.links', $speaker->id) }}"
                                enctype="multipart/form-data">
                                @method('PATCH')

                                @foreach ($socialLinks as $index => $link)
                                    <div class="flex space-x-2">
                                        <x-forms.input label="Платформа"
                                            name="social_links[{{ $index }}][platform]"
                                            value="{{ $link['platform'] }}" />
                                        <x-forms.input label="URL" name="social_links[{{ $index }}][link]"
                                            value="{{ $link['link'] }}" />
                                    </div>
                                @endforeach
                                <x-forms.button type="submit">Зачувај</x-forms.button>
                            </x-forms.form>
                        </x-modal>
                    </div>
                </div>

                <p
                    class="text-sm font-semibold text-slate-700 flex items-center justify-center lg:justify-start my-10">
                    Говорникот е креиран на : {{ $speaker->created_at->format('M d, Y') }}
                </p>

                <div class="mt-5 border-b border-gray-300"></div>


                {{-- button/form to delete entire user --}}
                <div class="rounded mt-4 bg-white border border-gray-300 shadow-lg p-4 text-center">
                    <x-forms.form class="space-y-0" method="POST"
                        action="{{ route('speakers.destroy', $speaker->id) }}"
                        onsubmit="return confirm('Дали си сигурен дека сакаш да го избришеш овој Говорник?');">
                        @method('DELETE')

                        <button class="text-sm font-semibold border-b-2 border-red-600" type="submit">Избриши
                            говорник</button>
                    </x-forms.form>
                </div>

            </div>
        </div>
    </div>



    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const isSpecialGuest = document.getElementById('is_special_guest');
            const eventSelect = document.getElementById('event-select');
            const conferenceSelect = document.getElementById('conference-select');
            const eventInput = document.getElementById('event_id');
            const conferenceInput = document.getElementById('conference_id');

            function toggleSelects() {
                if (isSpecialGuest.checked) {
                    eventSelect.classList.add('hidden');
                    eventInput.value = '';
                } else {
                    eventSelect.classList.remove('hidden');
                }
            }

            isSpecialGuest.addEventListener('change', toggleSelects);
        });
    </script>
</x-layout>
