<x-layout>

    <div class="flex flex-col lg:flex-row p-4 space-y-4 lg:space-y-0 lg:space-x-4 items-start w-screen">
        <!-- Basic Info -->
        <div class="space-y-4 w-full lg:w-auto">
            {{-- User Who Created The Blog Info --}}
            <div class="top-4 rounded bg-white border border-gray-300 shadow-lg">
                <div class="flex flex-col p-6">
                    <div class="flex flex-row justify-between space-x-4 items-center">
                        <div class="text-xl">Информации за корисник</div>
                        <img src="{{ $blog->user->photo_path }}" alt="will upload later"
                            class="relative inline-block h-9 w-9 rounded-full object-cover object-center" />
                    </div>

                    <div class="mt-4 self-start items-start">
                        <h1 class="font-bold italic text-xl">{{ $blog->user->name }} {{ $blog->user->surname }}</h1>
                        <p>{{ $blog->user->email }} | {{ $blog->user->phone }}</p>
                        <p class="text-sm font-semibold text-slate-700">
                            Блогот го креирал на : {{ $blog->created_at->format('M d, Y') }}
                        </p>
                    </div>
                </div>
            </div>

            {{-- Comments Info Section --}}
            <div class="top-4 rounded bg-white border border-gray-300 shadow-lg">
                <div class="flex flex-col p-6 space-y-0.5">
                    <div class="flex flex-col justify-between">
                        <div class="text-xl">Информации за коментари</div>
                        <h2>Овој блог има <span class="font-semibold">{{ $blog->comments->count() }}</span> коментари
                        </h2>
                    </div>

                    @if ($blog->comments->count() > 0)
                        <x-modal :trigger="$blog->id" :button="'Види коментари'">
                            <div class="overflow-y-auto space-y-2">
                                @foreach ($blog->comments->whereNull('parent_id') as $comment)
                                    <div
                                        class="rounded border border-gray-300 shadow-lg {{ $comment->trashed() ? 'bg-gray-100' : 'bg-white' }}">
                                        <div class="flex flex-col p-4">
                                            <div>
                                                <h1 class="font-semibold italic text-xl">Коментар напишан од корисник:
                                                    <a href="{{ route('users.show', $comment->user->id) }}">{{ $comment->user->name }}
                                                        {{ $comment->user->surname }}</a>
                                                </h1>
                                                <p>{{ $comment->content }}</p>
                                            </div>

                                            <div class="mt-2">
                                                @if ($comment->trashed())
                                                    <span class="font-bold">Овој коментар е отстранет.</span>
                                                    <form method="POST"
                                                        action="{{ route('comments.restore', $comment->id) }}">
                                                        @csrf
                                                        <button
                                                            class="rounded-md bg-red-500 py-1.5 px-2 text-2xs font-semibold text-white shadow-md"
                                                            type="submit">Врати коментар</button>
                                                    </form>
                                                @else
                                                    Несоодветен коментар?
                                                    <form method="POST"
                                                        action="{{ route('comments.destroy', $comment->id) }}">
                                                        @method('DELETE')
                                                        @csrf
                                                        <button
                                                            class="rounded-md bg-slate-800 py-1.5 px-2 text-2xs font-semibold text-white shadow-md"
                                                            type="submit">Отстрани коментар</button>
                                                    </form>
                                                @endif
                                            </div>

                                            @if (!$comment->trashed())
                                                <div class="ml-6 mt-4 border-l border-gray-300 pl-4">
                                                    <h2 class="font-semibold">Одговори:</h2>
                                                    @foreach ($comment->replies as $reply)
                                                        <div class="mt-2">
                                                            <h3 class="font-semibold italic">Одговор од
                                                                {{ $reply->user->name }}:</h3>
                                                            <p>{{ $reply->content }}</p>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </x-modal>
                    @endif
                </div>
            </div>

            {{-- Likes Info Section --}}
            <div class="top-4 rounded bg-white border border-gray-300 shadow-lg">
                <div class="flex flex-col p-6">
                    <div class="flex flex-col justify-between space-y-0.5">
                        <div class="text-xl">Информации за лајкови</div>
                        <h2>Овој блог има <span class="font-semibold">{{ $blog->likes->count() }}</span> лајкови</h2>

                        @if ($blog->likes->count() > 0)
                            <x-modal :trigger="$blog->id" :button="'Види лајкови'">
                                <div class="overflow-y-auto space-y-2">
                                    Блогот е лајкнат од:
                                    @foreach ($blog->likes as $like)
                                        <div class="rounded border border-gray-300 shadow-lg">
                                            <div class="flex flex-col p-4">
                                                <h1 class="font-semibold italic text-xl">
                                                    <li>{{ $like->user->name }} {{ $like->user->surname }}</li>
                                                </h1>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </x-modal>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Back to Blogs Button --}}
            <div class="top-4 rounded bg-white border border-gray-300 shadow-lg">
                <div class="flex flex-col justify-between p-4 text-center">
                    <a href="{{ route('blogs.index') }}" class="text-sm font-semibold">Назад кон сите блогови</a>
                </div>
            </div>
        </div>

        <!-- Manage Blog Info Section -->
        <div class="flex-grow w-full lg:w-auto rounded bg-white border border-gray-300 shadow-lg">
            <div class="flex flex-col p-6">
                <span class="text-xl">Управувај со блогот</span>
                <div class="mt-4">
                    {{-- section to show photo + delete/edit buttons --}}
                    <div class="flex flex-col items-center space-y-4">
                        @if ($blog->is_featured == true)
                            Овој блог е Истакнат
                        @else
                            Овој блог не е Истакнат

                            <form method="POST" action="{{ route('blogs.feature', $blog->id) }}">
                                @method('PATCH')
                                @csrf
                                <button
                                    class="rounded-md bg-slate-800 py-0.5 px-2 text-2xs font-semibold text-white shadow-md">Истакни
                                    блог
                                </button>
                            </form>
                        @endif
                        {{-- blog photo --}}
                        <img src="{{ asset('storage/' . $blog->photo_path) }}" alt=""
                            class="w-[550px] h-[350px] object-contain rounded-xl">
                        <div class="flex space-x-2 items-center">
                            {{-- If photo exists show delete button --}}
                            @if ($blog->photo_path)
                                <x-forms.form method="POST" action="{{ route('blogs.delete.image', $blog->id) }}">
                                    @method('DELETE')

                                    <button
                                        class="rounded-md bg-slate-800 py-1.5 px-2 text-2xs font-semibold text-white shadow-md">Избриши
                                        слика
                                    </button>
                                </x-forms.form>
                            @endif

                            {{-- Edit photo pop up with form in it --}}
                            <x-modal :trigger="$blog->id" :button="'Промени слика'">
                                <x-forms.form method="POST" action="{{ route('blogs.update.image', $blog->id) }}"
                                    enctype="multipart/form-data">
                                    @method('PATCH')

                                    <x-forms.input label="Истакната слика на блог" name="photo_path" type="file" />

                                    <x-forms.button type="submit">Зачувај</x-forms.button>
                                </x-forms.form>
                            </x-modal>
                        </div>
                    </div>

                    {{-- section to del/edit title and description --}}
                    <div class="my-2">
                        {{-- blog title --}}
                        <h1 class="font-bold text-xl"> <span class="text-lg italic">Title на блогот |</span>
                            {{ $blog->title }}</h1>

                        {{-- blog description --}}
                        <div class="flex flex-row  space-x-2">
                            <span class="font-bold italic text-sm">Опис на блогот | </span>
                            <p class="max-w-[800px]"> {{ $blog->description }}</p>
                        </div>

                        {{-- edit form modal pop up --}}
                        <x-modal :trigger="$blog->id" :button="'Измени'">
                            <x-forms.form method="POST" action="{{ route('blogs.update.info', $blog->id) }}">
                                @method('PATCH')

                                <x-forms.input label="Title" name="title"
                                    value="{{ old('title', $blog->title) }}" />

                                <x-forms.textarea label="Description" name="description"
                                    value="{{ old('description', $blog->description ?? '') }}" />

                                <x-forms.button type="submit">Зачувај промени</x-forms.button>
                            </x-forms.form>
                        </x-modal>
                    </div>

                    <div class="mt-5 border-b border-gray-300"></div>

                    {{-- sections --}}
                    <div class="my-6">
                        {{-- display each section --}}
                        @foreach ($sections as $index => $section)
                            <div class="mb-4">
                                <h2 class="text-sm font-bold text-gray-600">Секција {{ $index + 1 }}:</h2>
                                <h3 class="text-xl font-semibold"><span class="text-lg italic">Title на секција
                                        |</span>
                                    {{ $section['section_title'] }}</h3>
                                <div class="flex flex-row space-x-2">
                                    <span class="font-bold italic text-sm">Опис на секција | </span>
                                    <p class="text-gray-700 max-w-[800px]">{{ $section['section_body'] }}</p>
                                </div>
                            </div>
                        @endforeach

                        {{-- manage sections form pop up --}}
                        <x-modal :trigger="$blog->id" :button="'Измени секции'">
                            {{-- update sections form --}}
                            <x-forms.form method="POST" action="{{ route('blogs.update.sections', $blog->id) }}">
                                @method('PATCH')

                                {{-- display sections within form inputs --}}
                                <div id="blog-sections">
                                    @foreach ($sections as $index => $section)
                                        <div class="blog-sections">
                                            <div class="section my-2">
                                                <x-forms.input label="Title на секција {{ $index + 1 }}:"
                                                    name="sections[{{ $index }}][section_title]"
                                                    value="{{ $section['section_title'] }}" />

                                                <x-forms.textarea label="Опис на секција:"
                                                    name="sections[{{ $index }}][section_body]"
                                                    value="{{ old('description', $section['section_body'] ?? '') }}" />
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                {{-- button to add new section ( title + body ) in form --}}
                                <x-forms.button class="my-2" id="section-add" type="button">Додади
                                    секција</x-forms.button>

                                <x-forms.button type="submit">Зачувај промени</x-forms.button>
                            </x-forms.form>

                            <x-forms.divider />

                            {{-- Delete section form --}}
                            @foreach ($sections as $index => $section)
                                {{-- Delete SECTION, not all sections, separate for each section there is a button --}}
                                <x-forms.form method="POST"
                                    action="{{ route('blogs.delete.section', [$blog->id, $index]) }}">
                                    @method('DELETE')

                                    <button
                                        class="rounded-md bg-slate-800 py-1.5 px-2 text-2xs font-semibold text-white shadow-md"
                                        type="submit">Избриши секција {{ $index + 1 }}
                                    </button>
                                </x-forms.form>
                            @endforeach
                        </x-modal>
                    </div>

                    {{-- display blog creation date --}}
                    <p class="text-sm font-semibold text-slate-700 flex items-center">
                        Блогот е креиран на : {{ $blog->created_at->format('M d, Y') }}
                    </p>

                    <div class="mt-5 border-b border-gray-300"></div>

                    {{-- related blogs --}}
                    <div class="flex flex-col items-center">
                        <div class="flex flex-col space-x-2 my-6">
                            <x-page-heading>Слични блогови</x-page-heading>

                            @foreach ($relatedBlogs as $relatedBlog)
                                <div class="flex flex-col items-center justify-center border-b border-gray-300 my-1">
                                    <div class="flex space-x-3 items-center justify-center lg:justify-start">
                                        <span class="font-bold italic text-sm">Блог: | </span>
                                        <a href="{{ route('blogs.show', $relatedBlog->id) }}"
                                            class="max-w-[800px] text-accent font-semibold">
                                            {{ $relatedBlog->title }}
                                        </a>
                                    </div>

                                    <div>
                                        <p class="max-w-[800px] text-center lg:text-left">
                                            {{ $relatedBlog->description }}
                                        </p>
                                    </div>
                                </div>
                            @endforeach

                        </div>
                    </div>


                    {{-- button/form to delete entire blog --}}
                    <div class="rounded mt-4 bg-white border border-gray-300 shadow-lg p-4 text-center">
                        <x-forms.form class="space-y-0" method="POST"
                            action="{{ route('blogs.destroy', $blog->id) }}"
                            onsubmit="return confirm('Дали си сигурен дека сакаш да го избришеш овој Блог?');">
                            @method('DELETE')

                            <button class="text-sm font-semibold border-b-2 border-red-600" type="submit">Избриши го
                                блогот</button>
                        </x-forms.form>
                    </div>

                </div>
            </div>
        </div>
    </div>


    <script>
        // add new section within the edit form for sections
        document.getElementById('section-add').addEventListener('click', function() {
            const sectionsDiv = document.getElementById('blog-sections');
            const sectionCount = sectionsDiv.querySelectorAll('.section').length;

            const newSection = `
                <div class="section my-2">
            <x-forms.input label="Title на секција ${sectionCount + 1}:" 
                name="sections[${sectionCount}][section_title]" 
                id="section_title_${sectionCount}" />

            <x-forms.textarea label="Опис на секција:" 
                name="sections[${sectionCount}][section_body]" 
                id="section_body_${sectionCount}" />
        </div>`;

            sectionsDiv.insertAdjacentHTML('beforeend', newSection);
        });
    </script>

</x-layout>
