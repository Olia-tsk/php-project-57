<x-app-layout>
    <section class="bg-white">
        <div class="max-w-screen-xl px-4 pt-20 pb-8 mx-auto lg:py-16 lg:pt-28">

            <h1 class="mb-5 page-title">@lang('app.pages.createTask')</h1>

            {{ html()->modelForm($task, 'POST', route('tasks.store'))->open() }}

            {{ html()->div()->class('flex flex-col')->open() }}

            {{ html()->label(__('app.pages.name'), 'name') }}

            {{ html()->text('name')->class('form-field')->classIf($errors->has('name'), 'border-rose-600') }}
            @if ($errors->has('name'))
                <p class="text-rose-600">{{ $errors->first('name') }}</p>
            @endif

            {{ html()->label(__('app.pages.description'), 'description')->class('mt-2') }}

            {{ html()->textarea('description')->class('form-field h-32') }}

            {{ html()->label(__('app.pages.status'), 'status_id')->class('mt-2') }}

            {{ html()->select('status_id')->options(['' => ''] + $statuses)->value(old('status_id', ''))->class('form-field')->classIf($errors->has('status_id'), 'border-rose-600') }}
            @if ($errors->has('status_id'))
                <p class="text-rose-600">{{ $errors->first('status_id') }}</p>
            @endif

            {{ html()->label(__('app.pages.executor'), 'assigned_to_id')->class('mt-2') }}

            {{ html()->select('assigned_to_id')->options(['' => ''] + $users)->value(old('assigned_to_id', ''))->class('form-field') }}

            {{ html()->label(__('app.pages.labels'), 'labels[]')->class('mt-2') }}

            {{ html()->multiselect('labels[]')->options($labels)->class('form-field h-32') }}

            {{ html()->submit(__('app.pages.create'))->class('blue-button mt-2') }}

            {{ html()->div()->close() }}

            {{ html()->closeModelForm() }}

        </div>
    </section>
</x-app-layout>
