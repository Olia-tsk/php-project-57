<x-app-layout>
    <section class="bg-white">
        <div class="grid max-w-screen-xl px-4 pt-20 pb-8 mx-auto lg:gap-8 xl:gap-0 lg:py-16 lg:grid-cols-12 lg:pt-28">
            <div class="grid col-span-full">
                <h2 class="mb-5">
                    @lang('app.pages.taskShow'): {{ $task->name }}
                    @can('update', $task)
                        <a href="{{ route('tasks.edit', $task) }}">⚙</a>
                    @endcan
                </h2>

                <p>
                    <span class="font-black">@lang('app.pages.taskName'):</span> {{ $task->name }}
                </p>
                <p>
                    <span class="font-black">@lang('app.pages.status'):</span> {{ $task->status->name }}
                </p>
                <p>
                    <span class="font-black">@lang('app.pages.description'):</span> {{ $task->description }}
                </p>
                @if ($task->labels->isNotEmpty())
                    <p><span class="font-black">@lang('app.pages.labels'):</span></p>

                    <div>
                        @foreach ($task->labels as $label)
                            <div class="label-wrapper">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z">
                                    </path>
                                </svg>
                                {{ $label->name }}
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </section>
</x-app-layout>
