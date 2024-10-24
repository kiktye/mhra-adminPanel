<x-layout>
    <div class="p-4 w-full mx-auto">
        <div class="max-w-[1240px] mx-auto">
            <div
                class="relative flex flex-col w-full h-full text-slate-700 bg-white shadow-md rounded-xl bg-clip-border">

                <div class="relative mx-4 mt-4 overflow-hidden text-slate-700 bg-white rounded-none bg-clip-border">
                    <div class="flex items-center justify-between ">
                        <h3 class="text-lg font-semibold text-slate-800">Креирај настан</h3>

                        <a href="{{ route('events.index') }}"
                            class="rounded border border-slate-300 py-2.5 px-3 text-center text-xs font-semibold text-slate-600"
                            type="button">
                            Назад
                        </a>

                    </div>
                </div>

                <div class="p-4 overflow-scroll">
                    <x-forms.form method="POST" action=" {{ route('events.store') }} " enctype="multipart/form-data">

                        <div id="blog-sections" class="space-y-4">

                            <x-forms.input label="Слика на настан" name="photo_path" type="file" />

                            <x-forms.input label="Title на настан" name="title" id="title"
                                value="{{ old('title') }}" />

                            <x-forms.textarea label="Тема на настан" name="theme" value="{{ old('theme' ?? '') }}" />

                            <x-forms.textarea label="Опис на настан" name="description"
                                value="{{ old('description' ?? '') }}" />

                            <x-forms.textarea label="Цел на настан" name="objective"
                                value="{{ old('objective' ?? '') }}" />

                            <x-forms.input label="Локација на настан" name="location" value="{{ old('location') }}" />

                            <x-forms.input label="Датум на настан" type="date" name="date"
                                value="{{ old('date') }}" />


                            <div id="ticket-prices-section" class="px-4">
                                <div class="ticket-price mb-3">
                                    <x-forms.input label="Билет за" placeholder="Поединец" name="ticket_prices[0][type]"
                                        id="ticket_prices[0][type]" value="{{ old('ticket_prices[0][type]') }}" />

                                    <x-forms.input label="Цена на билет" placeholder="500" id="ticket_prices[0][price]"
                                        name="ticket_prices[0][price]" value="{{ old('ticket_prices[0][price]') }}" />
                                </div>
                            </div>

                            <button type="button" class="rounded-md bg-slate-800 py-1 px-2 text-2xs font-semibold text-white shadow-md" id="add-ticket-btn">Додади билет</button>

                            <x-forms.select label="Одбери агенда" name="agenda_id" id="agenda_id">
                                <option value="">Одбери агенда</option>
                                @foreach ($agendas as $agenda)
                                    <option value="{{ $agenda->id }}">{{ $agenda->name }}</option>
                                @endforeach
                            </x-forms.select>

                            <x-forms.divider />

                            <x-forms.checkbox label="Истакни евент" name="is_featured" id="is_featured"
                                value="1 {{ old('is_featured') ? 'checked' : '' }}" />

                            <x-forms.button> Запиши настан </x-forms.button>

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
        // Option to add more ticket prices (currently in form displaying only one, but can be extended)
        let ticketCount = 1;

        document.getElementById('add-ticket-btn').addEventListener('click', function() {
            const ticketDiv = document.createElement('div');
            ticketDiv.classList.add('ticket-price', 'mb-3');

            ticketDiv.innerHTML = `

            <div class="ticket-price mb-3">
                <x-forms.input label="Билет за" id="ticket_prices[${ticketCount}][type]" 
                name="ticket_prices[${ticketCount}][type]" />

                <x-forms.input label="Цена на билет" id="ticket_prices[${ticketCount}][price]" 
                name="ticket_prices[${ticketCount}][price]" />
            </div>

            `;

            document.getElementById('ticket-prices-section').appendChild(ticketDiv);
            ticketCount++;
        });
    </script>

</x-layout>
