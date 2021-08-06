<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Home') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                <div class="text-3xl">
                    Filter your data.
                </div>
                <div class="text-xl">
                    Explore these tools to engage in meaningful discussion about issues faced in your community.
                </div>
            </div>

            <div class="bg-gray-200 bg-opacity-25 grid grid-cols-1 md:grid-cols-2">
                <div class="p-6 border-t border-gray-200">
                    <div class="flex items-center">
                        <div class="ml-4 text-lg text-gray-600 leading-7 font-semibold"><a href="/browse">Browse</a></div>
                    </div>

                    <div class="ml-12">
                        <div class="mt-2 text-sm text-gray-500">
                        View Reports of every other user on an interactive map. See what issues matter to others.
                        </div>
                    </div>
                </div>

                <div class="p-6 border-t border-gray-200 md:border-l">
                    <div class="flex items-center">
                        <div class="ml-4 text-lg text-gray-600 leading-7 font-semibold"><a href="/report">Report</a></div>
                    </div>
                    <div class="ml-12">
                        <div class="mt-2 text-sm text-gray-500">
                        Share issues you believe you have a solution for. If you could protest anywhere in the world, where would it be?
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </div>
    </div>
</x-app-layout>
