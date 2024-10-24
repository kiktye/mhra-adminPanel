<x-layout>
    <div class="p-4 w-full mx-auto">
        <div class="max-w-[1240px] mx-auto">
            <div
                class="relative flex flex-col w-full h-full text-slate-700 bg-white shadow-md rounded-xl bg-clip-border p-5 md:p-0">

                <div class="relative mx-4 mt-4 overflow-hidden text-slate-700 bg-white rounded-none bg-clip-border">
                    <div class="flex flex-wrap items-center justify-between">
                        <h3 class="text-lg font-semibold text-slate-800">Додади нова агенда</h3>

                        <div class="flex flex-col items-center justify-center">
                            <a href=" {{ route('agendas.index') }} ">
                                <div
                                    class="text-sm font-medium  rounded bg-slate-100  border border-gray-300 p-1 shadow-lg">
                                    Види ги агендите во системот
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="p-0 overflow-scroll">
                    <x-forms.form method="POST" action="{{ route('agendas.store') }}">
                        <x-forms.input label="Уникатно име на агенда" name="name" value="{{ old('name') }}"
                            class="w-full" />

                        <x-forms.divider />

                        <div id="agenda-days">
                            <div class="day" id="day-1">
                                <x-forms.input label="Ден (пр. Ден 1 или 24 Jули 2024)" name="days[0][date]"
                                    id="days[0][date]" value="{{ old('days[0][date]') }} Ден 1" class="w-full" />

                                <div id="agenda-sections-0">

                                    {{-- Sections for the first day available --}}
                                    <div class="section p-4">
                                        <div class="flex flex-col gap-4">
                                            <x-forms.input label="Час" id="days[0][sections][0][hour]"
                                                name="days[0][sections][0][hour]"
                                                value="{{ old('days[0][sections][0][hour]') }}" class="w-full" />
                                            <x-forms.input label="Точка" id="days[0][sections][0][title]"
                                                name="days[0][sections][0][title]"
                                                value="{{ old('days[0][sections][0][title]') }}" class="w-full" />
                                        </div>
                                        <div id="subtitles-0-0">
                                            <x-forms.textarea label="Потточка" id="days[0][sections][0][subtitle][0]"
                                                name="days[0][sections][0][subtitle][0]"
                                                value="{{ old('days[0][sections][0][subtitle][0]' ?? '') }}"
                                                class="w-full" />
                                        </div>

                                        {{-- add subtitle button --}}
                                        <button type="button"
                                            class="add-subtitle-btn rounded-md bg-slate-800 py-1 px-2 text-2xs font-semibold text-white shadow-md"
                                            data-day-id="0" data-section-id="0"> Додади потточка</button>
                                    </div>

                                </div>

                                {{-- add section button --}}
                                <button type="button"
                                    class="add-section-btn rounded-md bg-slate-800 py-1.5 px-2 text-2xs font-semibold text-white shadow-md"
                                    data-day-id="0"> Додади
                                    секција </button>

                                <x-forms.divider />
                            </div>
                        </div>
                        {{-- add day, only adds Day 2 and add section button to dynamically add... --}}
                        <button type="button" id="add-day-btn"
                            class="rounded-md bg-slate-800 py-1.5 px-2 text-xs font-semibold text-white shadow-md">
                            Додади ден </button>

                        <x-forms.button class="mx-auto"> Запиши агенда </x-forms.button>
                    </x-forms.form>
                </div>

                <div class="flex items-center justify-between p-3">
                    <p class="block text-sm text-slate-500"></p>
                    <div class="flex gap-1"></div>
                </div>
            </div>

        </div>
    </div>

    <script>
        // Initiate counters
        let dayCount = 1;
        let sectionCounts = {
            0: 1
        };
        let subtitleCounts = {
            0: {
                0: 1
            }
        };

        // Add new day
        document.getElementById('add-day-btn').addEventListener('click', function() {
            const dayDiv = document.createElement('div');
            dayDiv.classList.add('day', 'mb-3', 'p-4');
            dayDiv.id = `day-${dayCount}`;

            dayDiv.innerHTML = `
                <x-forms.input label="Ден (Ден ${dayCount + 1})" value="Ден ${dayCount + 1}" name="days[${dayCount}][date]" id="days[${dayCount}][date]" class="w-full" />
                <div id="agenda-sections-${dayCount}">
                    <div class="section p-4">
                        <div class="flex flex-col gap-4">
                            <x-forms.input label="Час" id="days[${dayCount}][sections][0][hour]" name="days[${dayCount}][sections][0][hour]" class="w-full"/>
                            <x-forms.input label="Точка" id="days[${dayCount}][sections][0][title]" name="days[${dayCount}][sections][0][title]" class="w-full"/>
                        </div>
                        <div id="subtitles-${dayCount}-0">
                            <x-forms.textarea label="Потточка" id="days[${dayCount}][sections][0][subtitle][0]" name="days[${dayCount}][sections][0][subtitle][0]" class="w-full"/>
                        </div>
                        <button type="button" class="add-subtitle-btn rounded-md bg-slate-800 py-1 px-2 text-2xs font-semibold text-white shadow-md" data-day-id="${dayCount}" data-section-id="0">
                            Додади потточка
                        </button>
                    </div>
                </div>
                <button type="button" class="add-section-btn rounded-md bg-slate-800 py-1.5 px-2 text-2xs font-semibold text-white shadow-md" data-day-id="${dayCount}"> Додади секција </button>
                <x-forms.divider />
            `;

            document.getElementById('agenda-days').appendChild(dayDiv);
            sectionCounts[dayCount] = 1;
            subtitleCounts[dayCount] = {
                0: 1
            };
            dayCount++;
        });

        // Add new section for the specific day where the button is
        document.addEventListener('click', function(event) {
            if (event.target && event.target.classList.contains('add-section-btn')) {
                const dayId = event.target.getAttribute('data-day-id');
                const sectionDiv = document.createElement('div');
                sectionDiv.classList.add('section', 'mb-3', 'p-4');
                sectionDiv.id = `section-${dayId}-${sectionCounts[dayId]}`;

                sectionDiv.innerHTML = `
                    <div class="flex flex-col gap-4">
                        <x-forms.input label="Час" id="days[${dayId}][sections][${sectionCounts[dayId]}][hour]" name="days[${dayId}][sections][${sectionCounts[dayId]}][hour]" class="w-full"/>
                        <x-forms.input label="Точка" id="days[${dayId}][sections][${sectionCounts[dayId]}][title]" name="days[${dayId}][sections][${sectionCounts[dayId]}][title]" class="w-full"/>
                    </div>
                    <div id="subtitles-${dayId}-${sectionCounts[dayId]}">
                        <x-forms.textarea label="Потточка" id="days[${dayId}][sections][${sectionCounts[dayId]}][subtitle][0]" name="days[${dayId}][sections][${sectionCounts[dayId]}][subtitle][0]" class="w-full"/>
                    </div>
                    <button type="button" class="add-subtitle-btn rounded-md bg-slate-800 py-1 px-2 text-2xs font-semibold text-white shadow-md" data-day-id="${dayId}" data-section-id="${sectionCounts[dayId]}"> Додади потточка </button>
                `;

                document.getElementById(`agenda-sections-${dayId}`).appendChild(sectionDiv);
                subtitleCounts[dayId][sectionCounts[dayId]] = 1;
                sectionCounts[dayId]++;
            }
        });

        // Add new subtitle for a specific section in a specific day
        document.addEventListener('click', function(event) {
            if (event.target && event.target.classList.contains('add-subtitle-btn')) {
                const dayId = event.target.getAttribute('data-day-id');
                const sectionId = event.target.getAttribute('data-section-id');
                const subtitlesDiv = document.getElementById(`subtitles-${dayId}-${sectionId}`);

                let subtitleCount = subtitleCounts[dayId][sectionId];
                const textareaDiv = document.createElement('div');
                textareaDiv.innerHTML = `
                    <x-forms.textarea label="Потточка" id="days[${dayId}][sections][${sectionId}][subtitle][${subtitleCount}]" name="days[${dayId}][sections][${sectionId}][subtitle][${subtitleCount}]" class="w-full"/>
                `;
                subtitlesDiv.appendChild(textareaDiv);
                subtitleCounts[dayId][sectionId]++;
            }
        });
    </script>
</x-layout>
