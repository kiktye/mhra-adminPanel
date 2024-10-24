<x-layout>
    <div class="flex flex-col md:flex-row p-4 space-y-4 md:space-y-0 md:space-x-4 items-start w-screen">
        <!-- Basic Info Section (stacked for mobile) -->
        <div class="flex flex-col space-y-4 w-full lg:w-auto">
            <!-- Event Location and Date Info -->
            <div class="rounded bg-white border border-gray-300 shadow-lg">
                <div class="flex flex-col p-6 space-y-1.5">
                    <div class="text-xl">Информации за настан</div>

                    <div class="mt-4 self-start items-start">
                        <h1 class="font-bold italic text-md"> {{ $event->location }} </h1>
                        <p class="text-sm font-semibold text-slate-700">
                            Настанот се оддржува на: {{ $event->date }}
                        </p>
                    </div>

                    <x-modal :trigger="$event->id" :button="'Измени информации'">
                        <x-forms.form method="POST" action="{{ route('events.update.info', $event->id) }}">
                            @method('PATCH')
                            <x-forms.input label="Локација на настан" name="location"
                                value="{{ old('location', $event->location) }}" />
                            <x-forms.input type="date" label="Датум на настан" name="date"
                                value="{{ old('date', $event->date) }}" />
                            <x-forms.button type="submit">Зачувај промени</x-forms.button>
                        </x-forms.form>
                    </x-modal>
                </div>
            </div>

            <!-- Event Speaker Infos -->
            <div class="rounded bg-white border border-gray-300 shadow-lg">
                <div class="flex flex-col p-6 space-y-1.5">
                    <div class="text-xl">Говорници на настан</div>
                    <h2>Овој настан има <span class="font-semibold">{{ $event->speakers->count() }}</span> говорници
                    </h2>

                    <x-modal :trigger="$event->id" :button="'Види говорници'">
                        @foreach ($event->speakers as $speaker)
                            <div class="rounded bg-white border border-gray-300 shadow-lg">
                                <div class="flex flex-col p-6">
                                    <div class="flex flex-row justify-between space-x-4 items-center">
                                        <div class="text-xl">Информации за говорник</div>
                                        <img src="{{ asset('storage/' . $speaker->photo_path) }}" alt="Speaker Photo"
                                            class="h-12 w-12 rounded-full object-cover" />
                                    </div>
                                    <div class="self-start items-start">
                                        <h1 class="font-bold italic text-xl">{{ $speaker->name }}
                                            {{ $speaker->surname }}</h1>
                                        <p>{{ $speaker->title }}</p>
                                        <p class="text-sm font-semibold text-slate-700">
                                            @foreach (json_decode($speaker->social_links, true) as $link)
                                                <a href="{{ $link['link'] }}"
                                                    target="_blank">{{ $link['platform'] }}</a>
                                            @endforeach
                                        </p>
                                    </div>

                                    <x-forms.form class="space-y-0" method="POST"
                                        action="{{ route('speakers.remove.from.event', $speaker->id) }}">
                                        @method('PATCH')

                                        <button class="text-xs font-semibold border-b-2 border-red-600"
                                            type="submit">Отстрани говорник од настан</button>
                                    </x-forms.form>
                                </div>
                            </div>
                        @endforeach
                    </x-modal>
                </div>
            </div>

            <!-- Ticket Pricing Info -->
            <div class="rounded bg-white border border-gray-300 shadow-lg">
                <div class="flex flex-col p-6 space-y-1.5">
                    <div class="text-xl">Цена на карти</div>
                    <div class="flex items-center justify-around">
                        @foreach ($tickets as $ticket)
                            <div>
                                <h3 class="text-xl font-semibold">{{ $ticket['type'] }}</h3>
                                <p class="text-gray-700 text-xl text-center">{{ $ticket['price'] }}</p>
                            </div>
                        @endforeach
                    </div>

                    <x-modal :trigger="$event->id" :button="'Промени цени'">
                        <x-forms.form method="POST" action="{{ route('events.update.prices', $event->id) }}">
                            @method('PATCH')
                            @foreach ($tickets as $index => $ticket)
                                <div id="ticket-prices-section" class="p-4">
                                    <div class="ticket-price mb-3">
                                        <x-forms.input label="Ticket For"
                                            name="ticket_prices[{{ $index }}][type]"
                                            value="{{ old('ticket_prices[0][type]', $ticket['type']) }}" />
                                        <x-forms.input label="Ticket Price"
                                            name="ticket_prices[{{ $index }}][price]"
                                            value="{{ old('ticket_prices[0][price]', $ticket['price']) }}" />
                                    </div>
                                </div>
                            @endforeach
                            <x-forms.button type="submit">Зачувај промени</x-forms.button>
                        </x-forms.form>
                    </x-modal>
                </div>
            </div>

            <!-- Back to Events Button -->
            <div class="rounded bg-white border border-gray-300 shadow-lg">
                <div class="p-4 text-center">
                    <a href="{{ route('events.index') }}" class="text-sm font-semibold">Назад кон сите настани</a>
                </div>
            </div>
        </div>

        <!-- Event Info Section -->
        <div class="flex-grow rounded bg-white border border-gray-300 shadow-lg w-full md:w-2/3">
            <div class="flex flex-col p-6">
                <span class="text-xl">Управувај со настанот</span>

                <div class="mt-4">
                    {{-- Event Photo --}}
                    <div class="flex flex-col items-center space-y-4">
                        @if ($event->is_featured == true)
                            Овој настан е Истакнат
                        @else
                            Овој настан не е Истакнат

                            <form method="POST" action="{{ route('events.feature', $event->id) }}">
                                @method('PATCH')
                                @csrf
                                <button
                                    class="rounded-md bg-slate-800 py-0.5 px-2 text-2xs font-semibold text-white shadow-md">Истакни
                                    настан
                                </button>
                            </form>
                        @endif
                        <img src="{{ asset('storage/' . $event->photo_path) }}" alt=""
                            class="w-[550px] h-[350px] object-contain rounded-xl">

                        <div class="flex items-center space-x-4">
                            {{-- If photo is set display Delete button --}}
                            @if ($event->photo_path)
                                <x-forms.form method="POST" action="{{ route('events.delete.image', $event->id) }}">
                                    @method('DELETE')

                                    <button
                                        class="rounded-md bg-slate-800 py-1.5 px-2 text-2xs font-semibold text-white shadow-md">Избриши
                                        слика
                                    </button>
                                </x-forms.form>
                            @endif

                            {{-- if there is photo pop up with form ( this form also adds new photo) --}}
                            <x-modal :trigger="$event->id" :button="'Промени слика'">
                                <x-forms.form method="POST" action="{{ route('events.update.image', $event->id) }}"
                                    enctype="multipart/form-data">
                                    @method('PATCH')

                                    <x-forms.input label="Истакната слика на настан" name="photo_path" type="file" />

                                    <x-forms.button type="submit">Зачувај</x-forms.button>
                                </x-forms.form>
                            </x-modal>
                        </div>
                    </div>

                    {{-- manage title and theme section --}}
                    <div class="my-5 flex flex-col items-center space-y-5">
                        {{-- display title and theme --}}
                        <div
                            class="flex flex-col md:flex-row items-center justify-center md:justify-around text-center space-y-10 md:space-x-4">

                            <div class="flex flex-col max-w-[550px] md:mr-[150px]">
                                <span class="text-lg italic font-semibold">Title на настан</span>
                                <h1 class="font-bold text-xl">{{ $event->title }}</h1>
                            </div>

                            <div class="flex flex-col max-w-[550px]">
                                <span class="text-lg italic font-semibold">Тема на настан</span>
                                <h1 class=" font-medium"> {{ $event->theme }}</h1>
                            </div>
                        </div>

                        {{-- pop up form for editing title and theme --}}
                        <x-modal :trigger="$event->id" :button="'Измени'">
                            <x-forms.form method="POST" action="{{ route('events.update.mainInfo', $event->id) }}">
                                @method('PATCH')

                                <x-forms.input label="Title" name="title"
                                    value="{{ old('title', $event->title) }}" />

                                <x-forms.textarea label="Тема на настан" name="theme"
                                    value="{{ old('theme', $event->theme ?? '') }}" />

                                <x-forms.button type="submit">Зачувај промени</x-forms.button>
                            </x-forms.form>
                        </x-modal>
                    </div>

                    <div class="mt-5 border-b border-gray-300"></div>

                    {{-- manage objective and description --}}
                    <div class="my-5 flex flex-col items-center space-y-5">
                        {{-- display objective and description --}}
                        <div
                            class="flex flex-col md:flex-row space-y-10 items-center justify-around text-center space-x-4">
                            <div class="flex flex-col">
                                <span class="text-lg italic font-semibold">Цел на настан</span>
                                <h1 class="font-medium max-w-[550px]">{{ $event->objective }}</h1>
                            </div>

                            <div class="flex flex-col">
                                <span class="text-lg italic font-semibold">Опис на настан</span>
                                <h1 class=" font-medium max-w-[550px]"> {{ $event->description }}</h1>
                            </div>
                        </div>

                        {{-- pop up form for editing objective and description --}}
                        <x-modal :trigger="$event->id" :button="'Измени'">
                            <x-forms.form method="POST" action="{{ route('events.update.content', $event->id) }}">
                                @method('PATCH')

                                <x-forms.textarea label="Цел на настан" name="objective"
                                    value="{{ old('objective', $event->objective ?? '') }}" />

                                <x-forms.textarea label="Опис на настан" name="description"
                                    value="{{ old('description', $event->description ?? '') }}" />

                                <x-forms.button type="submit">Зачувај промени</x-forms.button>
                            </x-forms.form>
                        </x-modal>
                    </div>

                    <div class="mt-5 border-b border-gray-300"></div>

                    {{-- agenda --}}
                    <div class="my-6 space-y-3">
                        {{-- display agenda for admin --}}
                        @foreach ($agenda->days as $day)
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

                        {{-- modal to edit agenda --}}
                        <x-modal :trigger="$event->id" :button="'Измени Агенда'">
                            <x-forms.form method="POST" action="{{ route('agendas.update', $event->agenda->id) }}">
                                @method('PATCH')
                                <x-forms.input label="Име на агенда" name="name"
                                    value="{{ old('name', $event->agenda->name) }}" />

                                <div id="agenda-days">
                                    {{-- Display each day in the form --}}
                                    @foreach ($event->agenda->days as $dayIndex => $day)
                                        <div class="day p-4 mb-6" id="day-{{ $dayIndex }}">
                                            <x-forms.input
                                                label="Ден (пр. Day {{ $dayIndex + 1 }} или {{ $day['date'] }})"
                                                name="days[{{ $dayIndex }}][date]"
                                                value="{{ old('days.' . $dayIndex . '.date', $day['date']) }}" />
                                            {{-- Display each section within the day --}}
                                            <div id="sections-{{ $dayIndex }}">
                                                @foreach ($day['sections'] as $sectionIndex => $section)
                                                    <div class="section p-4 mb-3"
                                                        id="section-{{ $dayIndex }}-{{ $sectionIndex }}">
                                                        <x-forms.input label="Час"
                                                            name="days[{{ $dayIndex }}][sections][{{ $sectionIndex }}][hour]"
                                                            value="{{ old('days.' . $dayIndex . '.sections.' . $sectionIndex . '.hour', $section['hour']) }}" />
                                                        <x-forms.input label="Точка"
                                                            name="days[{{ $dayIndex }}][sections][{{ $sectionIndex }}][title]"
                                                            value="{{ old('days.' . $dayIndex . '.sections.' . $sectionIndex . '.title', $section['title']) }}" />
                                                        <div id="subtitles-{{ $dayIndex }}-{{ $sectionIndex }}">
                                                            {{-- Check for subtitles within each section --}}
                                                            @if (isset($section['subtitle']) && is_array($section['subtitle']))
                                                                @foreach ($section['subtitle'] as $subIndex => $subtitle)
                                                                    <x-forms.textarea label="Потточка"
                                                                        name="days[{{ $dayIndex }}][sections][{{ $sectionIndex }}][subtitle][{{ $subIndex }}]"
                                                                        value="{{ old('days.' . $dayIndex . '.sections.' . $sectionIndex . '.subtitle.' . $subIndex, $subtitle) }}" />
                                                                @endforeach
                                                            @endif
                                                        </div>
                                                        <x-forms.button type="button" class="add-subtitle-btn"
                                                            data-day-id="{{ $dayIndex }}"
                                                            data-section-id="{{ $sectionIndex }}"> Додади потточка
                                                        </x-forms.button>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <x-forms.button type="button" class="add-section-btn"
                                                data-day-id="{{ $dayIndex }}"> Додади секција
                                            </x-forms.button>
                                        </div>
                                    @endforeach
                                </div>

                                <x-forms.button type="button" class="add-day-btn"> Додади ден </x-forms.button>
                                <x-forms.button> Ажурирај агенда </x-forms.button>
                            </x-forms.form>
                        </x-modal>
                    </div>

                    <div class="mt-5 border-b border-gray-300"></div>

                    <div class="flex flex-col items-center">
                        <div class="flex flex-col space-x-2 my-6">
                            <x-page-heading>Слични настани</x-page-heading>

                            @foreach ($relatedEvents as $relatedEvent)
                                <div class="flex flex-col items-center justify-center border-b border-gray-300 my-1">
                                    <div class="flex space-x-3 items-center justify-center lg:justify-start">
                                        <span class="font-bold italic text-sm">Настан: | </span>
                                        <a href="{{ route('events.show', $relatedEvent->id) }}"
                                            class="max-w-[800px] text-accent font-semibold">
                                            {{ $relatedEvent->title }}
                                        </a>
                                    </div>

                                    <div>
                                        <p class="max-w-[800px] text-center lg:text-left">
                                            {{ $relatedEvent->description }}
                                        </p>
                                    </div>
                                </div>
                            @endforeach

                        </div>
                    </div>


                    {{-- Delete Event Button/Form --}}
                    <div class="rounded mt-4 bg-white border border-gray-300 shadow-lg p-4 text-center">
                        <x-forms.form class="space-y-0" method="POST"
                            action="{{ route('events.destroy', $event->id) }}"
                            onsubmit="return confirm('Дали си сигурен дека сакаш да го избришеш овој Настан?');">
                            @method('DELETE')

                            <button class="text-sm font-semibold border-b-2 border-red-600" type="submit">Избриши го
                                настанот</button>
                        </x-forms.form>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script>
        let dayCount = {{ count($event->agenda->days) }};
        let sectionCounts = {};
        let subtitleCounts = {};

        @foreach ($event->agenda->days as $dayIndex => $day)
            sectionCounts[{{ $dayIndex }}] = {{ count($day['sections']) }};
            @foreach ($day['sections'] as $sectionIndex => $section)
                subtitleCounts['{{ $dayIndex }}-{{ $sectionIndex }}'] =
                    {{ isset($section['subtitle']) && is_array($section['subtitle']) ? count($section['subtitle']) : 0 }};
            @endforeach
        @endforeach

        // Add new day with feature to add section
        document.querySelector('.add-day-btn').addEventListener('click', function() {
            const dayDiv = document.createElement('div');
            dayDiv.classList.add('day', 'p-4', 'mb-6');
            dayDiv.id = `day-${dayCount}`;
            dayDiv.innerHTML = `
                <x-forms.input label="Ден (пр. Day ${dayCount + 1})" name="days[${dayCount}][date]" />
                <div id="sections-${dayCount}">
                    <button type="button" class="add-section-btn" data-day-id="${dayCount}">Додади секција</button>
                </div>
            `;
            document.getElementById('agenda-days').appendChild(dayDiv);
            sectionCounts[dayCount] = 0;
            dayCount++;
        });

        //  Add new section
        document.addEventListener('click', function(event) {
            if (event.target && event.target.classList.contains('add-section-btn')) {
                const dayId = event.target.getAttribute('data-day-id');
                const sectionsDiv = document.getElementById(`sections-${dayId}`);
                const sectionDiv = document.createElement('div');
                sectionDiv.classList.add('section', 'mb-3', 'p-4');
                sectionDiv.id = `section-${dayId}-${sectionCounts[dayId]}`;
                sectionDiv.innerHTML = `
                    <x-forms.input label="Час" name="days[${dayId}][sections][${sectionCounts[dayId]}][hour]" />
                    <x-forms.input label="Точка" name="days[${dayId}][sections][${sectionCounts[dayId]}][title]" />
                    <div id="subtitles-${dayId}-${sectionCounts[dayId]}">
                        <x-forms.textarea label="Потточка" name="days[${dayId}][sections][${sectionCounts[dayId]}][subtitle][0]" />
                    </div>
                    <x-forms.button type="button" class="add-subtitle-btn" data-day-id="${dayId}" data-section-id="${sectionCounts[dayId]}"> Додади потточка
                    </x-forms.button>
                `;
                sectionsDiv.appendChild(sectionDiv);
                subtitleCounts[`${dayId}-${sectionCounts[dayId]}`] = 1;
                sectionCounts[dayId]++;
            }
        });

        // Subtitle
        document.addEventListener('click', function(event) {
            if (event.target && event.target.classList.contains('add-subtitle-btn')) {
                const dayId = event.target.getAttribute('data-day-id');
                const sectionId = event.target.getAttribute('data-section-id');
                const subtitlesDiv = document.getElementById(`subtitles-${dayId}-${sectionId}`);
                let subtitleCount = subtitleCounts[`${dayId}-${sectionId}`];
                const textareaDiv = document.createElement('div');
                textareaDiv.innerHTML = `
                    <x-forms.textarea label="Потточка" name="days[${dayId}][sections][${sectionId}][subtitle][${subtitleCount}]" />
                `;
                subtitlesDiv.appendChild(textareaDiv);
                subtitleCounts[`${dayId}-${sectionId}`]++;
            }
        });
    </script>

</x-layout>
