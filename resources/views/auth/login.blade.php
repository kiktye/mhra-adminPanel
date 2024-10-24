<x-layout>
    <div class="p-4 w-full mx-auto">

        <x-page-heading>Login</x-page-heading>

        <x-forms.form method="POST" action="/login">

            <x-forms.input label="Email" type="email" name="email" />

            <x-forms.input label="Password" type="password" name="password" />

            <x-forms.divider />

            <x-forms.button>Log in</x-forms.button>
        </x-forms.form>

    </div>
</x-layout>
