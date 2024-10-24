<x-layout>
    <div class="p-4 w-full mx-auto">
        <div class="max-w-[1240px] mx-auto">
            <div
                class="relative flex flex-col w-full h-full text-slate-700 bg-white shadow-md rounded-xl bg-clip-border">

                <div class="relative mx-4 mt-4 overflow-hidden text-slate-700 bg-white rounded-none bg-clip-border">
                    <div class="flex items-center justify-between ">
                        <h3 class="text-lg font-semibold text-slate-800">Запиши конференција</h3>

                        <a href="{{ route('conferences.index') }}"
                            class="rounded border border-slate-300 py-2.5 px-3 text-center text-xs font-semibold text-slate-600"
                            type="button">
                            Назад
                        </a>

                    </div>
                </div>

                <div class="p-4 overflow-scroll">
                    <x-forms.form method="POST" action=" {{ route('conferences.store') }} "
                        enctype="multipart/form-data">

                        <x-forms.input label="Слика на конференција" name="photo_path" type="file" />

                        <x-forms.input label="Title на конференција" name="title" id="title"
                            value="{{ old('title') }}" />

                        <x-forms.textarea label="Опис на конференција" name="description"
                            value="{{ old('description' ?? '') }}" />

                        <x-forms.input label="Локација на конференција" name="location" value="{{ old('location') }}" />

                        <div class="flex items-center space-x-4 justify-center">
                            <x-forms.input label="Почеток на конференција" type="date" name="start_date"
                                value="{{ old('start_date') }}" />

                            <x-forms.input label="Крај на конференција" type="date" name="end_date"
                                value="{{ old('end_date') }}" />
                        </div>


                        <div id="ticket-prices-section" class="p-4">
                            <div class="ticket-price mb-3">
                                <x-forms.input label="Билет за" placeholder="Поединци" name="ticket_packages[0][type]"
                                    id="ticket_packages[0][type]" value="{{ old('ticket_packages[0][type]') }}" />

                                <x-forms.input label="Цена на билет" placeholder="1500" id="ticket_packages[0][price]"
                                    name="ticket_packages[0][price]" value="{{ old('ticket_packages[0][price]') }}" />

                                <div id="options-0" class="px-4 mb-3">
                                    <x-forms.input label="Вклучено во билет" placeholder="1 седиште" id="ticket_packages[0][option][0]"
                                        name="ticket_packages[0][option][0]"
                                        value="{{ old('ticket_packages[0][option][0]' ?? '') }}" class="mb-3" />
                                </div>

                                <button type="button" id="add-option-btn" class="add-option-btn rounded-md bg-slate-800 py-1.5 px-2 text-2xs font-semibold text-white shadow-md"
                                    data-section-id="0">Додади опција во пакет</button>
                            </div>
                        </div>

                        <button type="button" class="rounded-md bg-slate-800 py-2 px-2.5 text-2xs font-semibold text-white shadow-md" id="add-section-btn">Додади нов пакет</button>


                        <x-forms.divider />

                        <x-forms.select label="Одбери агенда" name="agenda_id" id="agenda_id" class="mb-5">
                            <option value="">Одбери агенда</option>
                            @foreach ($agendas as $agenda)
                                <option value="{{ $agenda->id }}">{{ $agenda->name }}</option>
                            @endforeach
                        </x-forms.select>


                        <x-forms.button class="mx-auto"> Запиши настан </x-forms.button>

                    </x-forms.form>
                </div>

                <div class="flex items-center justify-between p-3">
                    <p class="block text-sm text-slate-500"> </p>
                    <div class="flex gap-1"> </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        let ticketCount = 1; 
        let optionsCounts = {
            0: 1
        }; 
        // Add new section with ticket prices
        document.getElementById('add-section-btn').addEventListener('click', function() {
            const ticketDiv = document.createElement('div');
            ticketDiv.classList.add('ticket-price', 'mb-3');

            ticketDiv.innerHTML = `
                <div class="ticket-price">
                    <x-forms.input label="Билет за" id="ticket_packages[${ticketCount}][type]" 
                    name="ticket_packages[${ticketCount}][type]" />
    
                    <x-forms.input label="Цена на билет" id="ticket_packages[${ticketCount}][price]" 
                    name="ticket_packages[${ticketCount}][price]" />
                </div> 
                
                <div id="options-${ticketCount}" class="mb-3 p-4">
                    <x-forms.input label="Вклучено во билет" id="ticket_packages[${ticketCount}][option][0]"
                        name="ticket_packages[${ticketCount}][option][0]" />
                </div>
    
                <button type="button" class="add-option-btn rounded-md bg-slate-800 py-2 px-2.5 text-2xs font-semibold text-white shadow-md" data-section-id="${ticketCount}">Додади опција во пакет</.button>
            `;

            document.getElementById('ticket-prices-section').appendChild(ticketDiv);

            optionsCounts[ticketCount] = 1;
            ticketCount++;
        });


        document.addEventListener('click', function(event) {
            if (event.target && event.target.classList.contains('add-option-btn')) {
                const sectionId = event.target.getAttribute('data-section-id');
                const optionsDiv = document.getElementById(`options-${sectionId}`);

                let optionsCount = optionsCounts[sectionId]; 

                const areaDiv = document.createElement('div');
                areaDiv.innerHTML = `
                    <x-forms.input label="Вклучено во билет" id="ticket_packages[${sectionId}][option][${optionsCount}]"
                    name="ticket_packages[${sectionId}][option][${optionsCount}]" class="mb-3"/>
                `;
                optionsDiv.appendChild(areaDiv);

                // ++ count for this section
                optionsCounts[sectionId]++;
            }
        });
    </script>

</x-layout>
