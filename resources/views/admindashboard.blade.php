<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                        <div class="border-gray-200 dark:border-gray-600">
                            <div class=" p-4 bg-white rounded-lg md:p-8 dark:bg-gray-800" id="stats" >
                                <dl class="text-center grid max-w-screen-xl grid-cols-2 gap-8 p-4 mx-auto text-gray-900 sm:grid-cols-3 xl:grid-cols-5 dark:text-white sm:p-8">
                                    <div class="flex flex-col items-center justify-center">
                                        <dt class="mb-2 text-3xl font-extrabold">{{$totalRevenue}}</dt>
                                        <dd class="text-gray-500 dark:text-gray-400">Total Revenue</dd>
                                    </div>
                                    <div class="flex flex-col items-center justify-center">
                                        <dt class="mb-2 text-3xl font-extrabold">{{$totalOrders}}</dt>
                                        <dd class="text-gray-500 dark:text-gray-400">Total Orders</dd>
                                    </div>
                                    <div class="flex flex-col items-center justify-center">
                                        <dt class="mb-2 text-3xl font-extrabold">{{$totalServices}}</dt>
                                        <dd class="text-gray-500 dark:text-gray-400">Total Active Services</dd>
                                    </div>
                                    <div class="flex flex-col items-center justify-center">
                                        <dt class="mb-2 text-3xl font-extrabold">{{$totalCustomers}}</dt>
                                        <dd class="text-gray-500 dark:text-gray-400">Total Customer</dd>
                                    </div>
                                    <div class="flex flex-col items-center justify-center">
                                        <dt class="mb-2 text-3xl font-extrabold">{{$totalSellers}}</dt>
                                        <dd class="text-gray-500 dark:text-gray-400">Total Sellers</dd>
                                    </div>
                                </dl>
                            </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
