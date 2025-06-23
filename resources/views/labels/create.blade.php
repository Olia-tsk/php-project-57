<x-app-layout>
    <section class="bg-white dark:bg-gray-900">
        <div class="grid max-w-screen-xl px-4 pt-20 pb-8 mx-auto lg:gap-8 xl:gap-0 lg:py-16 lg:grid-cols-12 lg:pt-28">
            <div class="grid col-span-full">
                <h1 class="mb-5">Создать метку</h1>

                {{ html()->modelForm($label, 'POST', route('labels.store'))->class('w-50')->open() }}

                {{ html()->div()->class('flex flex-col')->open() }}
                <div>
                    {{ html()->label(__('app.pages.name'), 'name') }}
                </div>

                <div class="mt-2">
                    {{ html()->text('name')->class('form-field')->classIf($errors->has('name'), 'border-rose-600') }}
                    @if ($errors->has('name'))
                        <p class="text-rose-600">{{ $errors->first('name') }}</p>
                    @endif
                </div>

                <div class="mt-2">
                    {{ html()->label(__('app.pages.description'), 'description') }}
                </div>

                <div class="mt-2">
                    {{ html()->textarea('description')->class('form-field h-32') }}
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
