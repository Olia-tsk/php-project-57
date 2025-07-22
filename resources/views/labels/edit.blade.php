<x-app-layout>
    <section class="bg-white">
        <div class="max-w-screen-xl px-4 pt-20 pb-8 mx-auto lg:py-16 lg:pt-28">

            <h1 class="mb-5 page-title">@lang('app.pages.updateLabel')</h1>

            {{ html()->modelForm($label, 'PATCH', route('labels.update', $label))->open() }}

            {{ html()->div()->class('flex flex-col')->open() }}

            {{ html()->label(__('app.pages.name'), 'name') }}

            {{ html()->text('name')->class('form-field')->classIf($errors->has('name'), 'border-rose-600') }}
            @if ($errors->has('name'))
                <p class="text-rose-600">{{ $errors->first('name') }}</p>
            @endif

            {{ html()->label(__('app.pages.description'), 'description')->class('mt-2') }}

            {{ html()->textarea('description')->class('form-field h-32') }}

            {{ html()->submit(__('app.pages.update'))->class('blue-button mt-2') }}

            {{ html()->div()->close() }}

            {{ html()->closeModelForm() }}

        </div>
    </section>
</x-app-layout>
