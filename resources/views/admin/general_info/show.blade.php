<x-layout>

    <div class="flex flex-col md:flex-row p-4 space-y-4 md:space-y-0 md:space-x-4 items-start w-screen">

        <!-- Manage Info Section -->
        <div class="flex-grow rounded bg-white border border-gray-300 shadow-lg w-full md:w-2/3">
            <div class="flex flex-col p-6">

                <span class="text-xl">Управувај со податоци од почетна страна</span>

                <div class="mt-4">
                    {{-- homepage photo --}}
                    <div class="flex flex-col items-center">
                        <img src="{{ asset('storage/' . $generalInfo->photo_path) }}" alt=""
                            class="w-[550px] h-[350px] object-contain rounded-xl">

                        <div class="flex items-center space-x-4">
                            {{-- If photo is set display Delete button --}}
                            {{-- @if ($generalInfo->photo_path)
                                <x-forms.form method="POST"
                                    action="{{ route('generalInfo.delete.image', $generalInfo->id) }}">
                                    @method('DELETE')

                                    <button
                                        class="rounded-md bg-slate-800 py-1.5 px-2 text-2xs font-semibold text-white shadow-md">Избриши
                                        слика
                                    </button>
                                </x-forms.form>
                            @endif --}}

                            {{-- if there is photo pop up with form ( this form also adds new photo) --}}
                            <x-modal :trigger="$generalInfo->id" :button="'Промени слика'">
                                <x-forms.form method="POST"
                                    action="{{ route('generalInfo.update.image', $generalInfo->id) }}"
                                    enctype="multipart/form-data">
                                    @method('PATCH')

                                    <x-forms.input label="Истакната слика на настан" name="photo_path" type="file" />

                                    <x-forms.button type="submit">Зачувај</x-forms.button>
                                </x-forms.form>
                            </x-modal>
                        </div>
                    </div>

                    {{-- manage title and subtitle section --}}
                    <div class="my-5 flex flex-col items-center space-y-5">
                        {{-- display title and subtitle --}}
                        <div
                            class="flex flex-col md:flex-row items-center justify-center md:justify-around text-center my-10 md:space-x-4">
                            <div class="flex flex-col max-w-[550px] md:mr-[150px]">
                                <span class="text-lg italic font-semibold">Наслов на почетна страна</span>
                                <h1 class="font-bold text-xl">{{ $generalInfo->title }}</h1>
                            </div>

                            <div class="flex flex-col max-w-[550px] md:mr-[150px]">
                                <span class="text-lg italic font-semibold">Поднаслов на почетна страна</span>
                                <h1 class="font-bold text-xl">{{ $generalInfo->subtitle }}</h1>
                            </div>
                        </div>

                        {{-- pop up form for editing title and description --}}
                        <x-modal :trigger="$generalInfo->id" :button="'Измени'">
                            <x-forms.form method="POST"
                                action="{{ route('generalInfo.update.info', $generalInfo->id) }}">
                                @method('PATCH')

                                <x-forms.input label="Наслов" name="title"
                                    value="{{ old('title', $generalInfo->title) }}" />

                                <x-forms.input label="Поднаслов" name="subtitle"
                                    value="{{ old('subtitle', $generalInfo->subtitle) }}" />

                                <x-forms.button type="submit">Зачувај промени</x-forms.button>
                            </x-forms.form>
                        </x-modal>
                    </div>

                    <div class="mt-5 border-b border-gray-300"></div>

                    {{-- social media links --}}
                    <div class="flex flex-col items-center justify-center my-6">
                        <p class="text-sm font-semibold text-slate-700 flex items-center space-x-4">

                            @foreach ($socialLinks as $link)
                                <a href="{{ $link['link'] }}" target="_blank" class="text-3xl hover:text-accent"> <i
                                        class="fa-brands fa-{{ $link['platform'] }}"></i></a>
                            @endforeach

                        </p>

                        <x-modal :trigger="$generalInfo->id" :button="'Промени линкови'">
                            <x-forms.form method="POST"
                                action="{{ route('generalInfo.update.links', $generalInfo->id) }}"
                                enctype="multipart/form-data">
                                @method('PATCH')

                                @foreach ($socialLinks as $index => $link)
                                    <div class="flex space-x-2">
                                        <x-forms.input label="Платформа"
                                            name="social_links[{{ $index }}][platform]"
                                            value="{{ $link['platform'] }}" />
                                        <x-forms.input label="URL" name="social_links[{{ $index }}][link]"
                                            value="{{ $link['link'] }}" />
                                    </div>
                                @endforeach
                                <x-forms.button type="submit">Зачувај</x-forms.button>
                            </x-forms.form>
                        </x-modal>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-layout>
