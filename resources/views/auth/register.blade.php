<x-layout>

    <div class="p-4 w-full mx-auto">

        <x-page-heading>Register</x-page-heading>

        <x-forms.form method="POST" action="/register" enctype="multipart/form-data">

            <x-forms.input label="Име" name="name" />

            <x-forms.input label="Презиме" name="surname" />

            <x-forms.input label="Title" name="title" />


            <div class="flex space-x-6 items-center justify-center">
                <x-forms.input label="Твојот Email" type="email" name="email" />

                <x-forms.input label="Твојот телефонски број" name="phone" />
            </div>

            <div class="flex space-x-6 justify-center">
                <x-forms.input label="Град" name="city" />
                <x-forms.input label="Држава" name="country" />
            </div>

            <div class="flex space-x-6">
                <x-forms.input label="Ваша Фотографија" name="photo_path" type="file" />
                <x-forms.input label="Вашето CV" name="cv_path" type="file" />
            </div>

            <x-forms.textarea label="Нешто за вас" name="bio" />

            <x-forms.input label="Внесете сигурна Лозинка" type="password" name="password" />
            <x-forms.input label="Потврдете ја лозинката" type="password" name="password_confirmation" />






            <x-forms.divider />

            <x-forms.button>Create Account</x-forms.button>
        </x-forms.form>

    </div>
</x-layout>
