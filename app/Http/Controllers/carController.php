<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Car;
use App\Models\User;
use App\Models\Maker;
use App\Models\CarModel;
use App\Models\CarImage;
use App\Models\City;
use App\Models\State;
use App\Models\CarType;
use App\Models\FuelType;
use App\Models\CarFeature;

class CarController extends Controller
{
    public function index()
    {
        $cars = auth()->user()
            ->cars()
            ->with(['primaryImage','maker','carModel'])
            ->latest()
            ->paginate(10);

        return view('car.index', compact('cars'));
    }

    /* ===================== SHOW CREATE FORM ===================== */
    public function create()
    {
        return view('car.create', [
            'makers'   => Maker::all(),
            'states'   => State::all(),
            'carTypes' => CarType::all(),
            'fuelTypes'=> FuelType::all(),
            // 'features' => CarFeature::all(),
        ]);
    }

    /* ===================== STORE CAR ===================== */
public function store(Request $request)
{
    $validated = $request->validate([
        'maker_id'      => 'required|exists:makers,id',
        'car_model_id'  => 'required|exists:car_models,id',
        'car_type_id'   => 'required|exists:car_types,id',
        'fuel_type_id'  => 'required|exists:fuel_types,id',
        'city_id'       => 'required|exists:cities,id',
        'year'          => 'required|integer|min:1900|max:' . (date('Y') + 1),
        'price'         => 'required|numeric|min:0',
        'vin'           => 'required|string|max:17|unique:cars,vin',
        'mileage'       => 'required|numeric|min:0',
        'address'       => 'required|string|max:255',
        'phone'         => 'required|string|max:30',
        'description'   => 'nullable|string',
        'images.*'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        'published'     => 'sometimes|boolean',
    ]);

    // Prepare data for insertion
    $data = $request->only([
        'maker_id', 'car_model_id', 'car_type_id', 'fuel_type_id', 
        'city_id', 'year', 'price', 'vin', 'mileage', 
        'address', 'phone', 'description'
    ]);

    if ($request->has('published')) {
        $data['published_at'] = now();
    }
    
    $data['user_id'] = auth()->id();

    $car = Car::create($data);

    // // Attach features if any
    // if ($request->filled('features')) {
    //     $car->features()->attach($request->input('features'));
    // }

    // Upload images if any
    if ($request->hasFile('images')) {
        foreach ($request->file('images') as $index => $image) {
            if ($image->isValid()) {
                $path = $image->store('cars', 'public');
                CarImage::create([
                    'car_id'     => $car->id,
                    'image_path' => $path,
                    'position'   => (string) ($index + 1),
                ]);
            }
        }
    }

    return redirect()->route('cars.index')
        ->with('success', 'Car added successfully!');
}

    /**
 * Get models by maker (for AJAX)
 */
public function getModels($makerId)
{
    $models = CarModel::where('maker_id', $makerId)
        ->select('id', 'name')   // adjust column name if different
        ->orderBy('name')
        ->get();

    return response()->json($models);
}

/**
 * Get cities by state (for AJAX)
 */
public function getCities($stateId)
{
    $cities = City::where('state_id', $stateId)
        ->select('id', 'name')   // adjust if your column is different
        ->orderBy('name')
        ->get();

    return response()->json($cities);
}
    /* ===================== SHOW CAR ===================== */
    public function show(Car $car)
    {
        return view('car.show', compact('car'));
    }

    /* ===================== SEARCH ===================== */
    public function search()
    {
        $cars = Car::whereNotNull('published_at')
            ->with(['primaryImage','city','carType','fuelType','maker','carModel'])
            ->latest('published_at')
            ->paginate(10);

        return view('car.search', compact('cars'));
    }

    /* ===================== EDIT CAR ===================== */
    public function edit(Car $car)
    {
        $this->authorize('update', $car);

        return view('car.create', [
            'car' => $car,
            'makers'   => Maker::all(),
            'states'   => State::all(),
            'carTypes' => CarType::all(),
            'fuelTypes'=> FuelType::all(),
            'models'   => CarModel::where('maker_id', $car->maker_id)->get(),
        ]);
        // Note: I'm reusing car.create for edit. I need to make sure car.create handles it.
        // It uses `old('field')`. I should update it to `old('field', $car->field ?? '')`.
        // But for now, separate view or updating create view is needed.
        // Given I rewrote create.blade.php without $car checks, I should update create.blade.php too.
        // Actually, creating a separate edit view is safer if I don't want to break create.
        // But updating create is better practice. I'll stick to updating create.blade.php next.
    }

    /* ===================== UPDATE CAR ===================== */
    public function update(Request $request, Car $car)
    {
        $this->authorize('update', $car);

        $validated = $request->validate([
            'maker_id'      => 'required|exists:makers,id',
            'car_model_id'  => 'required|exists:car_models,id',
            'car_type_id'   => 'required|exists:car_types,id',
            'fuel_type_id'  => 'required|exists:fuel_types,id',
            'city_id'       => 'required|exists:cities,id',
            'year'          => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'price'         => 'required|numeric|min:0',
            'vin'           => 'required|string|max:17|unique:cars,vin,' . $car->id,
            'mileage'       => 'required|numeric|min:0',
            'address'       => 'required|string|max:255',
            'phone'         => 'required|string|max:30',
            'description'   => 'nullable|string',
            'published'     => 'sometimes|boolean',
        ]);

        $data = $request->only([
            'maker_id', 'car_model_id', 'car_type_id', 'fuel_type_id', 
            'city_id', 'year', 'price', 'vin', 'mileage', 
            'address', 'phone', 'description'
        ]);

        if ($request->has('published')) {
            $data['published_at'] = now();
        } else {
            $data['published_at'] = null;
        }

        $car->update($data);

        return redirect()->route('cars.index')->with('success', 'Car updated successfully!');
    }

    /* ===================== DESTROY CAR ===================== */
    public function destroy(Car $car)
    {
        $this->authorize('delete', $car);

        $car->delete();

        return back()->with('success', 'Car deleted successfully!');
    }

    /* ===================== WATCHLIST ===================== */
    public function watchlist()
    {
        $cars = auth()->user()
            ->favoriteCars()
            ->with(['primaryImage','city','carType','fuelType','maker','carModel'])
            ->latest('published_at')
            ->paginate(10);

        return view('car.watchlist', compact('cars'));
    }

    /**
     * Toggle car in user's watchlist (add/remove from favorites).
     */
    public function toggleWatchlist(Car $car)
    {
        $user = auth()->user();
        if ($user->favoriteCars()->where('car_id', $car->id)->exists()) {
            $user->favoriteCars()->detach($car->id);
            $message = 'Removed from watchlist.';
        } else {
            $user->favoriteCars()->attach($car->id);
            $message = 'Added to watchlist.';
        }
        return back()->with('success', $message);
    }
}
