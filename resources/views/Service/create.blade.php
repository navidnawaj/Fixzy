<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Add Service') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form action="{{ route('service.store') }}" method="post">
                        @csrf
                        @method('POST')
                        <div class="mb-4">
                            <label for="ServiceName" class="block text-gray-700 text-sm font-bold mb-2">Service Name:</label>
                            <input type="text" name="ServiceName" id="name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                        </div>

                        <div class="mb-4">
                            <label for="ServiceDescription" class="block text-gray-700 text-sm font-bold mb-2">Description:</label>
                            <textarea name="ServiceDescription" id="description" rows="4" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required></textarea>
                        </div>

                        <div class="mb-4">
                            <label for="ServicePrice" class="block text-gray-700 text-sm font-bold mb-2">Price:</label>
                            <input type="number" name="ServicePrice" id="price" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                        </div>

                        <div class="mb-4">
                            <label for="ServiceCategory" class="block text-gray-700 text-sm font-bold mb-2">Category:</label>
                            <input type="text" name="ServiceCategory" id="ServiceCategory" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                        </div>

                        {{-- <div class="mb-4">
                            <label for="image" class="block text-gray-700 text-sm font-bold mb-2">Image:</label>
                            <input type="file" name="image" id="image" accept=".jpg, .jpeg, .png, .gif" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        </div> --}}

                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Add Service</button>
                    </form>

                    @if (session('success'))
                        <div class="mt-4 text-green-500">
                            {{ session('success') }}
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>