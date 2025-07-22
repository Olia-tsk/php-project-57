<header x-data="{ open: false }" @keydown.window.escape="open = false" :data-open="open"
    class="bg-white border-gray-200 shadow-md fixed w-full">
    <nav class="mx-auto flex max-w-7xl items-center justify-between p-4 py-2.5 lg:px-4" aria-label="Global">
        <div class="flex lg:flex-1">
            <a href="{{ route('/') }}" class="-m-1.5 p-1.5">
                <span class="self-center text-xl font-semibold whitespace-nowrap">
                    @lang('app.name')
                </span>
            </a>
        </div>

        <div class="flex lg:hidden">
            <button type="button" class="-m-2.5 inline-flex items-center justify-center rounded-md p-2.5 text-gray-700"
                @click="open = true">
                <span class="sr-only">Open main menu</span>
                <svg class="size-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                    aria-hidden="true" data-slot="icon">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"></path>
                </svg>
            </button>
        </div>

        <div class="hidden lg:flex lg:gap-x-12">
            <a href="{{ route('tasks.index') }}"
                class="nav-menu-item @ifCurrent('tasks.index') text-blue-700 @else text-gray-700 @endifCurrent">
                @lang('app.tasks')
            </a>
            <a href="{{ route('task_statuses.index') }}"
                class="nav-menu-item @ifCurrent('task_statuses.index') text-blue-700 @else text-gray-700 @endifCurrent">
                @lang('app.statuses')
            </a>
            <a href="{{ route('labels.index') }}"
                class="nav-menu-item @ifCurrent('labels.index') text-blue-700 @else text-gray-700 @endifCurrent">
                @lang('app.labels')
            </a>
        </div>

        <div class="hidden lg:flex lg:flex-1 lg:justify-end">
            @if (Route::has('login'))
                @auth
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-dropdown-link :href="route('logout')" onclick="event.preventDefault();this.closest('form').submit();">
                            @lang('app.logout')
                        </x-dropdown-link>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="blue-button">
                        @lang('app.login')
                    </a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="blue-button ml-2">
                            @lang('app.registration')
                        </a>
                    @endif
                @endauth
            @endif
        </div>
    </nav>

    <div class="lg:hidden" x-description="Mobile menu, show/hide based on menu open state." x-ref="dialog"
        x-show="open" aria-modal="true">
        <div class="fixed inset-0 z-50"></div>
        <div class="fixed inset-y-0 right-0 z-50 w-full overflow-y-auto bg-white p-6 sm:max-w-sm sm:ring-1 sm:ring-gray-900/10"
            @click.away="open = false">
            <div class="flex items-center justify-between">
                <a href="{{ route('/') }}" class="-m-1.5 p-1.5">
                    <span class="self-center text-xl font-semibold whitespace-nowrap">
                        @lang('app.name')
                    </span>
                </a>
                <button type="button" class="-m-2.5 rounded-md p-2.5 text-gray-700" @click="open = false">
                    <svg class="size-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                        aria-hidden="true" data-slot="icon">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div class="mt-6 flow-root">
                <div class="-my-6 divide-y divide-gray-500/10">
                    <div class="space-y-2 py-6">
                        <a href="{{ route('tasks.index') }}"
                            class="-mx-3 nav-menu-item @ifCurrent('tasks.index') text-blue-700 @else text-gray-700 @endifCurrent">
                            @lang('app.tasks')
                        </a>
                        <a href="{{ route('task_statuses.index') }}"
                            class="-mx-3 nav-menu-item @ifCurrent('task_statuses.index') text-blue-700 @else text-gray-700 @endifCurrent">
                            @lang('app.statuses')
                        </a>
                        <a href="{{ route('labels.index') }}"
                            class="-mx-3 nav-menu-item @ifCurrent('labels.index') text-blue-700 @else text-gray-700 @endifCurrent">
                            @lang('app.labels')
                        </a>
                    </div>
                    <div class="py-6">
                        @if (Route::has('login'))
                            @auth
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault();this.closest('form').submit();">
                                        @lang('app.logout')
                                    </x-dropdown-link>
                                </form>
                            @else
                                <a href="{{ route('login') }}" class="blue-button">
                                    @lang('app.login')
                                </a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="blue-button ml-2">
                                        @lang('app.registration')
                                    </a>
                                @endif
                            @endauth
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
