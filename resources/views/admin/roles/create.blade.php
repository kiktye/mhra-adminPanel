<x-layout>
    <div class="p-4 w-full mx-auto">
        <div class="max-w-[1240px] mx-auto">
            <div
                class="relative flex flex-col w-full h-full text-slate-700 bg-white shadow-md rounded-xl bg-clip-border">

                <div class="relative mx-4 mt-4 overflow-hidden text-slate-700 bg-white rounded-none bg-clip-border">
                    <div class="flex items-center justify-between ">
                        <h3 class="text-lg font-semibold text-slate-800">Додади нова позиција</h3>


                    </div>
                </div>

                <div class="p-0 overflow-scroll">
                    <x-forms.form method="POST" action=" {{ route('roles.store') }} ">

                        <x-forms.input label="Име" name="name" id="name" value="{{ old('name') }}" />

                        <x-forms.divider />

                        <x-forms.button> Додади позиција </x-forms.button>

                    </x-forms.form>

                    
                </div>

                <div class="flex items-center justify-between p-3">
                    <p class="block text-sm text-slate-500"> </p>
                    <div class="flex gap-1"> </div>
                </div>
            </div>
        </div>
    </div>



</x-layout>
