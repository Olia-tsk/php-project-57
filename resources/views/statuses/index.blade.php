<x-app-layout>
    <section class="bg-white">
        <div class="max-w-screen-xl px-4 pt-20 pb-8 mx-auto lg:py-16 lg:pt-28">

            <x-notification></x-notification>

            <div class="mb-4 page-header">
                <h1 class="page-title">@lang('app.pages.statuses')</h1>

                @can('create', $taskStatusModel)
                    <a href="{{ route('task_statuses.create') }}" class="blue-button">
                        @lang('app.pages.createStatus')
                    </a>
                @endcan
            </div>

            <div class="overflow-x-auto">
                <table class="w-full table-auto">
                    <thead class="border-b-2 border-solid border-black text-left">
                        <tr>
                            <th>ID</th>
                            <th>@lang('app.pages.name')</th>
                            <th>@lang('app.pages.createdDate')</th>
                            @canany(['update', 'delete'], $taskStatusModel)
                                <th>@lang('app.pages.actions')</th>
                            @endcanany
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($taskStatuses as $taskStatus)
                            <tr class="border-b border-dashed text-left">
                                <td>{{ $taskStatus->id }}</td>
                                <td>{{ $taskStatus->name }}</td>
                                <td>{{ $taskStatus->formattedCreatedAt }}</td>
                                <td>
                                    @can('delete', $taskStatus)
                                        <a data-confirm="@lang('app.pages.confirm')" data-method="delete" rel="nofollow"
                                            class="delete-link" href="{{ route('task_statuses.destroy', $taskStatus) }}">
                                            @lang('app.pages.delete')
                                        </a>
                                    @endcan
                                    @can('update', $taskStatus)
                                        <a class="edit-link" href="{{ route('task_statuses.edit', $taskStatus) }}">
                                            @lang('app.pages.edit')
                                        </a>
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </section>
</x-app-layout>
