<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>MHRA | Admin Panel</title>
    <link rel="icon" href="{{ Vite::asset('resources/images/gna-logo.jpg') }}" />

    {{-- Preconnects and Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Mulish:ital,wght@0,200..1000;1,200..1000&display=swap"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">

    {{-- Scripts --}}
    <script src="//unpkg.com/alpinejs" defer></script>
    <script src="https://kit.fontawesome.com/f5fd16f46e.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>

    {{-- Vite Assets --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-grayish font-montserrat">

    <!-- Main Navigation -->
    <nav class="md:px-10 text-black bg-lighter drop-shadow-lg">
        <div class="md:w-[90%] md:mx-auto">
            <div class="relative flex items-center justify-between h-16">

                @if (Auth::user() && Auth::user()->is_admin == 1)
                    <div class="absolute inset-y-0 left-2 flex items-center sm:hidden">
                        <button type="button"
                            class="relative inline-flex items-center justify-center p-2 text-gna hover:text-gna"
                            aria-controls="sidebar" aria-expanded="false">
                            <span class="sr-only">Open main menu</span>
                            <!-- Open Icon (visible by default) -->
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                class="size-5 block">
                                <path
                                    d="M10 3.75a2 2 0 1 0-4 0 2 2 0 0 0 4 0ZM17.25 4.5a.75.75 0 0 0 0-1.5h-5.5a.75.75 0 0 0 0 1.5h5.5ZM5 3.75a.75.75 0 0 1-.75.75h-1.5a.75.75 0 0 1 0-1.5h1.5a.75.75 0 0 1 .75.75ZM4.25 17a.75.75 0 0 0 0-1.5h-1.5a.75.75 0 0 0 0 1.5h1.5ZM17.25 17a.75.75 0 0 0 0-1.5h-5.5a.75.75 0 0 0 0 1.5h5.5ZM9 10a.75.75 0 0 1-.75.75h-5.5a.75.75 0 0 1 0-1.5h5.5A.75.75 0 0 1 9 10ZM17.25 10.75a.75.75 0 0 0 0-1.5h-1.5a.75.75 0 0 0 0 1.5h1.5ZM14 10a2 2 0 1 0-4 0 2 2 0 0 0 4 0ZM10 16.25a2 2 0 1 0-4 0 2 2 0 0 0 4 0Z" />
                            </svg>
                            <!-- Close Icon (hidden by default) -->
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                class="size-5 hidden">
                                <path
                                    d="M6.225 4.811a1 1 0 0 0-1.414 1.414l6 6a1 1 0 0 0 1.414 0l6-6a1 1 0 0 0-1.414-1.414L12 9.586l-5.775-5.775Z" />
                            </svg>
                        </button>
                    </div>
                @endif

                <!-- Mobile dropdown button -->
                <div class="absolute inset-y-0 right-2 flex items-center sm:hidden">
                    <button type="button"
                        class="relative inline-flex items-center justify-center p-2 text-gna hover:text-gna"
                        aria-controls="mobile-menu" aria-expanded="false">
                        <span class="sr-only">Open main menu</span>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-5">
                            <path fill-rule="evenodd"
                                d="M2 10a8 8 0 1 1 16 0 8 8 0 0 1-16 0Zm8 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2Zm-3-1a1 1 0 1 1-2 0 1 1 0 0 1 2 0Zm7 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>

                <!-- Logo -->
                <div class="flex items-center justify-center flex-1 sm:flex-none">
                    <div class="w-10 h-10">
                        <a href="/" draggable="false">
                            <img class="rounded-full" draggable="false"
                                src="{{ Vite::asset('resources/images/mhra.png') }}" alt="Logo">
                        </a>
                    </div>
                </div>

                <!-- Right section -->
                <div
                    class="absolute hidden font-semibold inset-y-0 right-0 md:flex items-center pr-2 sm:static sm:inset-auto sm:ml-6 sm:pr-0">
                    @guest
                        <x-droplink href="{{ route('login') }}"> Login </x-droplink>
                        <x-droplink href=" {{ route('register') }} "> Register </x-droplink>
                    @endguest

                    @auth
                        <div class="flex w-full content-center justify-between md:justify-end">
                            <ul class="list-reset flex justify-between flex-1 md:flex-none items-center">
                                <!-- Dropdown -->
                                <li class="flex-1 md:flex-none md:mr-3">
                                    <div class="relative inline-block">
                                        <button onclick="toggleDD('myDropdown')" class="drop-button text-black py-2 px-6">
                                            {{ Auth::user()->name }}
                                            <svg class="h-3 fill-current inline" xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 20 20">
                                                <path
                                                    d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                                            </svg>
                                        </button>

                                        <div id="myDropdown"
                                            class="absolute bg-lighter p-3 right-0 overflow-auto z-30 invisible drop-shadow-sm rounded-b-xl">
                                            <x-droplink href=" # ">
                                                <i class="fa fa-user fa-fw mr-2"></i> Profile
                                            </x-droplink>
                                            <x-droplink href="/">
                                                <i class="fa fa-cog fa-fw mr-2"></i> Settings
                                            </x-droplink>
                                            <x-droplink href="/">
                                                <i class="fas fa-sign-out-alt fa-fw mr-2"></i>
                                                <form action="/logout" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button>Log Out</button>
                                                </form>
                                            </x-droplink>
                                        </div>

                                    </div>
                                </li>
                            </ul>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </nav>


    {{-- mobile dropdown --}}
    <div class="sm:hidden fixed top-25 left-0 right-0 z-50 bg-lighter drop-shadow-lg hidden" id="mobile-menu">
        <div class="space-y-1 px-2 pb-3 pt-2 transition-all duration-300">
            @guest
                <x-droplink href="{{ route('login') }}"> Login </x-droplink>
                <x-droplink href=" {{ route('register') }} "> Register </x-droplink>
            @endguest

            @auth
                <x-droplink href="/">
                    <i class="fa fa-user fa-fw mr-2"></i> Profile
                </x-droplink>
                <x-droplink href="/">
                    <i class="fa fa-cog fa-fw mr-2"></i> Settings
                </x-droplink>
                <x-droplink href="/">
                    <i class="fas fa-sign-out-alt fa-fw mr-2"></i>
                    <form action="/logout" method="POST">
                        @csrf
                        @method('DELETE')
                        <button>Log Out</button>
                    </form>
                </x-droplink>
            @endauth
        </div>
    </div>


    @if (Auth::user() && Auth::user()->is_admin == 1)
        <div class="md:flex">

            <div id="sidebar"
                class="md:relative md:block top-0.5 md:left-0 md:z-10 hidden min-h-screen w-60 bg-lighter transition-all duration-300">

                <div class="border-r border-black/20 min-h-screen z-10 md:w-60">
                    <div class="text-left p-6">
                        <div class="mb-6">
                            <p class="uppercase text-xs text-gray-600 mb-4 tracking-wider">Management</p>
                            <div class="flex flex-col">
                                <x-iconlink href="{{ route('admin.dashboard') }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="size-5 mr-2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M10.5 6h9.75M10.5 6a1.5 1.5 0 1 1-3 0m3 0a1.5 1.5 0 1 0-3 0M3.75 6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m-3.75 0H7.5m9-6h3.75m-3.75 0a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m-9.75 0h9.75" />
                                    </svg>
                                    <x-slot name="text">Admin Dashboard</x-slot>
                                </x-iconlink>

                                <x-iconlink href="{{ route('generalInfo.show') }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="size-5 mr-2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M11.42 15.17 17.25 21A2.652 2.652 0 0 0 21 17.25l-5.877-5.877M11.42 15.17l2.496-3.03c.317-.384.74-.626 1.208-.766M11.42 15.17l-4.655 5.653a2.548 2.548 0 1 1-3.586-3.586l6.837-5.63m5.108-.233c.55-.164 1.163-.188 1.743-.14a4.5 4.5 0 0 0 4.486-6.336l-3.276 3.277a3.004 3.004 0 0 1-2.25-2.25l3.276-3.276a4.5 4.5 0 0 0-6.336 4.486c.091 1.076-.071 2.264-.904 2.95l-.102.085m-1.745 1.437L5.909 7.5H4.5L2.25 3.75l1.5-1.5L7.5 4.5v1.409l4.26 4.26m-1.745 1.437 1.745-1.437m6.615 8.206L15.75 15.75M4.867 19.125h.008v.008h-.008v-.008Z" />
                                    </svg>

                                    <x-slot name="text">Homepage</x-slot>
                                </x-iconlink>
                            </div>
                        </div>

                        <div class="mb-6">
                            <p class="uppercase text-xs text-gray-600 mb-4 tracking-wider">User Management</p>
                            <div class="flex flex-col">
                                <x-iconlink href=" {{ route('users.index') }} ">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="size-5 mr-2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                                    </svg>



                                    <x-slot name="text">Корисници</x-slot>
                                </x-iconlink>

                                <x-iconlink href=" {{ route('employees.index') }}  ">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="size-5 mr-2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 0 0 .75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 0 0-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0 1 12 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 0 1-.673-.38m0 0A2.18 2.18 0 0 1 3 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 0 1 3.413-.387m7.5 0V5.25A2.25 2.25 0 0 0 13.5 3h-3a2.25 2.25 0 0 0-2.25 2.25v.894m7.5 0a48.667 48.667 0 0 0-7.5 0M12 12.75h.008v.008H12v-.008Z" />
                                    </svg>


                                    <x-slot name="text">Вработени</x-slot>
                                </x-iconlink>

                                <x-iconlink href=" {{ route('speakers.index') }}  ">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-5 mr-2">
                                        <path fill-rule="evenodd" d="M9 2.25a.75.75 0 0 1 .75.75v1.506a49.384 49.384 0 0 1 5.343.371.75.75 0 1 1-.186 1.489c-.66-.083-1.323-.151-1.99-.206a18.67 18.67 0 0 1-2.97 6.323c.318.384.65.753 1 1.107a.75.75 0 0 1-1.07 1.052A18.902 18.902 0 0 1 9 13.687a18.823 18.823 0 0 1-5.656 4.482.75.75 0 0 1-.688-1.333 17.323 17.323 0 0 0 5.396-4.353A18.72 18.72 0 0 1 5.89 8.598a.75.75 0 0 1 1.388-.568A17.21 17.21 0 0 0 9 11.224a17.168 17.168 0 0 0 2.391-5.165 48.04 48.04 0 0 0-8.298.307.75.75 0 0 1-.186-1.489 49.159 49.159 0 0 1 5.343-.371V3A.75.75 0 0 1 9 2.25ZM15.75 9a.75.75 0 0 1 .68.433l5.25 11.25a.75.75 0 1 1-1.36.634l-1.198-2.567h-6.744l-1.198 2.567a.75.75 0 0 1-1.36-.634l5.25-11.25A.75.75 0 0 1 15.75 9Zm-2.672 8.25h5.344l-2.672-5.726-2.672 5.726Z" clip-rule="evenodd" />
                                      </svg>
                                      


                                    <x-slot name="text">Говорници</x-slot>
                                </x-iconlink>

                            </div>
                        </div>

                        <div class="mb-6">
                            <p class="uppercase text-xs text-gray-600 mb-4 tracking-wider">Content</p>
                            <div class="flex flex-col">
                                <x-iconlink href="{{ route('blogs.index') }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="size-5 mr-2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                                    </svg>

                                    <x-slot name="text">Блогови</x-slot>
                                </x-iconlink>

                                <x-iconlink href="{{ route('events.index') }} ">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="size-5 mr-2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5m-9-6h.008v.008H12v-.008ZM12 15h.008v.008H12V15Zm0 2.25h.008v.008H12v-.008ZM9.75 15h.008v.008H9.75V15Zm0 2.25h.008v.008H9.75v-.008ZM7.5 15h.008v.008H7.5V15Zm0 2.25h.008v.008H7.5v-.008Zm6.75-4.5h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V15Zm0 2.25h.008v.008h-.008v-.008Zm2.25-4.5h.008v.008H16.5v-.008Zm0 2.25h.008v.008H16.5V15Z" />
                                    </svg>

                                    <x-slot name="text">Настани</x-slot>
                                </x-iconlink>

                                <x-iconlink href=" {{ route('conferences.index') }} ">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="size-5 mr-2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M3.75 3v11.25A2.25 2.25 0 0 0 6 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0 1 18 16.5h-2.25m-7.5 0h7.5m-7.5 0-1 3m8.5-3 1 3m0 0 .5 1.5m-.5-1.5h-9.5m0 0-.5 1.5m.75-9 3-3 2.148 2.148A12.061 12.061 0 0 1 16.5 7.605" />
                                    </svg>

                                    <x-slot name="text">Конференции</x-slot>
                                </x-iconlink>
                            </div>
                        </div>

                        <div class="mb-6">
                            <p class="uppercase text-xs text-gray-600 mb-4 tracking-wider">Tools</p>
                            <div class="flex flex-col">
                                <x-iconlink href="{{ route('agendas.create') }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="size-5 mr-2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M8.25 9V5.25A2.25 2.25 0 0 1 10.5 3h6a2.25 2.25 0 0 1 2.25 2.25v13.5A2.25 2.25 0 0 1 16.5 21h-6a2.25 2.25 0 0 1-2.25-2.25V15M12 9l3 3m0 0-3 3m3-3H2.25" />
                                    </svg>


                                    <x-slot name="text">Креирај агенда</x-slot>
                                </x-iconlink>

                                <x-iconlink href="{{ route('speakers.create') }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="size-5 mr-2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M19.114 5.636a9 9 0 0 1 0 12.728M16.463 8.288a5.25 5.25 0 0 1 0 7.424M6.75 8.25l4.72-4.72a.75.75 0 0 1 1.28.53v15.88a.75.75 0 0 1-1.28.53l-4.72-4.72H4.51c-.88 0-1.704-.507-1.938-1.354A9.009 9.009 0 0 1 2.25 12c0-.83.112-1.633.322-2.396C2.806 8.756 3.63 8.25 4.51 8.25H6.75Z" />
                                    </svg>


                                    <x-slot name="text">Додади говорник</x-slot>
                                </x-iconlink>

                                <x-iconlink href="#">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="size-5 mr-2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5m-9-6h.008v.008H12v-.008ZM12 15h.008v.008H12V15Zm0 2.25h.008v.008H12v-.008ZM9.75 15h.008v.008H9.75V15Zm0 2.25h.008v.008H9.75v-.008ZM7.5 15h.008v.008H7.5V15Zm0 2.25h.008v.008H7.5v-.008Zm6.75-4.5h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V15Zm0 2.25h.008v.008h-.008v-.008Zm2.25-4.5h.008v.008H16.5v-.008Zm0 2.25h.008v.008H16.5V15Z" />
                                    </svg>

                                    <x-slot name="text">Менаџирај Календар</x-slot>
                                </x-iconlink>

                            </div>
                        </div>

                        <div class="mb-6">
                            <p class="uppercase text-xs text-gray-600 mb-4 tracking-wider">Engagement</p>
                            <div class="flex flex-col">
                                <x-iconlink href="#">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="size-5 mr-2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 0 1-2.25 2.25M16.5 7.5V18a2.25 2.25 0 0 0 2.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 0 0 2.25 2.25h13.5M6 7.5h3v3H6v-3Z" />
                                    </svg>

                                    <x-slot name="text">Билтен</x-slot>
                                </x-iconlink>

                                <x-iconlink href="#">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="size-5 mr-2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 0 1 .865-.501 48.172 48.172 0 0 0 3.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0 0 12 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018Z" />
                                    </svg>

                                    <x-slot name="text">Коментари</x-slot>
                                </x-iconlink>

                                {{-- <x-iconlink href="#">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="size-5 mr-2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M6.633 10.25c.806 0 1.533-.446 2.031-1.08a9.041 9.041 0 0 1 2.861-2.4c.723-.384 1.35-.956 1.653-1.715a4.498 4.498 0 0 0 .322-1.672V2.75a.75.75 0 0 1 .75-.75 2.25 2.25 0 0 1 2.25 2.25c0 1.152-.26 2.243-.723 3.218-.266.558.107 1.282.725 1.282m0 0h3.126c1.026 0 1.945.694 2.054 1.715.045.422.068.85.068 1.285a11.95 11.95 0 0 1-2.649 7.521c-.388.482-.987.729-1.605.729H13.48c-.483 0-.964-.078-1.423-.23l-3.114-1.04a4.501 4.501 0 0 0-1.423-.23H5.904m10.598-9.75H14.25M5.904 18.5c.083.205.173.405.27.602.197.4-.078.898-.523.898h-.908c-.889 0-1.713-.518-1.972-1.368a12 12 0 0 1-.521-3.507c0-1.553.295-3.036.831-4.398C3.387 9.953 4.167 9.5 5 9.5h1.053c.472 0 .745.556.5.96a8.958 8.958 0 0 0-1.302 4.665c0 1.194.232 2.333.654 3.375Z" />
                                    </svg>


                                    <x-slot name="text">Лајкови</x-slot>
                                </x-iconlink> --}}
                            </div>
                        </div>
                    </div>
                </div>

            </div>
    @endif

    {{ $slot }}

    </div>

    <script>
        // Mobile Menu
        const mobileButton = document.querySelector(
            'button[aria-controls="mobile-menu"]'
        );
        const mobileMenu = document.getElementById("mobile-menu");
        const mobileOpenIcon = mobileButton.querySelector("svg.block");
        const mobileCloseIcon = mobileButton.querySelector("svg.hidden");

        mobileButton.setAttribute("aria-expanded", "false");
        mobileMenu.classList.add("hidden");

        function closeMobileMenu() {
            mobileButton.setAttribute("aria-expanded", "false");
            mobileMenu.classList.add("opacity-0", "pointer-events-none");
            mobileMenu.classList.remove("opacity-100", "pointer-events-auto");
            setTimeout(() => {
                mobileMenu.classList.add("hidden");
            }, 300);

            mobileOpenIcon.classList.remove("hidden");
            mobileCloseIcon.classList.add("hidden");
        }

        mobileButton.addEventListener("click", function() {
            const isExpanded = mobileButton.getAttribute("aria-expanded") === "true";

            if (isExpanded) {
                closeMobileMenu();
            } else {
                mobileButton.setAttribute("aria-expanded", "true");
                mobileMenu.classList.remove("hidden");
                setTimeout(() => {
                    mobileMenu.classList.add("opacity-100", "pointer-events-auto");
                    mobileMenu.classList.remove("opacity-0", "pointer-events-none");
                }, 10);

                mobileOpenIcon.classList.add("hidden");
                mobileCloseIcon.classList.remove("hidden");
            }
        });

        window.addEventListener("scroll", function() {
            if (mobileButton.getAttribute("aria-expanded") === "true") {
                closeMobileMenu();
            }
        });

        // Sidebar Menu
        const sidebarButton = document.querySelector(
            'button[aria-controls="sidebar"]'
        );
        const sidebar = document.getElementById("sidebar");
        const sidebarOpenIcon = sidebarButton.querySelector("svg.block");
        const sidebarCloseIcon = sidebarButton.querySelector("svg.hidden");

        sidebarButton.setAttribute("aria-expanded", "false");
        sidebar.classList.add("hidden");

        function closeSidebar() {
            sidebarButton.setAttribute("aria-expanded", "false");
            sidebar.classList.add("opacity-0", "pointer-events-none");
            sidebar.classList.remove("opacity-100", "pointer-events-auto");
            setTimeout(() => {
                sidebar.classList.add("hidden");
            }, 300);

            sidebarOpenIcon.classList.remove("hidden");
            sidebarCloseIcon.classList.add("hidden");
        }

        sidebarButton.addEventListener("click", function() {
            const isExpanded = sidebarButton.getAttribute("aria-expanded") === "true";

            if (isExpanded) {
                closeSidebar();
            } else {
                sidebarButton.setAttribute("aria-expanded", "true");
                sidebar.classList.remove("hidden");
                setTimeout(() => {
                    sidebar.classList.add("opacity-100", "pointer-events-auto");
                    sidebar.classList.remove("opacity-0", "pointer-events-none");
                }, 10);

                sidebarOpenIcon.classList.add("hidden");
                sidebarCloseIcon.classList.remove("hidden");
            }
        });
    </script>

    <script>
        function toggleDD(myDropMenu) {
            document.getElementById(myDropMenu).classList.toggle("invisible");
        }
    </script>

</body>

</html>
