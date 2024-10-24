<x-layout>

    <div class="space-y-4 flex flex-col items-center p-10">
        <div class="space-y-4">

            @foreach ($blogs as $blog)
                @if ($blog->is_featured == 1)
                    <div class="top-4 rounded bg-white border border-gray-300 shadow-lg w-1/2">
                        <div class="flex flex-col pt-6 pb-1 px-6">
                            <div class="flex flex-row justify-between space-x-4 items-center">
                                <div class="text-xl">Истакнат блог</div>
                            </div>

                            <div class="mt-4 items-center">
                                <h1 class="font-bold italic text-xl">{{ $blog->title }}
                                </h1>
                                <p class="text-sm font-semibold text-slate-700">
                                    <span class="text-accent">Од: {{ $blog->user->name }} {{ $blog->user->surname }}
                                    </span>
                                    | {{ $blog->created_at->format('M d, Y') }}
                                </p>

                            </div>
                            <a class="self-end mt-4 bg-accent p-2 text-white rounded-xl text-xs"
                                href="{{ route('blogs.userShow', $blog->id) }}">Прочитај
                                повеќе</a>
                        </div>
                    </div>


        </div>

        <div class="flex space-x-4">
        @else
            <div class="top-4 rounded bg-white border border-gray-300 shadow-lg w-1/2">
                <div class="flex flex-col pt-6 pb-1 px-6">
                    <div class="mt-4 items-center">
                        <h1 class="font-bold italic text-xl">{{ $blog->title }}
                        </h1>
                        <p class="text-sm font-semibold text-slate-700">
                            <span class="text-accent">Од: {{ $blog->user->name }} {{ $blog->user->surname }}
                            </span>
                            | {{ $blog->created_at->format('M d, Y') }}
                        </p>
                    </div>
                    <a class="self-end mt-4 bg-accent p-2 text-white rounded-xl text-xs"
                        href="{{ route('blogs.userShow', $blog->id) }}">Прочитај
                        повеќе</a>
                </div>
            </div>
            @endif
            @endforeach
        </div>
    </div>

</x-layout>
