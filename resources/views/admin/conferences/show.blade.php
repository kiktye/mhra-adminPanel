<x-layout>

    <div class="flex flex-col md:flex-row p-4 space-y-4 md:space-y-0 md:space-x-4 items-start w-screen">
        {{-- Section to edit basic info --}}
        <div class="flex flex-col space-y-4 w-full lg:w-auto">
            {{-- Conference Location and Date Info --}}
            <div class="top-4 rounded bg-white border border-gray-300 shadow-lg">
                <div class="flex flex-col p-6 space-y-1.5">
                    <div class="text-xl">Информации за настан</div>

                    {{-- Display Location and Date Information --}}
                    <div class="mt-4 self-start items-start">
                        <h1 class="font-bold italic text-md"> {{ $conference->location }} </h1>
                        <p class="text-sm font-semibold text-slate-700 flex flex-col">
                            Конференцијата се оддржува на:
                            <span>{{ \Carbon\Carbon::parse($conference->start_date)->format('d') }} -
                                {{ \Carbon\Carbon::parse($conference->end_date)->format('d M Y') }}</span>
                        </p>
                    </div>

                    {{-- Location and Date edit form pop up --}}
                    <x-modal :trigger="$conference->id" :button="'Измени информации'">
                        <div class="overflow-y-auto space-y-2">
                            <x-forms.form method="POST"
                                action="{{ route('conferences.update.info', $conference->id) }}">
                                @method('PATCH')

                                <x-forms.input label="Локација на настан" name="location"
                                    value="{{ old('location', $conference->location) }}" />

                                <x-forms.input type="date" label="Почеток на настан" name="start_date"
                                    value="{{ old('date', $conference->start_date) }}" />

                                <x-forms.input type="date" label="Крај на настан" name="end_date"
                                    value="{{ old('date', $conference->end_date) }}" />

                                <x-forms.button type="submit">Зачувај промени</x-forms.button>
                            </x-forms.form>

                        </div>
                    </x-modal>
                </div>
            </div>

            {{-- Conference Speaker infos --}}
            <div class="rounded bg-white border border-gray-300 shadow-lg">
                <div class="flex flex-col p-6 space-y-1.5">
                    <div class="flex flex-col justify-between ">
                        <div class="text-xl">Говорници на настан</div>
                        <h2>Овој настан има <span class="font-semibold">
                                {{ $conference->speakers->where('is_special_guest', 0)->count() }} </span>
                            говорници
                        </h2>
                    </div>

                    {{-- display Speakr info pop up --}}
                    <x-modal :trigger="$conference->id" :button="'Види говорници'">
                        <div class="overflow-y-auto space-y-2">
                            @foreach ($conference->speakers->where('is_special_guest', 0) as $speaker)
                                <div class="top-4 rounded bg-white border border-gray-300 shadow-lg">
                                    <div class="flex flex-col p-6">
                                        <div class="flex flex-row justify-between space-x-4 items-center">
                                            <div class="text-xl">Информации за говорник</div>
                                            <img src="{{ asset('storage/' . $speaker->photo_path) }}" alt="will upload later"
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
                                                    <a href="{{ $link['link'] }}"
                                                        target="_blank">{{ $link['platform'] }}</a>
                                                @endforeach
                                            </p>
                                        </div>

                                        <x-forms.form class="space-y-0" method="POST"
                                            action="{{ route('speakers.remove.from.conference', $speaker->id) }}">
                                            @method('PATCH')

                                            <button class="text-xs font-semibold border-b-2 border-red-600"
                                                type="submit">Отстрани говорник од настан</button>
                                        </x-forms.form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </x-modal>
                </div>
            </div>

            {{-- Conference Special Guest Info --}}
            <div class="rounded bg-white border border-gray-300 shadow-lg">
                <div class="flex flex-col p-6 space-y-1.5">
                    <div class="flex flex-col justify-between ">
                        <div class="text-xl">Специјални гости</div>
                        <h2>Овој настан има <span class="font-semibold">
                                {{ $conference->speakers->where('is_special_guest', true)->count() }} </span>
                            специјални гости
                        </h2>
                    </div>

                    {{-- display Speakr info pop up --}}
                    <x-modal :trigger="$conference->id" :button="'Види говорници'">
                        <div class="overflow-y-auto space-y-2">
                            @foreach ($conference->speakers->where('is_special_guest', true) as $speaker)
                                <div class="top-4 rounded bg-white border border-gray-300 shadow-lg">
                                    <div class="flex flex-col p-6">
                                        <div class="flex flex-row justify-between space-x-4 items-center">
                                            <div class="text-xl">Информации за специјален гостин</div>
                                            <img src="{{ asset('storage/' . $speaker->photo_path) }}" alt="will upload later"
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
                                                    <a href="{{ $link['link'] }}"
                                                        target="_blank">{{ $link['platform'] }}</a>
                                                @endforeach
                                            </p>
                                        </div>

                                        <x-forms.form class="space-y-0" method="POST"
                                            action="{{ route('speakers.remove.from.conference', $speaker->id) }}">
                                            @method('PATCH')

                                            <button class="text-xs font-semibold border-b-2 border-red-600"
                                                type="submit">Отстрани говорник од настан</button>
                                        </x-forms.form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </x-modal>
                </div>
            </div>

            {{-- Conference ticket packages  info --}}
            <div class="rounded bg-white border border-gray-300 shadow-lg">
                <div class="flex flex-col p-6">
                    <div class="flex flex-col justify-between space-y-1.5">
                        <div class="text-xl">Цена на карти</div>

                        <div class="flex flex-col md:flex-row items-center justify-around space-y-10 md:space-x-10">
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
                        {{-- edit pricing form pop up --}}
                        <x-modal :trigger="$conference->id" :button="'Промени цени'">
                            <x-forms.form method="POST"
                                action="{{ route('conferences.update.prices', $conference->id) }}">
                                @method('PATCH')

                                {{-- Ticket prices section --}}
                                <div id="ticket-prices-section" class="p-4">
                                    @foreach ($tickets as $index => $ticket)
                                        <div class="ticket-price mb-3">
                                            <x-forms.input label="Ticket For"
                                                name="ticket_packages[{{ $index }}][type]"
                                                id="ticket_packages[{{ $index }}][type]"
                                                value="{{ old('ticket_packages[' . $index . '][type]', $ticket['type']) }}" />

                                            <x-forms.input label="Ticket Price"
                                                id="ticket_packages[{{ $index }}][price]"
                                                name="ticket_packages[{{ $index }}][price]"
                                                value="{{ old('ticket_packages[' . $index . '][price]', $ticket['price']) }}" />

                                            <div id="options-{{ $index }}" class="px-4 mb-3">
                                                @foreach ($ticket['option'] as $optionIndex => $option)
                                                    <x-forms.input label="Package Option"
                                                        id="ticket_packages[{{ $index }}][option][{{ $optionIndex }}]"
                                                        name="ticket_packages[{{ $index }}][option][{{ $optionIndex }}]"
                                                        value="{{ old('ticket_packages[' . $index . '][option][' . $optionIndex . ']', $option) }}"
                                                        class="mb-3" />
                                                @endforeach
                                            </div>

                                            <x-forms.button type="button" class="add-package-option-btn"
                                                data-section-id="{{ $index }}">Додади опција во
                                                пакет</x-forms.button>
                                        </div>
                                    @endforeach
                                </div>

                                {{-- Add new ticket section button --}}
                                <x-forms.button type="button" class="btn btn-secondary"
                                    id="add-package-section-btn">
                                    Додади нов пакет
                                </x-forms.button>

                                <x-forms.button type="submit">Зачувај промени</x-forms.button>

                            </x-forms.form>
                        </x-modal>


                    </div>
                </div>
            </div>

            {{-- Back to conferences button --}}
            <div class="rounded bg-white border border-gray-300 shadow-lg">
                <div class="flex flex-col justify-between p-4 text-center">
                    <a href="{{ route('conferences.index') }}" class="text-sm font-semibold">Назад кон сите
                        настани</a>
                </div>
            </div>
        </div>

        <!-- Conference Info -->
        <div class="flex-grow rounded bg-white border border-gray-300 shadow-lg w-full md:w-2/3">
            <div class="flex flex-col p-6">

                <span class="text-xl">Управувај со настанот</span>

                <div class="mt-4">
                    {{-- conference Photo --}}
                    <div class="flex flex-col items-center">
                        <img src="{{ asset('storage/' . $conference->photo_path) }}" alt=""
                            class="w-[550px] h-[350px] object-contain rounded-xl">

                        <div class="flex items-center space-x-4">
                            {{-- If photo is set display Delete button --}}
                            @if ($conference->photo_path)
                                <x-forms.form method="POST"
                                    action="{{ route('conferences.delete.image', $conference->id) }}">
                                    @method('DELETE')

                                    <button
                                        class="rounded-md bg-slate-800 py-1.5 px-2 text-2xs font-semibold text-white shadow-md">Избриши
                                        слика
                                    </button>
                                </x-forms.form>
                            @endif

                            {{-- if there is photo pop up with form ( this form also adds new photo) --}}
                            <x-modal :trigger="$conference->id" :button="'Промени слика'">
                                <x-forms.form method="POST"
                                    action="{{ route('conferences.update.image', $conference->id) }}"
                                    enctype="multipart/form-data">
                                    @method('PATCH')

                                    <x-forms.input label="Истакната слика на настан" name="photo_path"
                                        type="file" />

                                    <x-forms.button type="submit">Зачувај</x-forms.button>
                                </x-forms.form>
                            </x-modal>
                        </div>
                    </div>

                    {{-- manage title and description section --}}
                    <div class="my-5 flex flex-col items-center space-y-5">
                        {{-- display title and description --}}
                        <div
                            class="flex flex-col md:flex-row items-center justify-center md:justify-around text-center space-y-10 md:space-x-4">
                            <div class="flex flex-col max-w-[550px] md:mr-[150px]">
                                <span class="text-lg italic font-semibold">Title на настан</span>
                                <h1 class="font-bold text-xl">{{ $conference->title }}</h1>
                            </div>

                            <div class="flex flex-col max-w-[550px]">
                                <span class="text-lg italic font-semibold">Опис на настан</span>
                                <h1 class=" font-medium"> {{ $conference->description }}</h1>
                            </div>
                        </div>

                        {{-- pop up form for editing title and description --}}
                        <x-modal :trigger="$conference->id" :button="'Измени'">
                            <x-forms.form method="POST"
                                action="{{ route('conferences.update.mainInfo', $conference->id) }}">
                                @method('PATCH')

                                <x-forms.input label="Title" name="title"
                                    value="{{ old('title', $conference->title) }}" />

                                <x-forms.textarea label="Опис на настанот" name="description"
                                    value="{{ old('description', $conference->description ?? '') }}" />

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
                        <x-modal :trigger="$conference->id" :button="'Измени Агенда'">
                            <x-forms.form method="POST"
                                action="{{ route('agendas.update', $conference->agenda->id) }}">
                                @method('PATCH')
                                <x-forms.input label="Име на агенда" name="name"
                                    value="{{ old('name', $conference->agenda->name) }}" />

                                <div id="agenda-days">
                                    {{-- Display each day in the form --}}
                                    @foreach ($conference->agenda->days as $dayIndex => $day)
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

                    {{-- Change conference status --}}
                    <x-forms.form method="POST" action=" {{ route('conferences.update.status', $conference->id) }}">
                        @method('PATCH')

                        <x-forms.select label="Промени статус на конференција" name="status">
                            <option value="active" {{ $conference->status === 'active' ? 'selected' : '' }}>Активна
                                конференција
                            </option>
                            <option value="inactive" {{ $conference->status === 'inactive' ? 'selected' : '' }}>
                                Неактивна конференција
                            </option>
                            <option value="canceled" {{ $conference->status === 'canceled' ? 'selected' : '' }}>
                                Откажана конференција
                            </option>

                        </x-forms.select>

                        <x-forms.button> Промени статус </x-forms.button>

                    </x-forms.form>

                    {{-- Delete Conference Button/Form --}}
                    <div class="rounded mt-4 bg-white border border-gray-300 shadow-lg p-4 text-center">
                        <x-forms.form class="space-y-0" method="POST"
                            action="{{ route('conferences.destroy', $conference->id) }}"
                            onsubmit="return confirm('Дали си сигурен дека сакаш да ја избришеш оваа Конференција?');">
                            @method('DELETE')

                            <button class="text-sm font-semibold border-b-2 border-red-600" type="submit">Избриши
                                конференција</button>
                        </x-forms.form>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script>
        let dayCount = {{ count($conference->agenda->days) }};
        let sectionCounts = {};
        let subtitleCounts = {};

        // Count the available sections and subtitles
        @foreach ($conference->agenda->days as $dayIndex => $day)
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

        // Add a new section
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


    <script>
        let ticketCount = {{ count($tickets) }}; 
        let optionsCounts = {};

        // option count for existing tickets
        @foreach ($tickets as $index => $ticket)
            optionsCounts[{{ $index }}] = {{ count($ticket['option']) }};
        @endforeach

        // Add new section with ticket prices
        document.getElementById('add-package-section-btn').addEventListener('click', function() {
            const ticketDiv = document.createElement('div');
            ticketDiv.classList.add('ticket-price', 'mb-3');

            ticketDiv.innerHTML = `
        <div class="ticket-price mb-3">
            <x-forms.input label="Ticket For" id="ticket_packages[${ticketCount}][type]" 
            name="ticket_packages[${ticketCount}][type]" />

            <x-forms.input label="Ticket Price" id="ticket_packages[${ticketCount}][price]" 
            name="ticket_packages[${ticketCount}][price]" />
        </div> 
        
        <div id="options-${ticketCount}" class="mb-3 p-4">
            <x-forms.input label="Package Option" id="ticket_packages[${ticketCount}][option][0]"
                                name="ticket_packages[${ticketCount}][option][0]" />
        </div>

        <x-forms.button type="button" class="add-package-option-btn" data-section-id="${ticketCount}">Додади опција во пакет</x-forms.button>
   
        `;
            document.getElementById('ticket-prices-section').appendChild(ticketDiv);

            // Increment count for this section
            optionsCounts[ticketCount] = 1;
            ticketCount++;
        });


        document.addEventListener('click', function(event) {
            if (event.target && event.target.classList.contains('add-package-option-btn')) {
                const sectionId = event.target.getAttribute('data-section-id');
                const optionsDiv = document.getElementById(`options-${sectionId}`);

                let optionsCount = optionsCounts[sectionId];

                const areaDiv = document.createElement('div');
                areaDiv.innerHTML = `
            <x-forms.input label="Package Option" id="ticket_packages[${sectionId}][option][${optionsCount}]"
            name="ticket_packages[${sectionId}][option][${optionsCount}]" class="mb-3"/>
        `;
                optionsDiv.appendChild(areaDiv);

                // Increment count for this section
                optionsCounts[sectionId]++;
            }
        });
    </script>

</x-layout>
