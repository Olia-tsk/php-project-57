<header class="fixed w-full">
    <nav class="bg-white border-gray-200 py-2.5 shadow-md">
        <div class="flex flex-wrap items-center justify-between max-w-screen-xl px-4 mx-auto">
            <a href="{{ route('/') }}" class="flex items-center">
                <span class="self-center text-xl font-semibold whitespace-nowrap">
                    @lang('app.name')
                </span>
            </a>

            <div class="flex items-center lg:order-2">
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

            <div class="items-center justify-between hidden w-full lg:flex lg:w-auto lg:order-1">
                <ul class="flex flex-col mt-4 font-medium lg:flex-row lg:space-x-8 lg:mt-0">
                    <li>
                        <a href="{{ route('tasks.index') }}"
                            class="nav-menu-item @ifCurrent('tasks') text-blue-700 @else text-gray-700 @endifCurrent">
                            @lang('app.tasks')
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('task_statuses.index') }}"
                            class="nav-menu-item @ifCurrent('task_statuses.index') text-blue-700 @else text-gray-700 @endifCurrent">
                            @lang('app.statuses')
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('labels') }}"
                            class="nav-menu-item @ifCurrent('labels') text-blue-700 @else text-gray-700 @endifCurrent">
                            @lang('app.labels')
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>
