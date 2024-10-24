<x-layout>

    <div class="p-4 w-full mx-auto">
        <div class="max-w-[1240px] mx-auto">
            <div
                class="relative flex flex-col w-full h-full text-slate-700 bg-white shadow-md rounded-xl bg-clip-border">

                <div class="relative mx-4 mt-4 overflow-hidden text-slate-700 bg-white rounded-none bg-clip-border">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-slate-800">Активна Конференција</h3>

                        <a href=" {{ route('conferences.create') }} "
                            class="flex select-none items-center gap-2 rounded bg-slate-800 py-2.5 px-4 text-xs font-semibold text-white"
                            type="button">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                class="size-5">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm.75-11.25a.75.75 0 0 0-1.5 0v2.5h-2.5a.75.75 0 0 0 0 1.5h2.5v2.5a.75.75 0 0 0 1.5 0v-2.5h2.5a.75.75 0 0 0 0-1.5h-2.5v-2.5Z"
                                    clip-rule="evenodd" />
                            </svg>

                            Додади конференција
                        </a>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full mt-4 text-left table-auto min-w-max">
                        <thead>
                            <tr>
                                <th
                                    class="p-4 transition-colors cursor-default border-y border-slate-200 bg-slate-50 hover:bg-slate-100">
                                    <h1 class="capitalize font-medium text-sm">Title</h1>
                                </th>

                                <th
                                    class="p-4 transition-colors cursor-default border-y border-slate-200 bg-slate-50 hover:bg-slate-100">
                                    <h1 class="capitalize font-medium text-sm">Status</h1>
                                </th>

                                <th
                                    class="p-4 transition-colors cursor-default border-y border-slate-200 bg-slate-50 hover:bg-slate-100">
                                    <h1 class="capitalize font-medium text-sm">Се оддржува на</h1>
                                </th>
                                <th
                                    class="p-4 transition-colors cursor-default border-y border-slate-200 bg-slate-50 hover:bg-slate-100">
                                    <h1 class="capitalize font-medium text-sm">Специјални гости</h1>
                                </th>
                                <th
                                    class="p-4 transition-colors cursor-default border-y border-slate-200 bg-slate-50 hover:bg-slate-100">
                                    <h1 class="capitalize font-medium text-sm">Говорници</h1>
                                </th>
                                <th
                                    class="p-4 transition-colors cursor-default border-y border-slate-200 bg-slate-50 hover:bg-slate-100">
                                </th>
                            </tr>
                        </thead>
                        {{-- active conference --}}
                        <tbody>
                            @foreach ($conferences->where('status', 'active') as $conference)
                                <tr class="border-b">
                                    <td class="p-4 border-b border-slate-200">
                                        <p class="text-sm font-semibold text-slate-700">
                                            {{ $conference->title }}
                                        </p>
                                    </td>
                                    <td class="p-4 border-b border-slate-200">
                                        <p class="text-sm uppercase italic font-semibold text-slate-700">
                                            {{ $conference->status }}
                                        </p>
                                    </td>
                                    <td class="p-4 border-b border-slate-200">
                                        <p class="text-sm font-semibold text-slate-700">
                                            {{ \Carbon\Carbon::parse($conference->start_date)->format('d') }} -
                                            {{ \Carbon\Carbon::parse($conference->end_date)->format('d M Y') }}
                                        </p>
                                    </td>
                                    <td class="p-4 border-b border-slate-200">
                                        <div class="flex flex-col items-center w-1/2">
                                            <p class="text-sm font-semibold text-slate-700">
                                                {{ $conference->speakers->where('is_special_guest', true)->count() }}
                                            </p>
                                        </div>
                                    </td>
                                    <td class="p-4 border-b border-slate-200">
                                        <div class="flex flex-col items-center w-1/2">
                                            <p class="text-sm font-semibold text-slate-700">
                                                {{ $conference->speakers->count() }}
                                            </p>
                                        </div>
                                    </td>
                                    <td class="p-4 border-b border-slate-200">
                                        <a href=" {{ route('conferences.show', $conference->id) }} "
                                            class="flex items-center text-slate-900 transition-all hover:bg-slate-900/10 rounded-xl text-xs p-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                fill="currentColor" class="size-4 mr-1">
                                                <path d=" M10 12.5a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z" />
                                                <path fill-rule="evenodd"
                                                    d="M.664 10.59a1.651 1.651 0 0 1 0-1.186A10.004 10.004 0 0 1 10 3c4.257 0 7.893 2.66 9.336 6.41.147.381.146.804 0 1.186A10.004 10.004 0 0 1 10 17c-4.257 0-7.893-2.66-9.336-6.41ZM14 10a4 4 0 1 1-8 0 4 4 0 0 1 8 0Z"
                                                    clip-rule="evenodd" />
                                            </svg>

                                            Настан
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>

                        {{-- inactive ( already finished ) conference --}}
                        <tbody>
                            @foreach ($conferences->where('status', 'inactive') as $conference)
                                <tr class="border-b">
                                    <td class="p-4 border-b border-slate-200">
                                        <p class="text-sm font-semibold text-slate-300">
                                            {{ $conference->title }}
                                        </p>
                                    </td>
                                    <td class="p-4 border-b border-slate-200">
                                        <p class="text-sm uppercase italic font-semibold text-slate-300">
                                            {{ $conference->status }}
                                        </p>
                                    </td>
                                    <td class="p-4 border-b border-slate-200">
                                        <p class="text-sm font-semibold text-slate-300">
                                            {{ \Carbon\Carbon::parse($conference->start_date)->format('d') }} -
                                            {{ \Carbon\Carbon::parse($conference->end_date)->format('d M Y') }}
                                        </p>
                                    </td>
                                    <td class="p-4 border-b border-slate-200">
                                        <div class="flex flex-col items-center w-1/2">
                                            <p class="text-sm font-semibold text-slate-300">
                                                {{ $conference->speakers->where('is_special_guest', true)->count() }}
                                            </p>
                                        </div>
                                    </td>
                                    <td class="p-4 border-b border-slate-200">
                                        <div class="flex flex-col items-center w-1/2">
                                            <p class="text-sm font-semibold text-slate-300">
                                                {{ $conference->speakers->count() }}
                                            </p>
                                        </div>
                                    </td>
                                    <td class="p-4 border-b border-slate-200">
                                        <a href=" {{ route('conferences.show', $conference->id) }} "
                                            class="flex items-center text-slate-300 transition-all hover:bg-slate-900/10 rounded-xl text-xs p-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                fill="currentColor" class="size-4 mr-1">
                                                <path d=" M10 12.5a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z" />
                                                <path fill-rule="evenodd"
                                                    d="M.664 10.59a1.651 1.651 0 0 1 0-1.186A10.004 10.004 0 0 1 10 3c4.257 0 7.893 2.66 9.336 6.41.147.381.146.804 0 1.186A10.004 10.004 0 0 1 10 17c-4.257 0-7.893-2.66-9.336-6.41ZM14 10a4 4 0 1 1-8 0 4 4 0 0 1 8 0Z"
                                                    clip-rule="evenodd" />
                                            </svg>

                                            Настан
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>

                        {{-- canceled conference --}}
                        <tbody>
                            @foreach ($conferences->where('status', 'canceled') as $conference)
                                <tr class="border-b">
                                    <td class="p-4 border-b border-slate-200">
                                        <p class="text-sm font-semibold text-red-300">
                                            {{ $conference->title }}
                                        </p>
                                    </td>
                                    <td class="p-4 border-b border-slate-200">
                                        <p class="text-sm uppercase italic font-semibold text-red-300">
                                            {{ $conference->status }}
                                        </p>
                                    </td>
                                    <td class="p-4 border-b border-slate-200">
                                        <p class="text-sm font-semibold text-red-300">
                                            {{ \Carbon\Carbon::parse($conference->start_date)->format('d') }} -
                                            {{ \Carbon\Carbon::parse($conference->end_date)->format('d M Y') }}
                                        </p>
                                    </td>
                                    <td class="p-4 border-b border-slate-200">
                                        <div class="flex flex-col items-center w-1/2">
                                            <p class="text-sm font-semibold text-red-300">
                                                {{ $conference->speakers->where('is_special_guest', true)->count() }}
                                            </p>
                                        </div>
                                    </td>
                                    <td class="p-4 border-b border-slate-200">
                                        <div class="flex flex-col items-center w-1/2">
                                            <p class="text-sm font-semibold text-red-300">
                                                {{ $conference->speakers->count() }}
                                            </p>
                                        </div>
                                    </td>
                                    <td class="p-4 border-b border-slate-200">
                                        <a href=" {{ route('conferences.show', $conference->id) }} "
                                            class="flex items-center text-red-300 transition-all hover:bg-slate-900/10 rounded-xl text-xs p-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                fill="currentColor" class="size-4 mr-1">
                                                <path d=" M10 12.5a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z" />
                                                <path fill-rule="evenodd"
                                                    d="M.664 10.59a1.651 1.651 0 0 1 0-1.186A10.004 10.004 0 0 1 10 3c4.257 0 7.893 2.66 9.336 6.41.147.381.146.804 0 1.186A10.004 10.004 0 0 1 10 17c-4.257 0-7.893-2.66-9.336-6.41ZM14 10a4 4 0 1 1-8 0 4 4 0 0 1 8 0Z"
                                                    clip-rule="evenodd" />
                                            </svg>

                                            Настан
                                        </a>
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
