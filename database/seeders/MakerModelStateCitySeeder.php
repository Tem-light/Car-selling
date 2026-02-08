<?php

namespace Database\Seeders;

use App\Models\CarModel;
use App\Models\City;
use App\Models\Maker;
use App\Models\State;
use Illuminate\Database\Seeder;

class MakerModelStateCitySeeder extends Seeder
{
    public function run(): void
    {
        $makers = [
            'Toyota'  => ['Camry', 'Corolla', 'RAV4', 'Highlander', '4Runner', 'Prius', 'Sienna', 'Yaris', 'Tundra', 'Sequoia'],
            'Honda'   => ['Civic', 'Accord', 'CR-V', 'Pilot', 'Odyssey', 'HR-V', 'Fit', 'Insight', 'Passport', 'Ridgeline'],
            'Ford'     => ['F-150', 'Escape', 'Explorer', 'Edge', 'Expedition', 'Fusion', 'Ranger', 'Mustang', 'Flex', 'Taurus'],
            'Chevrolet'=> ['Silverado', 'Equinox', 'Malibu', 'Cruze', 'Camaro', 'Colorado', 'Traverse', 'Tahoe', 'Suburban', 'Impala'],
            'Nissan'  => ['Altima', 'Sentra', 'Rogue', 'Pathfinder', 'Murano', 'Frontier', 'Titan', 'Versa', '370Z', 'Maxima'],
            'Lexus'   => ['ES350', 'RX350', 'IS300', 'NX300', 'LS500', 'GX460', 'GS350', 'UX200', 'LX570', 'RC350', 'RX400', 'RX450'],
        ];

        $makerIds = [];
        foreach (array_keys($makers) as $makerName) {
            $maker = Maker::firstOrCreate(['name' => $makerName]);
            $makerIds[$makerName] = $maker->id;
            foreach ($makers[$makerName] as $modelName) {
                CarModel::firstOrCreate([
                    'maker_id' => $maker->id,
                    'name'     => $modelName,
                ]);
            }
        }

        $states = [
            'Ohio'      => ['Columbus', 'Cleveland', 'Cincinnati', 'Toledo', 'Akron', 'Dayton'],
            'Kansas'    => ['Wichita', 'Overland Park', 'Kansas City', 'Olathe', 'Topeka', 'Lawrence'],
            'California'=> ['Los Angeles', 'San Francisco', 'San Diego', 'San Jose', 'Sacramento', 'Oakland', 'Fresno'],
            'Oregon'    => ['Portland', 'Eugene', 'Salem', 'Gresham', 'Hillsboro', 'Bend'],
        ];

        foreach ($states as $stateName => $cityNames) {
            $state = State::firstOrCreate(['name' => $stateName]);
            foreach ($cityNames as $cityName) {
                City::firstOrCreate([
                    'state_id' => $state->id,
                    'name'     => $cityName,
                ]);
            }
        }
    }
}
