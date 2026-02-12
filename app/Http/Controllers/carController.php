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

class CarController extends Controller
{
    /* ===================== USER CARS ===================== */
    public function index()
    {
        $cars = auth()->user()
            ->cars()
            ->with(['primaryImage','maker','carModel'])
            ->latest()
            ->paginate(10);

        return view('car.index', compact('cars'));
    }

    /* ===================== CREATE ===================== */
    public function create()
    {
        return view('car.create', [
            'makers'   => Maker::all(),
            'states'   => State::all(),
            'carTypes' => CarType::all(),
            'fuelTypes'=> FuelType::all(),
            'models'   => [],   // will load dynamically (AJAX)
            'cities'   => [],   // will load dynamically (AJAX)
        ]);
    }

    /* ===================== STORE ===================== */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'maker_id'      => 'required|exists:makers,id',
            'car_model_id'  => 'required|exists:car_models,id',
            'car_type_id'   => 'required|exists:car_types,id',
            'fuel_type_id'  => 'required|exists:fuel_types,id',
            'state_id'      => 'required|exists:states,id',
            'city_id'       => 'required|exists:cities,id',
            'year'          => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'price'         => 'required|numeric|min:0',
            'vin'           => 'required|string|max:17|unique:cars,vin',
            'mileage'       => 'required|numeric|min:0',
            'address'       => 'required|string|max:255',
            'phone'         => 'required|string|max:30',
            'description'   => 'nullable|string',
            'images'        => 'nullable|array|max:10',
            'images.*'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        $data = $request->only([
            'maker_id', 'car_model_id', 'car_type_id', 'fuel_type_id',
            'city_id', 'year', 'price', 'vin', 'mileage',
            'address', 'phone', 'description'
        ]);

        $data['user_id'] = auth()->id();

        if ($request->has('published')) {
            $data['published_at'] = now();
        }

        $car = Car::create($data);

        /* === IMAGES === */
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $i => $image) {
                $path = $image->store('cars', 'public');

                CarImage::create([
                    'car_id'     => $car->id,
                    'image_path' => $path,
                    'position'   => $i + 1,
                ]);
            }
        }

        return redirect()->route('cars.index')
            ->with('success', 'Car added successfully!');
     }

    /* ===================== AJAX: GET MODELS ===================== */
    public function getModels($makerId)
    {
        return CarModel::where('maker_id', $makerId)
            ->select('id', 'name')
            ->orderBy('name')
            ->get();
    }

    /* ===================== AJAX: GET CITIES ===================== */
    public function getCities($stateId)
    {
        return City::where('state_id', $stateId)
            ->select('id', 'name')
            ->orderBy('name')
            ->get();
    }

    /* ===================== SHOW ===================== */
    public function show(Car $car)
    {
        return view('car.show', compact('car'));
    }

    /* ===================== SEARCH PAGE ===================== */
  public function search(Request $request)
{
    $query = Car::query();

    // Filter by maker
    if ($request->maker_id) {
        $query->where('maker_id', $request->maker_id);
    }

    // Filter by model
    if ($request->car_model_id) {
        $query->where('car_model_id', $request->car_model_id);
    }

    // Filter by car type
    if ($request->car_type_id) {
        $query->where('car_type_id', $request->car_type_id);
    }

    // Year range
    if ($request->year_from) {
        $query->where('year', '>=', $request->year_from);
    }

    if ($request->year_to) {
        $query->where('year', '<=', $request->year_to);
    }

    // Price range
    if ($request->price_from) {
        $query->where('price', '>=', $request->price_from);
    }

    if ($request->price_to) {
        $query->where('price', '<=', $request->price_to);
    }

    // Mileage
    if ($request->mileage) {
        $query->where('mileage', '<=', $request->mileage);
    }

    // State
    if ($request->state_id) {
        $query->where('state_id', $request->state_id);
    }

    // City
    if ($request->city_id) {
        $query->where('city_id', $request->city_id);
    }

    // Fuel type
    if ($request->fuel_type_id) {
        $query->where('fuel_type_id', $request->fuel_type_id);
    }

    // Sorting
    if ($request->sort === 'price') {
        $query->orderBy('price', 'asc');
    } elseif ($request->sort === '-price') {
        $query->orderBy('price', 'desc');
    } else {
        $query->latest();
    }

    $cars = $query->paginate(12)->appends($request->query());

    return view('car.search', compact('cars'));
}


    /* ===================== EDIT ===================== */
    public function edit(Car $car)
    {
        $this->authorize('update', $car);

        return view('car.create', [
            'car'       => $car,
            'makers'    => Maker::all(),
            'states'    => State::all(),
            'carTypes'  => CarType::all(),
            'fuelTypes' => FuelType::all(),
            'models'    => CarModel::where('maker_id', $car->maker_id)->get(),
            'cities'    => City::where('state_id', $car->city->state_id)->get(),
        ]);
    }

    /* ===================== UPDATE ===================== */
