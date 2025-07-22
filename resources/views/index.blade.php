<x-app-layout>
    <section class="bg-white">
        <div class="max-w-screen-xl px-4 pt-20 pb-8 mx-auto lg:py-16 lg:pt-28">

            <h1 class="max-w-2xl mb-4 text-4xl font-extrabold leading-none tracking-tight md:text-5xl xl:text-6xl">
                @lang('app.intro')
            </h1>
            <p class="max-w-2xl mb-6 font-light text-gray-500 lg:mb-8 md:text-lg lg:text-xl">
                @lang('app.description')
            </p>

            <a href="https://hexlet.io"
                class="bg-white hover:bg-gray-100 text-gray-800 font-semibold py-2 px-4 border border-gray-400 rounded shadow"
                target="_blank">
                @lang('app.mainButton')
            </a>

        </div>
    </section>
</x-app-layout>
