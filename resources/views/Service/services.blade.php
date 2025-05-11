<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('All Service') }}
        </h2>
    </x-slot>


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-4">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="grid grid-cols-1 p-6 text-gray-900 dark:text-gray-100">
                    <form method="GET" action="{{ route('service.services') }}" class="mb-6">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">

                            <!-- Search Input -->
                            <div>
                                <input type="text" name="search" placeholder="Search services..."
                                    value="{{ request('search') }}"
                                    class="w-full p-2 border rounded-lg dark:bg-gray-700 dark:text-white">
                            </div>

                            <!-- Min Price -->
                            <div>
                                <input type="number" step="0.01" name="min_price" placeholder="Min Price"
                                    value="{{ request('min_price') }}"
                                    class="w-full p-2 border rounded-lg dark:bg-gray-700 dark:text-white">
                            </div>

                            <!-- Max Price -->
                            <div>
                                <input type="number" step="0.01" name="max_price" placeholder="Max Price"
                                    value="{{ request('max_price') }}"
                                    class="w-full p-2 border rounded-lg dark:bg-gray-700 dark:text-white">
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <button type="submit"
                                    class="w-full p-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                                    Search
                                </button>
                            </div>

                            <a href="{{ route('service.services') }}"
                                class="w-full p-2 text-center border rounded-lg text-gray-700 dark:text-white dark:border-gray-600">
                                Reset
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="grid grid-cols-3 gap-4 p-6 text-gray-900 dark:text-gray-100">

                    @if ($services->isEmpty())
                        <p class="text-center text-gray-500 dark:text-gray-400">No services found matching your search.
                        </p>
                    @endif

                    @foreach ($services as $service)
                        <div
                            class="max-w-sm bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700">
                            <a href="#">
                                <img class="object-cover w-full rounded-t-lg h-70" src="{{ asset('storage/' . $service->image) }}" alt="" />
                            </a>
                            <div class="p-5">
                                <a href="#">
                                    <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                                        {{ $service->ServiceName }}</h5>
                                </a>
                                <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">{{ $service->ServiceDescription }}
                                </p>
                                <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">{{ $service->ServicePrice }}
                                </p>
                                <a href="{{ route('service.view', ['service' => $service]) }}"
                                    class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                    Order Now
                                    <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
