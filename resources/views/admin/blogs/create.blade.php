<x-layout>
    <div class="p-4 w-full mx-auto">
        <div class="max-w-[1240px] mx-auto">
            <div
                class="relative flex flex-col w-full h-full text-slate-700 bg-white shadow-md rounded-xl bg-clip-border">

                <div class="relative mx-4 mt-4 overflow-hidden text-slate-700 bg-white rounded-none bg-clip-border">
                    <div class="flex items-center justify-between ">
                        <h3 class="text-lg font-semibold text-slate-800">Креирај блог</h3>

                        <a href="{{ route('blogs.index') }}"
                            class="rounded border border-slate-300 py-2.5 px-3 text-center text-xs font-semibold text-slate-600"
                            type="button">
                            Назад
                        </a>

                    </div>
                </div>

                <div class="p-4 overflow-scroll">
                    <x-forms.form method="POST" action=" {{ route('blogs.store') }} " enctype="multipart/form-data">

                        <div id="blog-sections">

                            <x-forms.input label="Слика на блог" name="photo_path" type="file" />

                            <x-forms.input label="Title на Блог" name="title" id="title"
                                value="{{ old('title') }}" />

                            <x-forms.textarea label="Опис" name="description"
                                value="{{ old('description' ?? '') }}" />

                            <div class="section p-4">
                                <x-forms.input label="Title на секција" name="sections[0][section_title]"
                                    id="section_title_0" value="{{ old('sections[0][section_title]') }}" />

                                <x-forms.textarea label="Содржина на секција" name="sections[0][section_body]"
                                    id="section_body_0" value="{{ old('sections[0][section_body]' ?? '') }}" />
                            </div>
                        </div>
                        {{-- add section button --}}
                        <button type="button"
                            class="rounded-md bg-slate-800 py-1.5 px-2 text-2xs font-semibold text-white shadow-md"
                            id="add-section">Додади секција</button>
                        <x-forms.divider />

                        {{-- feature blog --}}
                        <x-forms.checkbox label="Истакнат блог" name="is_featured" id="is_featured"
                            value="1 {{ old('is_featured') ? 'checked' : '' }}" />

                        <x-forms.button class="mx-auto"> Запиши блог </x-forms.button>

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
        // add section for blog contents
        document.getElementById('add-section').addEventListener('click', function() {
            const sectionsDiv = document.getElementById('blog-sections');
            const sectionCount = sectionsDiv.querySelectorAll('.section').length;

            const newSection = `
                            <div class="section px-4">
                                <x-forms.input label="Title на секција" name="sections[${sectionCount}][section_title]"
                                    id="section_title_${sectionCount}" />

                                <x-forms.textarea label="Содржина на секција" name="sections[${sectionCount}][section_body]"
                                    id="section_body_${sectionCount}" />

                            </div>

            `;

            sectionsDiv.insertAdjacentHTML('beforeend', newSection);
        });
    </script>

</x-layout>
