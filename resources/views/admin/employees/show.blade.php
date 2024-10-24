<x-layout>

    <div class="flex flex-col md:flex-row p-4 space-y-4 md:space-y-0 md:space-x-4 items-start w-screen">
        <!-- Manage Employee Info -->
        <div class="flex-grow rounded bg-white border border-gray-300 shadow-lg w-full md:w-2/3">
            <div class="flex flex-col p-6">

                <span class="text-xl">Управувај со податоци на вработен</span>

                <div class="mt-4">
                    {{-- employee Photo --}}
                    <div class="flex flex-col items-center">
                        <img src="{{ asset('storage/' . $employee->photo_path) }}" alt=""
                            class="w-[550px] h-[350px] object-contain rounded-xl">

                        <div class="flex items-center space-x-4">
                            {{-- If photo is set display Delete button --}}
                            @if ($employee->photo_path)
                                <x-forms.form method="POST"
                                    action="{{ route('employees.delete.image', $employee->id) }}">
                                    @method('DELETE')

                                    <button
                                        class="rounded-md bg-slate-800 py-1.5 px-2 text-2xs font-semibold text-white shadow-md">Избриши
                                        слика
                                    </button>
                                </x-forms.form>
                            @endif

                            {{-- if there is photo pop up with form ( this form also adds new photo) --}}
                            <x-modal :trigger="$employee->id" :button="'Промени слика'">
                                <x-forms.form method="POST"
                                    action="{{ route('employees.update.image', $employee->id) }}"
                                    enctype="multipart/form-data">
                                    @method('PATCH')

                                    <x-forms.input label="Истакната слика на настан" name="photo_path" type="file" />

                                    <x-forms.button type="submit">Зачувај</x-forms.button>
                                </x-forms.form>
                            </x-modal>
                        </div>
                    </div>

                    {{-- manage role --}}
                    <div class="my-10 flex flex-col items-center">
                        {{-- display title and description --}}
                        <div
                            class="flex flex-col md:flex-row items-center justify-center md:justify-around text-center space-y-10 md:space-x-4">
                            <div class="flex flex-col">
                                <span class="text-lg italic font-semibold">Позиција</span>
                                <h1 class="font-bold text-xl">{{ $employee->role->name }}</h1>
                            </div>
                        </div>

                        {{-- pop up form for editing name and surname --}}
                        <x-modal :trigger="$employee->id" :button="'Промени позиција'">
                            <x-forms.form method="POST" action="{{ route('employees.update.role', $employee->id) }}">
                                @method('PATCH')

                                <x-forms.select label="Додели позиција" name="role_id">
                                    <option value="">Позиција</option>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->id }}">{{ $role->name }}
                                        </option>
                                    @endforeach
                                </x-forms.select>

                                <x-forms.button type="submit">Зачувај промени</x-forms.button>
                            </x-forms.form>
                        </x-modal>
                    </div>

                    {{-- manage name surname section --}}
                    <div class="my-10 flex flex-col items-center space-y-5">
                        {{-- display title and description --}}
                        <div
                            class="flex flex-col md:flex-row items-center justify-center md:justify-around text-center space-y-10 md:space-y-0 md:space-x-4">
                            <div class="flex flex-col max-w-[550px] md:mr-[150px]">
                                <span class="text-lg italic font-semibold">Име на вработен</span>
                                <h1 class="font-bold text-xl">{{ $employee->name }}</h1>
                            </div>

                            <div class="flex flex-col max-w-[550px] md:mr-[150px]">
                                <span class="text-lg italic font-semibold">Презиме на вработен</span>
                                <h1 class="font-bold text-xl">{{ $employee->surname }}</h1>
                            </div>
                        </div>

                        {{-- pop up form for editing name and surname --}}
                        <x-modal :trigger="$employee->id" :button="'Измени'">
                            <x-forms.form method="POST" action="{{ route('employees.update.info', $employee->id) }}">
                                @method('PATCH')

                                <x-forms.input label="Име" name="name"
                                    value="{{ old('name', $employee->name) }}" />

                                <x-forms.input label="Презиме" name="surname"
                                    value="{{ old('surname', $employee->surname) }}" />

                                <x-forms.button type="submit">Зачувај промени</x-forms.button>
                            </x-forms.form>
                        </x-modal>
                    </div>

                    <div class="mt-5 border-b border-gray-300"></div>

                    {{-- manage title and description section --}}
                    <div class="my-5 flex flex-col items-center space-y-5">
                        {{-- display title and description --}}
                        <div
                            class="flex flex-col md:flex-row items-center justify-center md:justify-around text-center space-y-10 md:space-x-4">
                            <div class="flex flex-col max-w-[550px] md:mr-[150px]">
                                <span class="text-lg italic font-semibold">Title на вработен</span>
                                <h1 class="font-bold text-xl">{{ $employee->title }}</h1>
                            </div>

                            <div class="flex flex-col max-w-[550px]">
                                <span class="text-lg italic font-semibold">Опис за вработен</span>
                                <h1 class=" font-medium">
                                    @foreach ($descriptions as $description)
                                        <div class="flex flex-col mb-3">
                                            {{ $description }}
                                        </div>
                                    @endforeach
                                </h1>

                            </div>
                        </div>

                        {{-- pop up form for editing title and description --}}
                        <x-modal :trigger="$employee->id" :button="'Измени'">
                            <x-forms.form method="POST"
                                action="{{ route('employees.update.description', $employee->id) }}">
                                @method('PATCH')

                                <x-forms.input label="Title" name="title"
                                    value="{{ old('title', $employee->title) }}" />

                                <div id="description-sections">
                                    @foreach ($descriptions as $index => $description)
                                        <div class="section px-4 my-2">
                                            <x-forms.textarea label="Опис" name="description[{{ $index }}]"
                                                value="{{ old('description.' . $index, $description ?? '') }}" />

                                        </div>
                                    @endforeach
                                </div>

                                <x-forms.button type="button" id="add-section">Додади секција</x-forms.button>
                                <x-forms.button type="submit">Зачувај промени</x-forms.button>

                                <x-forms.divider />

                            </x-forms.form>

                            {{-- Delete section form --}}
                            @foreach ($descriptions as $index => $description)
                                {{-- Delete SECTION, not all sections, separate for each section there is a button --}}
                                <x-forms.form method="POST"
                                    action="{{ route('employees.delete.section', [$employee->id, $index]) }}">
                                    @method('DELETE')
                                    @csrf
                                    <button
                                        class="rounded-md bg-slate-800 py-1.5 px-2 text-2xs font-semibold text-white shadow-md"
                                        type="submit">Избриши секција {{ $index + 1 }}</button>
                                </x-forms.form>
                            @endforeach
                        </x-modal>
                    </div>


                    {{-- Delete Employee Button/Form --}}
                    <div class="rounded mt-4 bg-white border border-gray-300 shadow-lg p-4 text-center">
                        <x-forms.form class="space-y-0" method="POST"
                            action="{{ route('employees.destroy', $employee->id) }}"
                            onsubmit="return confirm('Дали си сигурен дека сакаш да го избришеш овој вработен?');">
                            @method('DELETE')

                            <button class="text-sm font-semibold border-b-2 border-red-600" type="submit">Избриши
                                вработен</button>
                        </x-forms.form>
                    </div>

                </div>
            </div>
        </div>
    </div>


    <script>
        // add section for description
        document.getElementById('add-section').addEventListener('click', function() {
            const sectionsDiv = document.getElementById('description-sections');
            const sectionCount = sectionsDiv.querySelectorAll('.section').length;

            const newSection = document.createElement('div');
            newSection.classList.add('section', 'px-4', 'my-2');

            newSection.innerHTML = `
            <x-forms.textarea label="Опис" name="description[${sectionCount}]" />
    `;

            sectionsDiv.appendChild(newSection);
        });
    </script>
</x-layout>
