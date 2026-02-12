<x-app-layout>
    <main>
        <!-- My Favourite Cars -->
        <section>
            <div class="container">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-2xl font-bold">My Favourite Cars</h2>

                    @if($cars->total() > 0)
                        <div class="pagination-summary ml-4">
                            <p>Showing {{ $cars->firstItem() }} to {{ $cars->lastItem() }} of {{ $cars->total() }} cars</p>
                        </div>
                    @endif
                </div>

                <div class="car-items-listing grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($cars as $car)
                        <x-car-item :car="$car" :isWatchList="true" />
                    @endforeach
                </div>

                <div class="mt-6">
                    {{ $cars->onEachSide(1)->links('pagination') }}
                </div>
            </div>
        </section>
    </main>
</x-app-layout>
