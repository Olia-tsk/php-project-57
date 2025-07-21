<x-app-layout>
    <section class="bg-white">
        <div class="grid max-w-screen-xl px-4 pt-20 pb-8 mx-auto lg:gap-8 xl:gap-0 lg:py-16 lg:grid-cols-12 lg:pt-28">
            <div class="grid col-span-full">

                <x-notification></x-notification>

                <h1 class="mb-5">@lang('app.pages.tasks')</h1>

                <div class="w-full flex items-center">
                    <div>
                        {{ html()->form('GET', route('tasks.index'))->open() }}

                        {{ html()->div()->class('flex')->open() }}

                        {{ html()->select('filter[status_id]')->options(['' => __('app.pages.status')] + $statuses)->value(request()->input('filter.status_id', ''))->class('rounded border-gray-300') }}

                        {{ html()->select('filter[created_by_id]')->options(['' => __('app.pages.author')] + $users)->value(request()->input('filter.created_by_id', ''))->class('rounded border-gray-300') }}

                        {{ html()->select('filter[assigned_to_id]')->options(['' => __('app.pages.executor')] + $users)->value(request()->input('filter.assigned_to_id', ''))->class('rounded border-gray-300') }}

                        {{ html()->submit(__('app.pages.apply'))->class('blue-button ml-2') }}

                        {{ html()->div()->close() }}

                        {{ html()->form()->close() }}
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
                                    <td>{{ $task->formattedCreatedAt }}</td>
                                <td>
                                    @can('delete', $task)
                                        <a data-confirm="@lang('app.pages.confirm')" data-method="delete" rel="nofollow"
                                            class="delete-link" href="{{ route('tasks.destroy', $task) }}">
                                            @lang('app.pages.delete')
                                        </a>
                                    @endcan
                                    @can('update', $task)
                                        <a href="{{ route('tasks.edit', $task) }}" class="edit-link">
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
