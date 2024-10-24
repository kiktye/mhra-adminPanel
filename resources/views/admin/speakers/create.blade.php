<x-layout>
    <div class="p-4 w-full mx-auto">
        <div class="max-w-[1240px] mx-auto">
            <div
                class="relative flex flex-col w-full h-full text-slate-700 bg-white shadow-md rounded-xl bg-clip-border">
                <div class="relative mx-4 mt-4 overflow-hidden text-slate-700 bg-white rounded-none bg-clip-border">
                    <div class="flex flex-wrap items-center justify-between">
                        <h3 class="text-lg font-semibold text-slate-800">Додади говорник</h3>

                        <div class="flex flex-col items-center justify-center">
                            <p class="block text-xs text-slate-500"> Говорникот можеби е веке во системот: </p>
                            <a href=" {{ route('speakers.index') }} ">
                                <div class="text-sm font-medium  rounded bg-slate-100  border border-gray-300 p-1 shadow-lg">
                                    Види ги сите говорници
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="p-4 overflow-scroll">

                    <x-forms.form method="POST" action="{{ route('speakers.store') }}" enctype="multipart/form-data">

                        <x-forms.input label="Име на говорник" name="name" id="name"
                            value="{{ old('name') }}" />
                        <x-forms.input label="Презиме на говорник" name="surname" id="surname"
                            value="{{ old('surname') }}" />
                        <x-forms.input label="Title" name="title" id="title" value="{{ old('title') }}" />

                        <x-forms.input label="Слика на говорник" name="photo_path" type="file" />

                        <!-- Social Media Linkovi -->
                        <div class="mb-3">
                            <div id="social-links-container" class="p-4 space-y-2">
                                <div class="flex space-x-2 justify-center">
                                    <x-forms.input label="Платформа" id="social_links[0][platform]"
                                        name="social_links[0][platform]"
                                        value="{{ old('social_links[0][platform]') }}" />

                                    <x-forms.input label="Линк до профил" id="social_links[0][link]"
                                        name="social_links[0][link]" value="{{ old('social_links[0][link]') }}" />
                                </div>
                            </div>
                            {{-- for multiple social media links to be added, currently displaying only one field --}}
                            <x-forms.button type="button" class="btn btn-secondary" id="add-social-link">Додади
                                поле</x-forms.button>
                        </div>

                        <x-forms.divider />

                        {{-- if checked, only conference will be displayed --}}
                        <x-forms.checkbox label="Специјален гостин" name="is_special_guest" id="is_special_guest"
                            value="1" />


                        <x-forms.divider />

                        {{-- define the speaker to event: --}}
                        <div id="event-select">
                            <x-forms.select label="Запиши за настан" name="event_id">
                                <option value="">Одбери настан</option>
                                {{-- displaying each event name in the dropdown --}}
                                @foreach ($events as $event)
                                    <option value="{{ $event->id }}">{{ $event->title }} ({{ $event->date }})
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
                                    <option value="{{ $conference->id }}">{{ $conference->title }}</option>
                                @endforeach
                            </x-forms.select>
                        </div>

                        <x-forms.divider />

                        <x-forms.button> Додади говорник </x-forms.button>
                    </x-forms.form>
                </div>

                <div class="flex flex-col items-center justify-center p-3 my-10">

                </div>
            </div>
        </div>
    </div>

    <script>
        // if special guest is selected, hide event select and show conference select
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

        // add social media link filed
        document.getElementById('add-social-link').addEventListener('click', function() {
            const container = document.getElementById('social-links-container');
            const index = container.children.length;

            const newInputGroup = document.createElement('div');
            newInputGroup.classList.add('flex', 'space-x-2', 'justify-center');
            newInputGroup.innerHTML = `
                <x-forms.input label="Платформа"  id="social_links[${index}][platform]" 
                name="social_links[${index}][platform]" value="{{ old('social_links[${index}][platform]') }}" />
                <x-forms.input label="Линк до профил" id="social_links[${index}][link]"
                 name="social_links[${index}][link]" value="{{ old('social_links[${index}][link]') }}" />
        `;
            container.appendChild(newInputGroup);
        });
    </script>

</x-layout>
