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
                                <td>
                                    {{ $task->assigned_to_id ? $task->assignedTo->name : __('app.pages.executorNotSpecified') }}
                                </td>
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
                    {{ $tasks->links() }}
                </div>
            </div>
        </div>
    </section>
</x-app-layout>
