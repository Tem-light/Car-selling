<x-app-layout>
    <main>
        <div class="container-small">
            <h1 class="car-details-page-title">
                Edit Car: {{ $car->maker->name ?? 'Maker' }} {{ $car->model->name ?? 'Model' }} - {{ $car->year ?? 'Year' }}
            </h1>

        <form action="{{ route('cars.update', $car->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-content">
                    <!-- Car Details -->
                    <div class="form-details">
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label>Maker</label>
                                    <select name="maker_id" required>
                                        <option value="">Select Maker</option>
                                        @foreach($makers as $maker)
                                            <option value="{{ $maker->id }}" {{ $car->maker_id == $maker->id ? 'selected' : '' }}>{{ $maker->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col">
                                <div class="form-group">
                                    <label>Model</label>
                                  <select name="model_id" required>
    <option value="">Select Model</option>
    @foreach($models as $model)
        <option value="{{ $model->id }}" {{ old('model_id', $car->car_model_id) == $model->id ? 'selected' : '' }}>
            {{ $model->name }}
        </option>
    @endforeach
</select>

                                </div>
                            </div>

                            <div class="col">
                                <div class="form-group">
                                    <label>Year</label>
                                    <select name="year" required>
                                        <option value="">Select Year</option>
                                        @for($i = date('Y'); $i >= 1990; $i--)
                                            <option value="{{ $i }}" {{ $car->year == $i ? 'selected' : '' }}>{{ $i }}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Car Type -->
                        <div class="form-group">
                            <label>Car Type</label>
                            <div class="row">
                              @foreach(['sedan' => 'Sedan', 'hatchback' => 'Hatchback', 'suv' => 'SUV'] as $key => $value)
    <label>
        <input type="radio" name="car_type" value="{{ $key }}" {{ old('car_type', $car->car_type) == $key ? 'checked' : '' }}>
        {{ $value }}
    </label>
@endforeach

                            </div>
                        </div>

                        <!-- Price, VIN, Mileage -->
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label>Price</label>
                                    <input type="number" name="price" placeholder="Price" value="{{ $car->price }}">
                                </div>
                            </div>

                            <div class="col">
                                <div class="form-group">
                                    <label>Vin Code</label>
                                    <input type="text" name="vin_code" placeholder="Vin Code" value="{{ $car->vin_code }}">
                                </div>
                            </div>

                            <div class="col">
                                <div class="form-group">
                                    <label>Mileage (ml)</label>
                                    <input type="number" name="mileage" placeholder="Mileage" value="{{ $car->mileage }}">
                                </div>
                            </div>
                        </div>

                        <!-- Fuel Type -->
                        <div class="form-group">
                            <label>Fuel Type</label>
                            <div class="row">
                              @foreach(['gasoline','diesel','electric','hybrid'] as $fuel)
                                  <label>
                                      <input type="radio" name="fuel_type" value="{{ $fuel }}" {{ old('fuel_type', $car->fuel_type) == $fuel ? 'checked' : '' }}>
                                      {{ ucfirst($fuel) }}
                                  </label>
                              @endforeach

                            </div>
                        </div>

                        <!-- Location -->
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label>State/Region</label>
                                    <select name="state_id">
                                        <option value="">Select State</option>
                                        @foreach($states as $state)
                                            <option value="{{ $state->id }}" {{ $car->state_id == $state->id ? 'selected' : '' }}>{{ $state->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col">
                                <div class="form-group">
                                    <label>City</label>
                                    <select name="city_id">
                                        <option value="">Select City</option>
                                        @foreach($cities as $city)
                                            <option value="{{ $city->id }}" {{ $car->city_id == $city->id ? 'selected' : '' }}>{{ $city->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Address & Phone -->
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label>Address</label>
                                    <input type="text" name="address" placeholder="Address" value="{{ $car->address }}">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label>Phone</label>
                                    <input type="text" name="phone" placeholder="Phone" value="{{ $car->phone }}">
                                </div>
                            </div>
                        </div>

                        <!-- Features -->
                        <div class="form-group">
                            <label>Features</label>
                            <div class="row">
                                @foreach([
                                    'air_conditioning'=>'Air Conditioning',
                                    'power_windows'=>'Power Windows',
                                    'power_door_locks'=>'Power Door Locks',
                                    'abs'=>'ABS',
                                    'cruise_control'=>'Cruise Control',
                                    'bluetooth_connectivity'=>'Bluetooth',
                                    'remote_start'=>'Remote Start',
                                    'gps_navigation'=>'GPS Navigation',
                                    'heated_seats'=>'Heated Seats',
                                    'climate_control'=>'Climate Control',
                                    'rear_parking_sensors'=>'Rear Parking Sensors',
                                    'leather_seats'=>'Leather Seats'
                                ] as $key => $label)
                                    <div class="col">
                                        <label class="checkbox">
                                            <input type="checkbox" name="features[]" value="{{ $key }}" {{ in_array($key, $car->features ?? []) ? 'checked' : '' }}>
                                            {{ $label }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="form-group">
                            <label>Detailed Description</label>
                            <textarea name="description" rows="10">{{ $car->description }}</textarea>
                        </div>

                        <!-- Published -->
                        <div class="form-group">
                            <label class="checkbox">
                                <input type="checkbox" name="published" {{ $car->published ? 'checked' : '' }}> Published
                            </label>
                        </div>
                    </div>

                    <!-- Images -->
                    <div class="form-images">
                        <p class="my-large">Manage your images</p>

                        <div class="car-form-images">
                      @foreach($car->images as $image)
                      <div class="car-form-image-preview">
                          <img src="{{ asset('storage/' . $image->image_path) }}" width="150" alt="Car Image">
                          <label>
                              Replace: <input type="file" name="images[{{ $image->id }}]">
                          </label>
                      </div>
                      @endforeach


                        </div>

                        <div class="form-group">
                            <label>Add New Images</label>
                            <input type="file" name="new_images[]" multiple>
                        </div>
                    </div>
                </div>

                <!-- Buttons -->
                <div class="p-medium" style="width: 100%">
                    <div class="flex justify-end gap-1">
                        <button type="reset" class="btn btn-default">Reset</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </main>
</x-app-layout>
