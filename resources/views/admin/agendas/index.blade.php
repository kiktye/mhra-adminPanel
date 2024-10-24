<x-layout>
    <div class="p-4 w-full mx-auto">
        <div class="max-w-[1240px] mx-auto">
            <div
                class="relative flex flex-col w-full h-full text-slate-700 bg-white shadow-md rounded-xl bg-clip-border">
                <div class="relative mx-4 mt-4 overflow-hidden text-slate-700 bg-white rounded-none bg-clip-border">
                    <div class="flex flex-wrap items-center justify-between">
                        <h3 class="text-lg font-semibold text-slate-800">Говорници во системот</h3>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full mt-4 text-left table-auto min-w-max">
                        <thead>
                            <tr>
                                <th
                                    class="p-4 transition-colors cursor-default border-y border-slate-200 bg-slate-50 hover:bg-slate-100">
                                    <h1 class="capitalize font-medium text-sm">Име на агенда</h1>
                                </th>
                                <th
                                    class="p-4 transition-colors cursor-default border-y border-slate-200 bg-slate-50 hover:bg-slate-100">
                                    <h1 class="capitalize font-medium text-sm">Креирана на</h1>
                                </th>
                                <th
                                    class="p-4 transition-colors cursor-default border-y border-slate-200 bg-slate-50 hover:bg-slate-100">
                                    <h1 class="capitalize font-medium text-sm">Види агенда</h1>
                                </th>

                                <th
                                    class="p-4 transition-colors cursor-default border-y border-slate-200 bg-slate-50 hover:bg-slate-100">
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($agendas as $agenda)
                                <tr class="border-b">

                                    <td class="p-4 border-b border-slate-200">
                                        <p class="text-sm font-semibold text-slate-700">{{ $agenda->name }}</p>
                                    </td>
                                    <td class="p-4 border-b border-slate-200">
                                        {{ $agenda->created_at->format('d.m.Y') }}
                                    </td>
                                    <td class="p-4 border-b border-slate-200">
                                        <x-modal :trigger="$agenda->id" :button="'Види агенда'">
                                            @foreach ($agenda->days as $day)
                                                <div class="mb-6">
                                                    <h2 class="text-2xl font-bold">{{ $day['date'] }}</h2>
                                                    {{-- Loop through sections within the day --}}
                                                    @foreach ($day['sections'] as $section)
                                                        <div class="flex items-center space-x-4">
                                                            <h3 class="text-xl font-semibold">{{ $section['hour'] }}
                                                            </h3>
                                                            <div class="flex flex-col">
                                                                <p class="font-semibold text-md max-w-[800px]">
                                                                    {{ $section['title'] }}</p>

                                                                {{-- check if subtitles exist --}}
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

                                            <x-modal :trigger="$agenda->id" :button="'Измени Агенда'">
                                                <x-forms.form method="POST"
                                                    action="{{ route('agendas.update', $agenda->id) }}">
                                                    @method('PATCH')
                                                    <x-forms.input label="Име на агенда" name="name"
                                                        value="{{ old('name', $agenda->name) }}" />

                                                    <div id="agenda-days">
                                                        {{-- Display each day in the form --}}
                                                        @foreach ($agenda->days as $dayIndex => $day)
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
                                                                            <div
                                                                                id="subtitles-{{ $dayIndex }}-{{ $sectionIndex }}">
                                                                                {{-- Check for subtitles within each section --}}
                                                                                @if (isset($section['subtitle']) && is_array($section['subtitle']))
                                                                                    @foreach ($section['subtitle'] as $subIndex => $subtitle)
                                                                                        <x-forms.textarea
                                                                                            label="Потточка"
                                                                                            name="days[{{ $dayIndex }}][sections][{{ $sectionIndex }}][subtitle][{{ $subIndex }}]"
                                                                                            value="{{ old('days.' . $dayIndex . '.sections.' . $sectionIndex . '.subtitle.' . $subIndex, $subtitle) }}" />
                                                                                    @endforeach
                                                                                @endif
                                                                            </div>
                                                                            <x-forms.button type="button"
                                                                                class="add-subtitle-btn"
                                                                                data-day-id="{{ $dayIndex }}"
                                                                                data-section-id="{{ $sectionIndex }}">
                                                                                Додади потточка
                                                                            </x-forms.button>
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                                {{-- add section --}}
                                                                <x-forms.button type="button" class="add-section-btn"
                                                                    data-day-id="{{ $dayIndex }}"> Додади секција
                                                                </x-forms.button>
                                                            </div>
                                                        @endforeach
                                                    </div>

                                                    {{-- add day button --}}
                                                    <x-forms.button type="button" class="add-day-btn"> Додади ден
                                                    </x-forms.button>
                                                    <x-forms.button> Ажурирај агенда </x-forms.button>
                                                </x-forms.form>
                                            </x-modal>
                                        </x-modal>
                                    </td>

                                    {{-- delete agenda button --}}
                                    <td class="p-4 border-b border-slate-200">
                                        <x-forms.form class="space-y-0" method="POST"
                                            action="{{ route('agendas.destroy', $agenda->id) }}"
                                            onsubmit="return confirm('Дали си сигурен дека сакаш да ja избришеш оваа агенда?');">
                                            @method('DELETE')

                                            <button class="text-xs font-semibold border-b-2 border-red-600"
                                                type="submit">Избриши агенда</button>
                                        </x-forms.form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="flex flex-col sm:flex-row items-center justify-between p-3">
                    <p class="block text-sm text-slate-500">
                    </p>
                    <div class="flex gap-1 mt-2 sm:mt-0">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        let dayCount = {{ count($agenda->days) }};
        let sectionCounts = {};
        let subtitleCounts = {};

        // Count the available sections and subtitles
        @foreach ($agenda->days as $dayIndex => $day)
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
                    <x-forms.button type="button" class="add-section-btn" data-day-id="${dayCount}"> Додади секција
                    </x-forms.button>
                </div>
            `;
            document.getElementById('agenda-days').appendChild(dayDiv);
            sectionCounts[dayCount] = 0;
            dayCount++;
        });

        // Add a new section button
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
