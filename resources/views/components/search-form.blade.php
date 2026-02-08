@props(['makers', 'states', 'carTypes', 'fuelTypes'])

<section class="relative z-10 -mt-24 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
    <div class="bg-white/80 backdrop-blur-lg rounded-2xl shadow-2xl p-6 md:p-10 border border-white/20">
        <h2 class="text-2xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-primary to-secondary mb-6 text-center md:text-left">
            Find Your Next Car
        </h2>
        <form action="{{ route('cars.search') }}" method="GET">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Maker -->
                <div class="space-y-1">
                    <label class="text-sm font-medium text-gray-700 ml-1">Example: Toyota</label>
                    <select id="searchMaker" name="maker_id" class="w-full rounded-xl border-gray-200 focus:border-primary focus:ring-primary shadow-sm p-3 bg-white/50 transition-all hover:bg-white">
                        <option value="">All Makers</option>
                        @foreach($makers as $maker)
                            <option value="{{ $maker->id }}">{{ $maker->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Model -->
                <div class="space-y-1">
                    <label class="text-sm font-medium text-gray-700 ml-1">Example: Camry</label>
                    <select id="searchModel" name="car_model_id" disabled class="w-full rounded-xl border-gray-200 focus:border-primary focus:ring-primary shadow-sm p-3 bg-gray-100/50 transition-all disabled:opacity-50">
                        <option value="">All Models</option>
                    </select>
                </div>

                <!-- State -->
                <div class="space-y-1">
                    <label class="text-sm font-medium text-gray-700 ml-1">State</label>
                    <select id="searchState" name="state_id" class="w-full rounded-xl border-gray-200 focus:border-primary focus:ring-primary shadow-sm p-3 bg-white/50 transition-all hover:bg-white">
                        <option value="">All Locations</option>
                        @foreach($states as $state)
                            <option value="{{ $state->id }}">{{ $state->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- City -->
                <div class="space-y-1">
                    <label class="text-sm font-medium text-gray-700 ml-1">City</label>
                    <select id="searchCity" name="city_id" disabled class="w-full rounded-xl border-gray-200 focus:border-primary focus:ring-primary shadow-sm p-3 bg-gray-100/50 transition-all disabled:opacity-50">
                        <option value="">All Cities</option>
                    </select>
                </div>

                <!-- Car Type -->
                <div class="space-y-1">
                    <label class="text-sm font-medium text-gray-700 ml-1">Body Type</label>
                    <select name="car_type_id" class="w-full rounded-xl border-gray-200 focus:border-primary focus:ring-primary shadow-sm p-3 bg-white/50 transition-all hover:bg-white">
                        <option value="">All Types</option>
                        @foreach($carTypes as $type)
                            <option value="{{ $type->id }}">{{ $type->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Price Range -->
                <div class="space-y-1">
                    <label class="text-sm font-medium text-gray-700 ml-1">Price Range</label>
                    <div class="flex space-x-2">
                        <input type="number" name="price_from" placeholder="Min" class="w-1/2 rounded-xl border-gray-200 focus:border-primary focus:ring-primary shadow-sm p-3 bg-white/50">
                        <input type="number" name="price_to" placeholder="Max" class="w-1/2 rounded-xl border-gray-200 focus:border-primary focus:ring-primary shadow-sm p-3 bg-white/50">
                    </div>
                </div>

                <!-- Year Range -->
                <div class="space-y-1">
                    <label class="text-sm font-medium text-gray-700 ml-1">Year Range</label>
                    <div class="flex space-x-2">
                         <input type="number" name="year_from" placeholder="From" class="w-1/2 rounded-xl border-gray-200 focus:border-primary focus:ring-primary shadow-sm p-3 bg-white/50">
                         <input type="number" name="year_to" placeholder="To" class="w-1/2 rounded-xl border-gray-200 focus:border-primary focus:ring-primary shadow-sm p-3 bg-white/50">
                    </div>
                </div>

                <!-- Submit -->
                <div class="space-y-1">
                    <label class="block text-sm font-medium text-transparent ml-1">Search</label>
                    <button type="submit" class="w-full bg-gradient-to-r from-primary to-secondary hover:from-indigo-600 hover:to-emerald-600 text-white font-bold py-3 px-4 rounded-xl shadow-lg shadow-indigo-500/30 transition-all transform hover:scale-105 flex justify-center items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        Search Cars
                    </button>
                </div>
            </div>
        </form>
    </div>
</section>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
$(document).ready(function () {
    // Models
    $('#searchMaker').on('change', function () {
        const makerId = $(this).val();
        const $model = $('#searchModel');
        $model.html('<option value="">All Models</option>').prop('disabled', true);
        if (makerId) {
            $.get('/cars/models/' + makerId, function (models) {
                $.each(models, function (i, model) {
                    $model.append($('<option>', { value: model.id, text: model.name }));
                });
                $model.prop('disabled', false);
            });
        }
    });

    // Cities
    $('#searchState').on('change', function () {
        const stateId = $(this).val();
        const $city = $('#searchCity');
        $city.html('<option value="">All Cities</option>').prop('disabled', true);
        if (stateId) {
            $.get('/cars/cities/' + stateId, function (cities) {
                $.each(cities, function (i, city) {
                    $city.append($('<option>', { value: city.id, text: city.name }));
                });
                $city.prop('disabled', false);
            });
        }
    });
});
</script>