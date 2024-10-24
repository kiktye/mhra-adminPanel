<x-layout>

    <div class="flex flex-col lg:flex-row p-4 space-y-4 lg:space-y-0 lg:space-x-4 items-start w-screen">
        <!-- info -->
        <div class="space-y-4 w-full lg:w-auto">
            {{-- Basic Info Section --}}
            <div class="top-4 rounded bg-white border border-gray-300 shadow-lg">
                <div class="flex flex-col p-6">
                    <div class="flex flex-row justify-between space-x-4 items-center">
                        <div class="text-xl">Информации за корисник</div>
                    </div>

                    <div class="mt-4 self-start items-start">
                        <p class="italic">Локација:</p>
                        <h1 class="font-bold italic text-xl">{{ $user->city }}, {{ $user->country }}</h1>
                        <p class="italic">Контакт:</p>
                        <p class="font-medium">{{ $user->email }} | {{ $user->phone }}</p>
                    </div>

                    <div class="mt-2">
                        @if ($user->restricted == true)
                            <span class="font-bold">Корисникот е рестриктиран.</span>
                            <form method="POST" action="{{ route('users.restore', $user->id) }}">
                                @csrf
                                @method('PUT')

                                <button
                                    class="rounded-md bg-red-500 py-1.5 px-2 text-2xs font-semibold text-white shadow-md"
                                    type="submit">Отстрани рестрикции</button>
                            </form>
                        @else
                            Корисникот го прекрши правилникот?
                            <form method="POST" action="{{ route('users.restrict', $user->id) }}">
                                @method('PUT')
                                @csrf
                                <button
                                    class="rounded-md bg-slate-800 py-1.5 px-2 text-2xs font-semibold text-white shadow-md"
                                    type="submit">Рестриктирај акаунт</button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Blogs Info Section --}}
            <div class="top-4 rounded bg-white border border-gray-300 shadow-lg">
                <div class="flex flex-col p-6 space-y-0.5">
                    <div class="flex flex-col justify-between">
                        <div class="text-xl">Информации за блогови</div>
                        <h2>Корисникот има напишано <span class="font-semibold">{{ $user->blogs->count() }}</span>
                            блогови</h2>
                    </div>

                    @if ($user->blogs->count() > 0)
                        <x-modal :trigger="$user->id" :button="'Види блогови'">
                            <div class="overflow-y-auto space-y-2">
                                @foreach ($user->blogs as $blog)
                                    <div class="rounded border border-gray-300 shadow-lg bg-white">
                                        <div class="flex flex-col p-4">
                                            <div>
                                                <h1 class="font-semibold italic text-xl text-accent">
                                                    <a
                                                        href="{{ route('blogs.show', $blog->id) }}">{{ $blog->title }}</a>
                                                </h1>
                                                <p class="text-sm font-semibold text-slate-700 flex items-center">
                                                    Блогот е креиран на: {{ $blog->created_at->format('M d, Y') }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </x-modal>
                    @endif
                </div>
            </div>

            {{-- Comments --}}
            <div class="top-4 rounded bg-white border border-gray-300 shadow-lg">
                <div class="flex flex-col p-6 space-y-0.5">
                    <div class="flex flex-col justify-between">
                        <div class="text-xl">Информации за коментари</div>
                        <h2>Корисникот има напишано <span class="font-semibold">{{ $user->comments->count() }}</span>
                            коментари</h2>
                    </div>

                    @if ($user->comments->count() > 0)
                        <x-modal :trigger="$user->id" :button="'Види коментари'">
                            <div class="overflow-y-auto space-y-2">
                                @foreach ($user->comments as $comment)
                                    <div
                                        class="rounded border border-gray-300 shadow-lg {{ $comment->trashed() ? 'bg-gray-100' : 'bg-white' }}">
                                        <div class="flex flex-col p-4">
                                            <div>
                                                <p>{{ $comment->content }}</p>
                                            </div>

                                            @if ($comment->blog)
                                                <p class="font-semibold italic">На блог: <span class="text-accent">
                                                        <a
                                                            href="{{ route('blogs.show', $comment->blog->id) }}">{{ $comment->blog->title }}</a>
                                                    </span></p>
                                            @else
                                                <p class="font-semibold italic text-red-500">Овој блог повеќе не постои.
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </x-modal>
                    @endif
                </div>
            </div>

            {{-- Back to usrs Button --}}
            <div class="top-4 rounded bg-white border border-gray-300 shadow-lg">
                <div class="flex flex-col justify-between p-4 text-center">
                    <a href="{{ route('users.index') }}" class="text-sm font-semibold">Назад кон сите корисници</a>
                </div>
            </div>
        </div>

        <!-- Manage User Info Section -->
        <div class="flex-grow w-full lg:w-auto rounded bg-white border border-gray-300 shadow-lg">
            <div class="flex flex-col p-4 lg:p-6">
                <span class="text-lg lg:text-xl">Управувај со податоци на корисник</span>
                <div class="mt-4">

                    {{-- section to show photo + delete/edit buttons --}}
                    <div class="flex flex-col items-center">

                        {{-- user photo --}}
                        <img src="{{ asset('storage/' . $user->photo_path) }}" alt=""
                            class="w-[550px] h-[350px] object-contain rounded-xl">
                        <div class="flex space-x-2 items-center">

                            {{-- If photo exists show delete button --}}
                            @if ($user->photo_path)
                                <x-forms.form method="POST" action="{{ route('users.delete.image', $user->id) }}">
                                    @method('DELETE')

                                    <button
                                        class="rounded-md bg-slate-800 py-1.5 px-2 text-2xs font-semibold text-white shadow-md">Избриши
                                        слика
                                    </button>
                                </x-forms.form>
                            @endif

                            {{-- Edit photo pop up with form in it --}}
                            <x-modal :trigger="$user->id" :button="'Промени слика'">
                                <x-forms.form method="POST" action="{{ route('users.update.image', $user->id) }}"
                                    enctype="multipart/form-data">
                                    @method('PATCH')

                                    <x-forms.input label="Слика на корисник" name="photo_path" type="file" />

                                    <x-forms.button type="submit">Зачувај</x-forms.button>
                                </x-forms.form>
                            </x-modal>
                        </div>
                    </div>
                </div>

                <div class="mt-5 border-b border-gray-300"></div>

                {{-- section to manage informations --}}
                <div class="flex flex-col lg:flex-row justify-around items-center my-6 space-y-4 lg:space-y-0">
                    <div class="my-2 text-center lg:text-left">
                        <h1 class="font-bold text-lg lg:text-xl"> <span class="text-sm italic">Име |</span>
                            {{ $user->name }}</h1>

                        <h1 class="font-bold text-lg lg:text-xl"> <span class="text-sm italic">Презиме |</span>
                            {{ $user->surname }}</h1>

                        {{-- edit form modal pop up --}}
                        <x-modal :trigger="$user->id" :button="'Измени'">
                            <x-forms.form method="POST" action="{{ route('users.update.credentials', $user->id) }}">
                                @method('PATCH')

                                <x-forms.input label="Име" name="name" value="{{ old('name', $user->name) }}" />

                                <x-forms.input label="Презиме" name="surname"
                                    value="{{ old('surname', $user->surname) }}" />

                                <x-forms.button type="submit">Зачувај промени</x-forms.button>
                            </x-forms.form>
                        </x-modal>
                    </div>

                    <div class="my-2 text-center lg:text-left">
                        <h1 class="font-bold text-lg lg:text-xl"> <span class="text-sm italic">Email |</span>
                            {{ $user->email }}</h1>

                        <h1 class="font-bold text-lg lg:text-xl"> <span class="text-sm italic">Телефонски број |</span>
                            {{ $user->phone }}</h1>

                        <h1 class="font-bold text-lg lg:text-xl"> <span class="text-sm italic">Title |</span>
                            {{ $user->title }}</h1>

                        {{-- edit form modal pop up --}}
                        <x-modal :trigger="$user->id" :button="'Измени'">
                            <x-forms.form method="POST" action="{{ route('users.update.info', $user->id) }}">
                                @method('PATCH')

                                <x-forms.input label="Email" name="email"
                                    value="{{ old('email', $user->email) }}" />

                                <x-forms.input label="Телефонски број" name="phone"
                                    value="{{ old('phone', $user->phone) }}" />

                                <x-forms.input label="Title" name="title"
                                    value="{{ old('title', $user->title) }}" />

                                <x-forms.button type="submit">Зачувај промени</x-forms.button>
                            </x-forms.form>
                        </x-modal>
                    </div>
                </div>

                <div class="mt-5 border-b border-gray-300"></div>

                <div class="flex flex-col items-center">
                    <div class="flex flex-row space-x-2 my-6">
                        <span class="font-bold italic text-sm">Биографија | </span>
                        <p class="max-w-full lg:max-w-[800px] text-center lg:text-left"> {{ $user->bio }}</p>
                    </div>

                    Несоодветна содржина?

                    <x-modal :trigger="$user->id" :button="'Измени'">
                        <x-forms.form method="POST" action="{{ route('users.update.bio', $user->id) }}">
                            @method('PATCH')

                            <x-forms.textarea label="Биографија" name="bio"
                                value="{{ old('bio', $user->bio) }}" />

                            <x-forms.button type="submit">Зачувај промени</x-forms.button>
                        </x-forms.form>
                    </x-modal>
                </div>

                <div class="flex flex-col items-center">
                    @if ($user->cv_path != null)
                        <div class="flex flex-col items-center mt-10">
                            <a href="{{ asset('storage/' . $user->cv_path) }}" target="_blank"
                                class="text-lg font-bold underline">Види
                                CV</a>
                        </div>

                        Несоодветнo CV?

                        <form method="POST" action="{{ route('users.delete.cv', $user->id) }}">
                            @method('DELETE')
                            @csrf
                            <button
                                class="rounded-md bg-slate-800 py-1.5 px-2 text-2xs font-semibold text-white shadow-md"
                                type="submit">Избриши CV</button>
                        </form>
                    @else
                        <div class="mt-10 text-center lg:text-left">
                            Контактирајте го корисникот за додавање CV
                        </div>
                    @endif
                </div>

                <p
                    class="text-sm font-semibold text-slate-700 flex items-center justify-center lg:justify-start my-10">
                    Корисникот е креиран на : {{ $user->created_at->format('M d, Y') }}
                </p>

                <div class="mt-5 border-b border-gray-300"></div>

                {{-- friends list --}}
                <div class="flex flex-col items-center">
                    <div class="flex flex-col items-center my-6">
                        <x-page-heading>Листа на пријатели</x-page-heading>

                        @foreach ($user->connections as $connection)
                            <div class="flex space-x-3 items-center justify-center lg:justify-start">
                                <span class="font-bold italic text-sm">Friend | </span>
                                <a href="{{ route('users.show', $connection->id) }}"
                                    class="max-w-[800px] text-accent font-semibold">
                                    {{ $connection->name }} {{ $connection->surname }}
                                </a>
                            </div>
                        @endforeach

                    </div>
                </div>

                {{-- received recommendations --}}
                <div class="flex flex-col items-center">
                    <div class="flex flex-col space-x-2 my-6">
                        <x-page-heading>Добиени препораки</x-page-heading>

                        @foreach ($user->receivedRecommendations as $recommendation)
                            <div class="flex flex-col items-center justify-center">
                                <div class="flex space-x-3 items-center justify-center lg:justify-start">
                                    <span class="font-bold italic text-sm">Препорака од: | </span>
                                    <a href="{{ route('users.show', $recommendation->sender->id) }}"
                                        class="max-w-[800px] text-accent font-semibold">
                                        {{ $recommendation->sender->name }} {{ $recommendation->sender->surname }}
                                    </a>
                                </div>

                                <div>
                                    <p class="max-w-[800px] text-center lg:text-left"> {{ $recommendation->content }}
                                    </p>
                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>

                {{-- given recommendations --}}
                <div class="flex flex-col items-center">
                    <div class="flex flex-col space-x-2 my-6">
                        <x-page-heading>Дадени препораки</x-page-heading>

                        @foreach ($user->sentRecommendations as $recommendation)
                            <div class="flex flex-col items-center justify-center border-b border-gray-300 my-1">
                                <div class="flex space-x-3 items-center justify-center lg:justify-start">
                                    <span class="font-bold italic text-sm">Препорака на: | </span>
                                    <a href="{{ route('users.show', $recommendation->receiver->id) }}"
                                        class="max-w-[800px] text-accent font-semibold">
                                        {{ $recommendation->receiver->name }} {{ $recommendation->receiver->surname }}
                                    </a>
                                </div>

                                <div>
                                    <p class="max-w-[800px] text-center lg:text-left"> {{ $recommendation->content }}
                                    </p>
                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>

                {{-- button/form to delete entire user --}}
                <div class="rounded mt-4 bg-white border border-gray-300 shadow-lg p-4 text-center">
                    <x-forms.form class="space-y-0" method="POST" action="{{ route('users.destroy', $user->id) }}"
                        onsubmit="return confirm('Дали си сигурен дека сакаш да го избришеш овој Корисник?');">
                        @method('DELETE')

                        <button class="text-sm font-semibold border-b-2 border-red-600" type="submit">Избриши
                            корисник</button>
                    </x-forms.form>
                </div>

            </div>
        </div>
    </div>



    </div>

</x-layout>
