<x-layout>

    <div class="p-4 w-full mx-auto">
        <div class="max-w-[1240px] mx-auto">
            <div
                class="relative flex flex-col w-full h-full text-slate-700 bg-white shadow-md rounded-xl bg-clip-border">
                <div class="relative mx-4 mt-4 overflow-hidden text-slate-700 bg-white rounded-none bg-clip-border">
                    <div class="flex items-center justify-between ">
                        <div>
                            <h3 class="text-lg font-semibold text-slate-800">Листа на корисници</h3>
                        </div>
                    </div>
                </div>


                <div class="p-0 overflow-scroll">
                    <table class="w-full mt-4 text-left table-auto min-w-max">
                        <thead>
                            <tr>
                                <th
                                    class="p-4 transition-colors cursor-default border-y border-slate-200 bg-slate-50 hover:bg-slate-100">
                                    <h1 class="capitalize font-medium text-sm">Корисник</h1>
                                </th>
                                <th
                                    class="p-4 transition-colors cursor-default border-y border-slate-200 bg-slate-50 hover:bg-slate-100">
                                    <h1 class="capitalize font-medium text-sm">Титула</h1>
                                </th>
                                <th
                                    class="p-4 transition-colors cursor-default border-y border-slate-200 bg-slate-50 hover:bg-slate-100">
                                    <h1 class="capitalize font-medium text-sm">Локација</h1>
                                </th>
                                <th
                                    class="p-4 transition-colors cursor-default border-y border-slate-200 bg-slate-50 hover:bg-slate-100">
                                    <h1 class="capitalize font-medium text-sm">Телефон</h1>
                                </th>
                                <th
                                    class="p-4 transition-colors cursor-default border-y border-slate-200 bg-slate-50 hover:bg-slate-100">
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users->where('is_admin', 0) as $user)
                                <tr class="{{ $user->restricted ? 'bg-red-50' : 'bg-white' }}">
                                    <td class="p-4 border-b border-slate-200">
                                        <div class="flex items-center gap-3">
                                            <img src=" {{ asset('storage/' . $user->photo_path) }} "
                                                alt="will upload later"
                                                class="relative inline-block h-9 w-9 !rounded-full object-cover object-center" />
                                            <div class="flex flex-col">
                                                <p class="text-sm font-semibold text-slate-700 ">
                                                    {{ $user->name }} {{ $user->surname }}
                                                </p>
                                                <p class="text-sm text-slate-500">
                                                    {{ $user->email }}
                                                </p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="p-4 border-b border-slate-200">
                                        <div class="flex flex-col">
                                            <p class="text-sm font-semibold text-slate-700">
                                                {{ $user->title }}
                                            </p>
                                        </div>
                                    </td>
                                    <td class="p-4 border-b border-slate-200">
                                        <div class="flex flex-col">
                                            <p class="text-sm font-semibold text-slate-700">
                                                {{ $user->city }}, {{ $user->country }}
                                            </p>
                                        </div>
                                    </td>
                                    <td class="p-4 border-b border-slate-200">
                                        <p class="text-sm text-slate-500">
                                            {{ $user->phone }}
                                        </p>
                                    </td>
                                    <td class="p-4 border-b border-slate-200">
                                        <div class="flex items-center">
                                            @if (!$user->is_admin)
                                                @if ($user->restricted)
                                                    <form method="POST"
                                                        action="{{ route('users.restore', $user->id) }}">
                                                        @csrf
                                                        @method('PUT')
                                                        <button
                                                            class="rounded-md bg-red-500 py-1.5 px-2 text-2xs font-semibold text-white shadow-md"
                                                            type="submit">Отстрани рестрикции</button>
                                                    </form>
                                                @endif
                                                <a href="{{ route('users.show', $user->id) }}"
                                                    class="flex items-center text-slate-900 transition-all hover:bg-slate-900/10 rounded-xl text-xs p-2">
                                                    <svg viewBox="0 0 20 20" fill="currentColor" class="size-4 mr-1">
                                                        <path d=" M10 12.5a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z" />
                                                        <path fill-rule="evenodd"
                                                            d="M.664 10.59a1.651 1.651 0 0 1 0-1.186A10.004 10.004 0 0 1 10 3c4.257 0 7.893 2.66 9.336 6.41.147.381.146.804 0 1.186A10.004 10.004 0 0 1 10 17c-4.257 0-7.893-2.66-9.336-6.41ZM14 10a4 4 0 1 1-8 0 4 4 0 0 1 8 0Z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                    Корисник
                                                </a>
                                            @endif


                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="flex items-center justify-between p-3">
                    <p class="block text-sm text-slate-500">
                        Page 1 of 1
                    </p>
                    <div class="flex gap-1">
                        <button
                            class="rounded border border-slate-300 py-2.5 px-3 text-center text-xs font-semibold text-slate-600 transition-all hover:opacity-75 focus:ring focus:ring-slate-300 active:opacity-[0.85] disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none"
                            type="button">
                            Previous
                        </button>
                        <button
                            class="rounded border border-slate-300 py-2.5 px-3 text-center text-xs font-semibold text-slate-600 transition-all hover:opacity-75 focus:ring focus:ring-slate-300 active:opacity-[0.85] disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none"
                            type="button">
                            Next
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-layout>
{{-- {{ $comment->trashed() ? 'bg-gray-100' : 'bg-white' }} --}}
