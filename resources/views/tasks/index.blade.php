<x-app-layout>
    <section class="bg-white dark:bg-gray-900">
        <div class="grid max-w-screen-xl px-4 pt-20 pb-8 mx-auto lg:gap-8 xl:gap-0 lg:py-16 lg:grid-cols-12 lg:pt-28">
            <div class="grid col-span-full">

                <x-notification></x-notification>

                <h1 class="mb-5">@lang('app.pages.tasks')</h1>

                <div class="w-full flex items-center">
                    <div>
                        <form method="GET" action="">
                            <div class="flex">
                                <select class="rounded border-gray-300" name="filter[status_id]" id="filter[status_id]">
                                    <option value="" selected="selected">@lang('app.pages.status')</option>
                                    <option value="1">новая</option>
                                    <option value="2">завершена</option>
                                    <option value="3">выполняется</option>
                                    <option value="4">в архиве</option>
                                </select>
                                <select class="rounded border-gray-300" name="filter[created_by_id]"
                                    id="filter[created_by_id]">
                                    <option value="" selected="selected">@lang('app.pages.author')</option>
                                    <option value="1">Рожков Василий Евгеньевич</option>
                                    <option value="2">Самсонова Фаина Максимовна</option>
                                    <option value="3">Стрелкова Любовь Романовна</option>
                                </select>
                                <select class="rounded border-gray-300" name="filter[assigned_to_id]"
                                    id="filter[assigned_to_id]">
                                    <option value="" selected="selected">@lang('app.pages.executor')</option>
                                    <option value="1">Рожков Василий Евгеньевич</option>
                                    <option value="2">Самсонова Фаина Максимовна</option>
                                    <option value="3">Стрелкова Любовь Романовна</option>
                                </select>
                                <button class="blue-button ml-2" type="submit">
                                    @lang('app.pages.apply')
                                </button>
                            </div>
                        </form>
                    </div>

                    @can('create', $taskModel)
                        <div class="ml-auto">
                            <a href="{{ route('tasks.create') }}" class="blue-button">
                                @lang('app.pages.createTask')
                            </a>
                        </div>
                    @endcan
                </div>

                <table class="mt-4">
                    <thead class="border-b-2 border-solid border-black text-left">
                        <tr>
                            <th>ID</th>
                            <th>@lang('app.pages.status')</th>
                            <th>@lang('app.pages.name')</th>
                            <th>@lang('app.pages.author')</th>
                            <th>@lang('app.pages.executor')</th>
                            <th>@lang('app.pages.createdDate')</th>
                            @canany(['update', 'delete'], $taskModel)
                                <th>@lang('app.pages.actions')</th>
                            @endcanany
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tasks as $task)
                            <tr class="border-b border-dashed text-left">
                                <td>{{ $task->id }}</td>
                                <td>{{ $task->status->name }}</td>
                                <td>
                                    <a class="text-blue-600 hover:text-blue-900"
                                        href="{{ route('tasks.show', $task) }}">
                                        {{ $task->name }}
                                    </a>
                                </td>
                                <td>{{ $task->createdBy->name }}</td>
                                <td>{{ $task->assigned_to_id ? $task->assignedTo->name : 'Не указан' }}</td>
                                <td>{{ $task->created_at }}</td>
                                <td>
                                    @can('delete', $task)
                                        <a data-confirm="@lang('app.pages.confirm')" data-method="delete" rel="nofollow"
                                            class="text-red-600 hover:text-red-900"
                                            href="{{ route('tasks.destroy', $task) }}">
                                            @lang('app.pages.delete')
                                        </a>
                                    @endcan
                                    @can('update', $task)
                                        <a href="{{ route('tasks.edit', $task) }}"
                                            class="text-blue-600 hover:text-blue-900">
                                            @lang('app.pages.edit')
                                        </a>
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="mt-4">
                    <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-between">
                        <div class="flex justify-between flex-1 sm:hidden">
                            <span
                                class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default leading-5 rounded-md dark:text-gray-600 dark:bg-gray-800 dark:border-gray-600">
                                « Previous
                            </span>

                            <a href="#"
                                class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 rounded-md hover:text-gray-500 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-300 dark:focus:border-blue-700 dark:active:bg-gray-700 dark:active:text-gray-300">
                                Next »
                            </a>
                        </div>

                        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                            <div>
                                <p class="text-sm text-gray-700 leading-5 dark:text-gray-400">
                                    Showing
                                    <span class="font-medium">1</span>
                                    to
                                    <span class="font-medium">15</span>
                                    of
                                    <span class="font-medium">16</span>
                                    results
                                </p>
                            </div>

                            <div>
                                <span class="relative z-0 inline-flex rtl:flex-row-reverse shadow-sm rounded-md">
                                    <span aria-disabled="true" aria-label="&amp;laquo; Previous">
                                        <span
                                            class="relative inline-flex items-center px-2 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default rounded-l-md leading-5 dark:bg-gray-800 dark:border-gray-600"
                                            aria-hidden="true">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                                    clip-rule="evenodd"></path>
                                            </svg>
                                        </span>
                                    </span>

                                    <span aria-current="page">
                                        <span
                                            class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default leading-5 dark:bg-gray-800 dark:border-gray-600">
                                            1
                                        </span>
                                    </span>
                                    <a href="#"
                                        class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 hover:text-gray-500 focus:z-10 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-400 dark:hover:text-gray-300 dark:active:bg-gray-700 dark:focus:border-blue-800"
                                        aria-label="Go to page 2">
                                        2
                                    </a>

                                    <a href="#" rel="next"
                                        class="relative inline-flex items-center px-2 py-2 -ml-px text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-r-md leading-5 hover:text-gray-400 focus:z-10 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-500 transition ease-in-out duration-150 dark:bg-gray-800 dark:border-gray-600 dark:active:bg-gray-700 dark:focus:border-blue-800"
                                        aria-label="Next &amp;raquo;">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                    </a>
                                </span>
                            </div>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>