public function update(Request $request, Car $car)
{
    $this->authorize('update', $car);

    // Validate fields FROM YOUR FORM
   $request->validate([
    'maker_id'     => 'required|exists:makers,id',
    'car_model_id' => 'required|exists:car_models,id', // accept old Blade name
    'car_type_id'  => 'required',                      // accept old Blade name
    'fuel_type_id' => 'required',
    'state_id'     => 'required|exists:states,id',
    'city_id'      => 'required|exists:cities,id',
    'year'         => 'required|integer|min:1900|max:' . (date('Y') + 1),
    'price'        => 'required|numeric|min:0',
    'vin_code'     => 'sometimes|string|max:17|unique:cars,vin_code,' . $car->id,
    'mileage'      => 'required|numeric|min:0',
    'address'      => 'required|string|max:255',
    'phone'        => 'required|string|max:30',
    'description'  => 'nullable|string',
    'images.*'     => 'nullable|image|mimes:jpeg,png,jpg,gif|max:4096',
    'new_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:4096',
]);


    // Update fields in DB
    $car->update([
        'maker_id'     => $request->maker_id,
        'car_model_id' => $request->input('car_model_id'),
        'car_type'     => $request->input('car_type_id'),
        'fuel_type'    => $request->input('fuel_type'),
        'city_id'      => $request->city_id,
        'state_id'     => $request->state_id,
        'year'         => $request->year,
        'price'        => $request->price,
        'vin_code'     => $request->vin_code,
        'mileage'      => $request->mileage,
        'address'      => $request->address,
        'phone'        => $request->phone,
        'description'  => $request->description,
        'features'     => $request->features ?? [],
        'published'    => $request->has('published'),
        'published_at' => $request->has('published') ? now() : null,
    ]);

  // -------------------
// Update existing images
// -------------------
if ($request->hasFile('images')) {
    foreach ($request->file('images') as $id => $file) {
        $carImage = $car->images()->find($id);
        if ($carImage && $file->isValid()) {

            // Delete old file if exists
            if (Storage::disk('public')->exists($carImage->image_path)) {
                Storage::disk('public')->delete($carImage->image_path);
            }

            // Store new file
            $path = $file->store('cars', 'public'); // storage/app/public/cars

            // Update database
            $carImage->update(['image_path' => $path]);
        }
    }
}

if ($request->hasFile('new_images')) {
    foreach ($request->file('new_images') as $file) {
        if ($file->isValid()) {
            $path = $file->store('cars', 'public');
            $car->images()->create(['image_path' => $path]);
        }
    }
}

    return redirect()->route('cars.index')->with('success', 'Car updated successfully!');
}



    /* ===================== DELETE ===================== */
    public function destroy(Car $car)
    {
        $this->authorize('delete', $car);

        $car->delete();

        return back()->with('success', 'Car deleted successfully!');
    }

    /* ===================== WATCHLIST ===================== */
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

/* ===================== WATCHLIST TOGGLE ===================== */
// public function watchlist()
// {
//     $cars = auth()->user()
//         ->favoriteCars()
//         ->with(['primaryImage','city','carType','fuelType','maker','carModel'])
//         ->latest('published_at')
//         ->paginate(10);

//     return view('car.watchlist', compact('cars'));
// }

// public function toggleWatchlist(Car $car)
// {
//     $user = auth()->user();

//     if ($user->favoriteCars()->where('car_id', $car->id)->exists()) {
//         $user->favoriteCars()->detach($car->id);
//         $msg = 'Removed from watchlist.';
//     } else {
//         $user->favoriteCars()->attach($car->id);
//         $msg = 'Added to watchlist.';
//     }

//     return back()->with('success', $msg);
// }

}
