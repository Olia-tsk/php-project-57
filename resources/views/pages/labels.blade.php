<x-app-layout>
    <section class="bg-white dark:bg-gray-900">
        <div class="grid max-w-screen-xl px-4 pt-20 pb-8 mx-auto lg:gap-8 xl:gap-0 lg:py-16 lg:grid-cols-12 lg:pt-28">
            <div class="grid col-span-full">
                <h1 class="mb-5">@lang('app.pages.labels')</h1>

                @auth
                    <div>
                        <a href="#" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            @lang('app.pages.createLabel')
                        </a>
                    </div>
                @endauth

                <table class="mt-4">
                    <thead class="border-b-2 border-solid border-black text-left">
                        <tr>
                            <th>ID</th>
                            <th>@lang('app.pages.name')</th>
                            <th>@lang('app.pages.description')</th>
                            <th>@lang('app.pages.createdDate')</th>
                            @auth
                                <th>@lang('app.pages.actions')</th>
                            @endauth
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="border-b border-dashed text-left">
                            <td>1</td>
                            <td>ошибка</td>
                            <td>Какая-то ошибка в коде или проблема с функциональностью</td>
                            <td>16.06.2025</td>
                            @auth
                                <td>
                                    <a data-confirm="Вы уверены?" data-method="delete"
                                        class="text-red-600 hover:text-red-900" href="#">
                                        @lang('app.pages.delete')
                                    </a>
                                    <a class="text-blue-600 hover:text-blue-900" href="#">
                                        @lang('app.pages.edit')
                                    </a>
                                </td>
                            @endauth
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</x-app-layout>
