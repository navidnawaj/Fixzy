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
                     <p>ServiceName: {{$order->service->ServiceName}}</p>
                     <p>Service Date: <a href="#" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">{{ \Carbon\Carbon::parse($order->booking_datetime)->format('d M Y, H:i') }}</a></p>
                     <p>Status: {{$order->status}}</p>
                </div>
            </div>
        </div>
    </div>

    @if($order->status == 'completed')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if($order->review)
                        <p class="text-gray-900 dark:text-gray-100">Your Review: {{$order->review}}</p>
                    @else
                    <form action="{{ route('feedback.store', $order->id) }}" method="POST">
                        @csrf
                        <div class="w-full border border-gray-200 rounded-lg bg-gray-50 dark:bg-gray-700 dark:border-gray-600">
                            <div class="px-4 py-2 bg-white rounded-t-lg dark:bg-gray-800">
                                <label for="comment" class="sr-only">Your Review</label>
                                <textarea name="review" id="comment" rows="4" class="w-full px-0 text-sm text-gray-900 bg-white border-0 dark:bg-gray-800 focus:ring-0 dark:text-white dark:placeholder-gray-400" placeholder="Write a comment..." required ></textarea>
                            </div>
                            <div class="flex items-center justify-between px-3 py-2 border-t dark:border-gray-600 border-gray-200">
                                <button type="submit" class="inline-flex items-center py-2.5 px-4 text-xs font-medium text-center text-white bg-blue-700 rounded-lg focus:ring-4 focus:ring-blue-200 dark:focus:ring-blue-900 hover:bg-blue-800">
                                    Post Review
                                </button>
                            </div>
                        </div>
                    </form>
                    @endif

                    @session('success')
                        <div class="mt-4 p-4 text-sm text-green-700 bg-green-100 rounded-lg" role="alert">
                            {{ session('success') }}
                        </div>
                    @endsession
                </div>
            </div>
        </div>
    </div>
    @endif
</x-app-layout>
