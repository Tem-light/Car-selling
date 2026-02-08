<x-app-layout>
    <div class="py-12 bg-gray-50">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
                <div class="bg-gradient-to-r from-primary to-secondary px-8 py-6">
                    <h1 class="text-3xl font-bold text-white">{{ isset($car) ? 'Edit Car Details' : 'Sell Your Car' }}</h1>
                    <p class="text-indigo-100 mt-2">{{ isset($car) ? 'Update the details below.' : 'Fill in the details below to list your car for sale.' }}</p>
                </div>

                @if ($errors->any())
                    <div class="bg-red-50 border-l-4 border-red-500 p-4 m-8 mb-0">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm leading-5 font-medium text-red-800">There were errors with your submission</h3>
                                <ul class="mt-1 text-sm text-red-700 list-disc list-inside">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif

                <form action="{{ isset($car) ? route('cars.update', $car) : route('cars.store') }}" method="POST" enctype="multipart/form-data" class="p-8 space-y-8">
                    @csrf
                    @if(isset($car))
                        @method('PUT')
                    @endif

                    <!-- Section 1: Car Details -->
                    <div>
                        <h2 class="text-xl font-semibold text-gray-800 border-b pb-2 mb-6">Car Details</h2>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Maker</label>
                                <select name="maker_id" id="maker" required class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm p-2.5 bg-gray-50 border">
                                    <option value="">Select Maker</option>
                                    @foreach($makers as $maker)
                                        <option value="{{ $maker->id }}" {{ old('maker_id', $car->maker_id ?? '') == $maker->id ? 'selected' : '' }}>{{ $maker->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Model</label>
                                <select name="car_model_id" id="model" required class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm p-2.5 bg-gray-50 border">
                                    <option value="">Select Model</option>
                                    @if(isset($models) || old('car_model_id'))
                                        {{-- If models passed (Edit mode) or checking old input --}}
                                        @foreach($models ?? \App\Models\CarModel::where('maker_id', old('maker_id'))->get() as $model)
                                            <option value="{{ $model->id }}" {{ old('car_model_id', $car->car_model_id ?? '') == $model->id ? 'selected' : '' }}>{{ $model->name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Year</label>
                                <select name="year" required class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm p-2.5 bg-gray-50 border">
                                    <option value="">Select Year</option>
                                    @for($y = date('Y') + 1; $y >= 1990; $y--)
                                        <option value="{{ $y }}" {{ old('year', $car->year ?? '') == $y ? 'selected' : '' }}>{{ $y }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>

                        <div class="mt-6">
                            <label class="block text-sm font-medium text-gray-700 mb-3">Car Type</label>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                @foreach($carTypes as $type)
                                    <label class="relative flex cursor-pointer rounded-lg border bg-white p-4 shadow-sm focus:outline-none hover:border-indigo-500 peer-checked:border-indigo-500 peer-checked:ring-2 peer-checked:ring-indigo-500">
                                        <input type="radio" name="car_type_id" value="{{ $type->id }}" class="sr-only peer" required {{ old('car_type_id', $car->car_type_id ?? '') == $type->id ? 'checked' : '' }}>
                                        <span class="flex flex-1">
                                            <span class="flex flex-col">
                                                <span class="block text-sm font-medium text-gray-900 peer-checked:text-indigo-600">{{ $type->name }}</span>
                                            </span>
                                        </span>
                                        <svg class="h-5 w-5 text-indigo-600 hidden peer-checked:block" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                        </svg>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Section 2: Specs & Price -->
                    <div>
                        <h2 class="text-xl font-semibold text-gray-800 border-b pb-2 mb-6">Specs & Price</h2>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Price ($)</label>
                                <input type="number" name="price" value="{{ old('price', $car->price ?? '') }}" placeholder="0.00" required step="0.01" min="0" class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm p-2.5 bg-gray-50 border" />
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">VIN Code</label>
                                <input type="text" name="vin" value="{{ old('vin', $car->vin ?? '') }}" placeholder="17-character VIN" required maxlength="17" class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm p-2.5 bg-gray-50 border uppercase" />
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Mileage (miles)</label>
                                <input type="number" name="mileage" value="{{ old('mileage', $car->mileage ?? '') }}" placeholder="0" required min="0" class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm p-2.5 bg-gray-50 border" />
                            </div>
                        </div>

                        <div class="mt-6">
                            <label class="block text-sm font-medium text-gray-700 mb-3">Fuel Type</label>
                            <div class="flex flex-wrap gap-4">
                                @foreach($fuelTypes as $fuel)
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="fuel_type_id" value="{{ $fuel->id }}" class="form-radio text-indigo-600 focus:ring-indigo-500 h-5 w-5" required {{ old('fuel_type_id', $car->fuel_type_id ?? '') == $fuel->id ? 'checked' : '' }}>
                                        <span class="ml-2 text-gray-700">{{ $fuel->name }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Section 3: Location -->
                    <div>
                        <h2 class="text-xl font-semibold text-gray-800 border-b pb-2 mb-6">Location</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">State/Region</label>
                                <select name="state_id" id="State" required class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm p-2.5 bg-gray-50 border">
                                    <option value="">Select State</option>
                                    @foreach($states as $state)
                                        <option value="{{ $state->id }}" {{ old('state_id', (isset($car) && $car->city ? $car->city->state_id : '')) == $state->id ? 'selected' : '' }}>{{ $state->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">City</label>
                                <select name="city_id" id="city" required class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm p-2.5 bg-gray-50 border disabled:bg-gray-100 disabled:text-gray-400">
                                    <option value="">Select City</option>
                                     @if(isset($car) || old('city_id'))
                                         {{-- Helper to load cities if editing --}}
                                        @php
                                            $selectedStateId = old('state_id', (isset($car) && $car->city ? $car->city->state_id : null));
                                            $cities = $selectedStateId ? \App\Models\City::where('state_id', $selectedStateId)->get() : [];
                                        @endphp
                                        @foreach($cities as $city)
                                            <option value="{{ $city->id }}" {{ old('city_id', $car->city_id ?? '') == $city->id ? 'selected' : '' }}>{{ $city->name }}</option>
                                        @endforeach
                                     @endif
                                </select>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Detailed Address</label>
                                <input type="text" name="address" value="{{ old('address', $car->address ?? '') }}" placeholder="Street address" required class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm p-2.5 bg-gray-50 border" />
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Contact Phone</label>
                                <input type="text" name="phone" value="{{ old('phone', $car->phone ?? '') }}" placeholder="+1 (555) 000-0000" required class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm p-2.5 bg-gray-50 border" />
                            </div>
                        </div>
                    </div>

                    <!-- Section 4: Description & Photos -->
                    <div>
                        <h2 class="text-xl font-semibold text-gray-800 border-b pb-2 mb-6">Details & Media</h2>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                            <textarea name="description" rows="5" required class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm p-3 bg-gray-50 border" placeholder="Describe the condition, features, and history of the car...">{{ old('description', $car->description ?? '') }}</textarea>
                        </div>
                        
                        <div class="mt-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Photos (Add New)</label>
                            <div class="flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg bg-gray-50 hover:bg-white transition-colors cursor-pointer group relative" onclick="document.getElementById('carFormImageUpload').click()">
                                <div class="space-y-1 text-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-400 group-hover:text-indigo-500" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <div class="flex text-sm text-gray-600 justify-center">
                                        <span class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500">
                                            Upload files
                                        </span>
                                        <p class="pl-1">or drag and drop</p>
                                    </div>
                                    <p class="text-xs text-gray-500">PNG, JPG, GIF up to 5MB</p>
                                    <input id="carFormImageUpload" type="file" name="images[]" multiple accept="image/*" class="sr-only" />
                                </div>
                            </div>
                            <div id="imagePreviews" class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-4"></div>
                            
                            @if(isset($car) && $car->images->count() > 0)
                                <div class="mt-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Current Photos</label>
                                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                        @foreach($car->images as $image)
                                            <div class="relative group aspect-w-4 aspect-h-3 rounded-lg overflow-hidden bg-gray-100">
                                                <img src="{{ $image->image_path }}" class="object-cover w-full h-full" />
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>

                        <div class="mt-6 flex items-center">
                            <input id="published" name="published" type="checkbox" value="1" {{ old('published', $car->published_at ?? false) ? 'checked' : '' }} class="h-5 w-5 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                            <label for="published" class="ml-2 block text-sm font-medium text-gray-900">
                                Publish immediately (Visible to everyone)
                            </label>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="pt-5 border-t border-gray-200">
                        <div class="flex justify-end gap-3">
                            <a href="{{ route('cars.index') }}" class="bg-white py-2.5 px-6 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none transition">
                                Cancel
                            </a>
                            <button type="submit" class="bg-primary hover:bg-indigo-700 text-white py-2.5 px-8 rounded-lg shadow-lg shadow-indigo-500/30 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all transform hover:scale-105">
                                {{ isset($car) ? 'Update Car' : 'Submit Listing' }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- JS -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script>
    $(document).ready(function () {
        // Models by Maker
        $('#maker').on('change', function () {
            const makerId = $(this).val();
            const $model = $('#model');
            $model.html('<option value="">Select Model</option>').prop('disabled', true);
            if (!makerId) return;

            $.ajax({
                url: '{{ route("cars.models", "") }}/' + makerId,
                method: 'GET',
                dataType: 'json',
                success: function (models) {
                    if (models && models.length > 0) {
                        $.each(models, function (i, model) {
                            $model.append($('<option>', { value: model.id, text: model.name }));
                        });
                        $model.prop('disabled', false);
                    } else {
                        $model.append('<option value="">No models available</option>');
                    }
                },
                error: function () {
                    // alert('Could not load models');
                }
            });
        });

        // Cities by State
        $('#State').on('change', function () {
            const stateId = $(this).val();
            const $city = $('#city');
            $city.html('<option value="">Select City</option>').prop('disabled', true);
            if (!stateId) return;

            $.ajax({
                url: '{{ route("cars.cities", "") }}/' + stateId,
                method: 'GET',
                dataType: 'json',
                success: function (cities) {
                    if (cities && cities.length > 0) {
                        $.each(cities, function (i, city) {
                            $city.append($('<option>', { value: city.id, text: city.name }));
                        });
                        $city.prop('disabled', false);
                    } else {
                        $city.append('<option value="">No cities available</option>');
                    }
                },
                error: function () {
                    // alert('Could not load cities');
                }
            });
        });

        // Image Preview
        $('#carFormImageUpload').on('change', function(e) {
            $('#imagePreviews').empty();
            const files = e.target.files;
            for (let i = 0; i < files.length; i++) {
                const file = files[i];
                if (!file.type.match('image.*')) continue;
                const reader = new FileReader();
                reader.onload = function(e) {
                    $('#imagePreviews').append(
                        '<div class="relative group aspect-w-4 aspect-h-3 rounded-lg overflow-hidden bg-gray-100">' +
                        '<img src="' + e.target.result + '" class="object-cover w-full h-full" />' +
                        '</div>'
                    );
                };
                reader.readAsDataURL(file);
            }
        });
    });
    </script>
</x-app-layout>
