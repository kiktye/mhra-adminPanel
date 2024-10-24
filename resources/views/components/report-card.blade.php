
    <div {{ $attributes->merge(['class' => 'report-card']) }}>
        <div class="card">
            <div class="card-body flex flex-col">

                <div class="flex flex-row justify-between items-center">
                    <div class="text-xl {{ $icon }}"></div>
                    <span class="rounded-full py-0.5 px-2 text-white badge bg-teal-400 text-xs">
                        {{ $percentage }}% <i class="fa fa-chevron-up ml-1"></i>
                    </span>
                </div>

                <div class="mt-8 self-start items-start">
                    <h1 class="font-bold italic text-xl w-0">{{ $number }}</h1>
                    <p class="capitalize">{{ $description }}</p>
                </div>

            </div>
        </div>

        <div class="footer bg-white p-1 mx-4 border border-t-0 rounded rounded-t-none"></div>
    </div>
