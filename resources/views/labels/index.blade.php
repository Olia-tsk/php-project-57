<x-app-layout>
    <section class="bg-white">
        <div class="grid max-w-screen-xl px-4 pt-20 pb-8 mx-auto lg:gap-8 xl:gap-0 lg:py-16 lg:grid-cols-12 lg:pt-28">
            <div class="grid col-span-full">

                <x-notification></x-notification>

                <h1 class="mb-5">@lang('app.pages.labels')</h1>

                @can('create', $labelModel)
                    <div>
                        <a href="{{ route('labels.create') }}" class="blue-button">
                            @lang('app.pages.createLabel')
                        </a>
                    </div>
                @endcan

                <table class="mt-4">
                    <thead class="border-b-2 border-solid border-black text-left">
                        <tr>
                            <th>ID</th>
                            <th>@lang('app.pages.name')</th>
                            <th>@lang('app.pages.description')</th>
                            <th>@lang('app.pages.createdDate')</th>
                            @canany(['update', 'delete'], $labelModel)
                                <th>@lang('app.pages.actions')</th>
                            @endcanany
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($labels as $label)
                            <tr class="border-b border-dashed text-left">
                                <td>{{ $label->id }}</td>
                                <td>{{ $label->name }}</td>
                                <td>{{ $label->description }}</td>
                                <td>{{ $label->created_at }}</td>
                                <td>
                                    @can('delete', $label)
                                        <a data-confirm="@lang('app.pages.confirm')" data-method="delete" class="delete-link"
                                            href="{{ route('labels.destroy', $label) }}">
                                            @lang('app.pages.delete')
                                        </a>
                                    @endcan
                                    @can('update', $label)
                                        <a class="edit-link" href="{{ route('labels.edit', $label) }}">
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
