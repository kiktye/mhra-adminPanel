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

                <div class="p-0 overflow-x-auto">
                    <table class="w-full mt-4 text-left table-auto min-w-max">
                        <thead>
                            <tr>
                                <th
                                    class="p-4 transition-colors cursor-default border-y border-slate-200 bg-slate-50 hover:bg-slate-100">
                                </th>
                                <th
                                    class="p-4 transition-colors cursor-default border-y border-slate-200 bg-slate-50 hover:bg-slate-100">
                                    <h1 class="capitalize font-medium text-sm">Говорник</h1>
                                </th>
                                <th
                                    class="p-4 transition-colors cursor-default border-y border-slate-200 bg-slate-50 hover:bg-slate-100">
                                    <h1 class="capitalize font-medium text-sm">Title</h1>
                                </th>
                                <th
                                    class="p-4 transition-colors cursor-default border-y border-slate-200 bg-slate-50 hover:bg-slate-100">
                                    <h1 class="capitalize font-medium text-sm">Специјален гостин</h1>
                                </th>
                                <th
                                    class="p-4 transition-colors cursor-default border-y border-slate-200 bg-slate-50 hover:bg-slate-100">
                                    <h1 class="capitalize font-medium text-sm">Говорник за:</h1>
                                </th>
                                <th
                                    class="p-4 transition-colors cursor-default border-y border-slate-200 bg-slate-50 hover:bg-slate-100">
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($speakers as $speaker)
                                <tr class="border-b">
                                    <td class="p-4 border-b border-slate-200">
                                        <p class="text-sm font-semibold text-slate-700">
                                            <img src="{{ asset('storage/' . $speaker->photo_path) }}"
                                                alt="will upload later"
                                                class="relative inline-block h-12 w-12 rounded-full object-cover object-center" />
                                        </p>
                                    </td>
                                    <td class="p-4 border-b border-slate-200">
                                        <p class="text-sm font-semibold text-slate-700">{{ $speaker->name }}
                                            {{ $speaker->surname }}</p>
                                    </td>
                                    <td class="p-4 border-b border-slate-200">
                                        {{ $speaker->title }}
                                    </td>
                                    <td class="p-4 border-b border-slate-200">
                                        {{ $speaker->is_special_guest ? 'Да' : 'Не' }}
                                    </td>
                                    <td class="p-4 border-b border-slate-200">
                                        @if ($speaker->event == null && $speaker->conference == null)
                                            <x-modal :trigger="$speaker->id" :button="'Запиши за настан'">
                                                <x-forms.form method="POST"
                                                    action="{{ route('speakers.update', $speaker->id) }}">
                                                    @method('PATCH')

                                                    <x-forms.checkbox label="Запиши како Специјален гостин"
                                                        name="is_special_guest" id="is_special_guest" value="1" />

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
                                                        <x-forms.select label="Запиши за конференција"
                                                            name="conference_id">
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
                                                <div class="flex flex-col text-sm">
                                                    <span>{{ $speaker->event->title }} и</span>
                                                    <span>{{ $speaker->conference->title }}
                                                </div>
                                                </span>
                                            @elseif ($speaker->conference)
                                                {{ $speaker->conference->title }}
                                            @elseif ($speaker->event)
                                                {{ $speaker->event->title }}
                                            @endif
                                        @endif
                                    </td>

                                    <td class="p-4 border-b border-slate-200">

                                        <a href="{{ route('speakers.show', $speaker->id) }}"
                                            class="flex items-center text-slate-900 transition-all hover:bg-slate-900/10 rounded-xl text-xs p-2">
                                            <svg viewBox="0 0 20 20" fill="currentColor" class="size-4 mr-1">
                                                <path d=" M10 12.5a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z" />
                                                <path fill-rule="evenodd"
                                                    d="M.664 10.59a1.651 1.651 0 0 1 0-1.186A10.004 10.004 0 0 1 10 3c4.257 0 7.893 2.66 9.336 6.41.147.381.146.804 0 1.186A10.004 10.004 0 0 1 10 17c-4.257 0-7.893-2.66-9.336-6.41ZM14 10a4 4 0 1 1-8 0 4 4 0 0 1 8 0Z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            Говорник
                                        </a>

                                        {{-- <x-forms.form class="space-y-0" method="POST"
                                            action="{{ route('speakers.destroy', $speaker->id) }}"
                                            onsubmit="return confirm('Дали си сигурен дека сакаш да го избришеш овој говорник?');">
                                            @method('DELETE')

                                            <button class="text-xs font-semibold border-b-2 border-red-600"
                                                type="submit">Избриши говорник</button>
                                        </x-forms.form> --}}
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
