<x-layout>
    <div class="p-4 w-full mx-auto">
        <div class="max-w-[1240px] mx-auto">
            <div
                class="relative flex flex-col w-full h-full text-slate-700 bg-white shadow-md rounded-xl bg-clip-border">

                <div class="relative mx-4 mt-4 overflow-hidden text-slate-700 bg-white rounded-none bg-clip-border">
                    <div class="flex items-center justify-between ">
                        <h3 class="text-lg font-semibold text-slate-800">Запиши вработен</h3>

                        <a href="{{ route('employees.index') }}"
                            class="rounded border border-slate-300 py-2.5 px-3 text-center text-xs font-semibold text-slate-600"
                            type="button">
                            Назад
                        </a>
                    </div>
                </div>

                <div class="p-4 overflow-scroll">
                    <x-forms.form method="POST" action=" {{ route('employees.store') }} "
                        enctype="multipart/form-data">


                        <x-forms.input label="Слика од вработен" name="photo_path" type="file" />

                        <x-forms.input label="Име" name="name" />

                        <x-forms.input label="Презиме" name="surname" />

                        <x-forms.input label="Title" name="title" />

                        <div id="description-sections">

                            <div class="section px-4">
                                <x-forms.textarea label="Опис" name="description[0]" />
                            </div>

                        </div>
                        <button type="button" class="rounded-md bg-slate-800 py-1.5 px-2 text-2xs font-semibold text-white shadow-md" id="add-section">Додади секција</button>


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
                            <button type="button" class="rounded-md bg-slate-800 py-1.5 px-2 text-2xs font-semibold text-white shadow-md" id="add-social-link">Додади линк</button>
                        </div>


                        <x-forms.divider />

                        <x-forms.select label="Додели позиција" name="role_id" class="mb-5">
                            <option value="">Позиција</option>
                            @foreach ($roles as $role)
                                <option value="{{ $role->id }}">{{ $role->name }}
                                </option>
                            @endforeach
                        </x-forms.select>

                        <x-forms.button class="mx-auto"> Запиши вработен </x-forms.button>

                    </x-forms.form>

                    <x-forms.divider />


                    <div class="flex flex-col items-center justify-center">
                        <p class="block text-xs text-slate-500"> Позицијата не е во системот? </p>
                        <a href=" {{ route('roles.create') }} ">
                            <div
                                class="text-sm font-medium  rounded bg-slate-100  border border-gray-300 p-1 shadow-lg">
                                Додади нова позиција
                            </div>
                        </a>
                    </div>
                </div>

                <div class="flex items-center justify-between p-3">
                    <p class="block text-sm text-slate-500"> </p>
                    <div class="flex gap-1"> </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('add-social-link').addEventListener('click', function() {
            const container = document.getElementById('social-links-container');
            const index = container.children.length; // get number of current social links

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

        document.getElementById('add-section').addEventListener('click', function() {
            const sectionsDiv = document.getElementById('description-sections');
            const sectionCount = sectionsDiv.querySelectorAll('.section').length;


            const newSection = document.createElement('div');
            newSection.classList.add('section', 'px-4');

            newSection.innerHTML = `
            <x-forms.textarea label="Опис" name="description[]" id="description[${sectionCount}]" />
        `;

            document.getElementById('description-sections').appendChild(newSection);
        });
    </script>


</x-layout>
