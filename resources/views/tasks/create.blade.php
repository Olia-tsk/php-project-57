<x-app-layout>
    <section class="bg-white">
        <div class="grid max-w-screen-xl px-4 pt-20 pb-8 mx-auto lg:gap-8 xl:gap-0 lg:py-16 lg:grid-cols-12 lg:pt-28">
            <div class="grid col-span-full">
                <h1 class="mb-5">@lang('app.pages.createTask')</h1>

                {{ html()->modelForm($task, 'POST', route('tasks.store'))->class('w-50')->open() }}

                {{ html()->div()->class('flex flex-col')->open() }}
                <div>
                    {{ html()->label(__('app.pages.name'), 'name') }}
                </div>
                <div>
                    {{ html()->text('name')->class('form-field')->classIf($errors->has('name'), 'border-rose-600') }}
                    @if ($errors->has('name'))
                        <p class="text-rose-600">{{ $errors->first('name') }}</p>
                    @endif
                </div>

                <div class="mt-2">
                    {{ html()->label(__('app.pages.description'), 'description') }}
                </div>
                <div>
                    {{ html()->textarea('description')->class('form-field h-32') }}
                </div>

                <div class="mt-2">
                    {{ html()->label(__('app.pages.status'), 'status_id') }}
                </div>
                <div>
                    {{ html()->select('status_id')->options(['' => ''] + $statuses)->value(old('status_id', ''))->class('form-field')->classIf($errors->has('status_id'), 'border-rose-600') }}
                    @if ($errors->has('status_id'))
                        <p class="text-rose-600">{{ $errors->first('status_id') }}</p>
                    @endif
                </div>

                <div class="mt-2">
                    {{ html()->label(__('app.pages.executor'), 'assigned_to_id') }}
                </div>
                <div>
                    {{ html()->select('assigned_to_id')->options(['' => ''] + $users)->value(old('assigned_to_id', ''))->class('form-field') }}
                </div>

                <div class="mt-2">
                    {{ html()->label(__('app.pages.labels'), 'labels[]') }}
                </div>
                <div>
                    {{ html()->multiselect('labels[]')->options($labels)->class('form-field h-32') }}
                </div>

                <div class="mt-2">
                    {{ html()->submit(__('app.pages.create'))->class('blue-button') }}
                </div>
                {{ html()->div()->close() }}

                {{ html()->closeModelForm() }}
            </div>
        </div>
    </section>
</x-app-layout>
