<x-app-layout>
  <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 lg:py-8">
    <!-- Header: title + filters btn (mobile) + sort -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
      <div class="flex items-center gap-3">
        <button type="button" id="search-show-filters" class="lg:hidden flex items-center gap-2 px-3 py-2 rounded-xl bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 text-gray-700 dark:text-gray-300 shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 transition">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6h9.75M10.5 6a1.5 1.5 0 11-3 0m3 0a1.5 1.5 0 10-3 0M3.75 6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-3.75 0H7.5m9-6h3.75m-3.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-9.75 0h9.75" />
          </svg>
          Filters
        </button>
        <h1 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white">Browse cars</h1>
      </div>
      <form id="search-sort-form" method="GET" action="{{ route('cars.search') }}" class="flex items-center gap-2">
        @foreach(request()->except('sort', 'page') as $key => $value)
          @if(is_array($value))
            @foreach($value as $v)
              <input type="hidden" name="{{ $key }}[]" value="{{ $v }}">
            @endforeach
          @else
            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
          @endif
        @endforeach
        <label for="search-sort" class="text-sm font-medium text-gray-600 dark:text-gray-400 whitespace-nowrap">Sort</label>
        <select id="search-sort" name="sort" class="rounded-xl border border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 px-3 py-2 text-sm focus:ring-2 focus:ring-primary focus:border-primary dark:focus:ring-indigo-500 dark:focus:border-indigo-500 min-w-[140px]">
          <option value="">Newest first</option>
          <option value="price" {{ request('sort') === 'price' ? 'selected' : '' }}>Price: Low to High</option>
          <option value="-price" {{ request('sort') === '-price' ? 'selected' : '' }}>Price: High to Low</option>
        </select>
      </form>
    </div>

    <div class="flex gap-6">
      <!-- Sidebar: filters -->
      <aside id="search-sidebar" class="hidden lg:block w-full lg:w-72 xl:w-80 shrink-0">
        <div class="lg:sticky lg:top-24 space-y-4">
          <div class="flex items-center justify-between p-4 rounded-2xl bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 shadow-sm">
            <p class="text-sm text-gray-600 dark:text-gray-400">Found <strong class="text-gray-900 dark:text-white">{{ $cars->total() }}</strong> cars</p>
            <button type="button" id="search-close-filters" class="lg:hidden p-2 rounded-lg text-gray-500 hover:bg-gray-100 dark:hover:bg-gray-700 transition">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5"><path fill-rule="evenodd" d="M5.47 5.47a.75.75 0 011.06 0L12 10.94l5.47-5.47a.75.75 0 11-1.06 1.06L13.06 12l5.47 5.47a.75.75 0 11-1.06-1.06L10.94 12 5.47 6.53a.75.75 0 010-1.06z" clip-rule="evenodd" /></svg>
            </button>
          </div>

          <form action="{{ route('cars.search') }}" method="GET" id="search-form" class="rounded-2xl bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 shadow-sm overflow-hidden">
            <div class="p-4 space-y-4 max-h-[min(60vh,600px)] overflow-y-auto">
              <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Maker</label>
                <select id="makerSelect" name="maker_id" class="w-full rounded-xl border border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 px-3 py-2 text-sm focus:ring-2 focus:ring-primary focus:border-primary">
                  <option value="">All makers</option>
                  <option value="4" {{ request('maker_id') == '4' ? 'selected' : '' }}>Chevrolet</option>
                  <option value="2" {{ request('maker_id') == '2' ? 'selected' : '' }}>Ford</option>
                  <option value="3" {{ request('maker_id') == '3' ? 'selected' : '' }}>Honda</option>
                  <option value="6" {{ request('maker_id') == '6' ? 'selected' : '' }}>Lexus</option>
                  <option value="5" {{ request('maker_id') == '5' ? 'selected' : '' }}>Nissan</option>
                  <option value="1" {{ request('maker_id') == '1' ? 'selected' : '' }}>Toyota</option>
                </select>
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Model</label>
                <select id="modelSelect" name="model_id" class="w-full rounded-xl border border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 px-3 py-2 text-sm focus:ring-2 focus:ring-primary focus:border-primary">
                  <option value="">All models</option>
                  @php
                    $models = [
                      ['id' => 50, 'parent' => 5, 'name' => '370Z'],
                      ['id' => 6, 'parent' => 1, 'name' => '4Runner'],
                      ['id' => 22, 'parent' => 3, 'name' => 'Accord'],
                      ['id' => 41, 'parent' => 5, 'name' => 'Altima'],
                      ['id' => 23, 'parent' => 3, 'name' => 'CR-V'],
                      ['id' => 37, 'parent' => 4, 'name' => 'Camaro'],
                      ['id' => 1, 'parent' => 1, 'name' => 'Camry'],
                      ['id' => 21, 'parent' => 3, 'name' => 'Civic'],
                      ['id' => 36, 'parent' => 4, 'name' => 'Colorado'],
                      ['id' => 2, 'parent' => 1, 'name' => 'Corolla'],
                      ['id' => 35, 'parent' => 4, 'name' => 'Cruze'],
                      ['id' => 54, 'parent' => 6, 'name' => 'ES350'],
                      ['id' => 17, 'parent' => 2, 'name' => 'Edge'],
                      ['id' => 32, 'parent' => 4, 'name' => 'Equinox'],
                      ['id' => 12, 'parent' => 2, 'name' => 'Escape'],
                      ['id' => 18, 'parent' => 2, 'name' => 'Expedition'],
                      ['id' => 13, 'parent' => 2, 'name' => 'Explorer'],
                      ['id' => 11, 'parent' => 2, 'name' => 'F-150'],
                      ['id' => 28, 'parent' => 3, 'name' => 'Fit'],
                      ['id' => 20, 'parent' => 2, 'name' => 'Flex'],
                      ['id' => 47, 'parent' => 5, 'name' => 'Frontier'],
                      ['id' => 15, 'parent' => 2, 'name' => 'Fusion'],
                      ['id' => 58, 'parent' => 6, 'name' => 'GS350'],
                      ['id' => 57, 'parent' => 6, 'name' => 'GX460'],
                      ['id' => 26, 'parent' => 3, 'name' => 'HR-V'],
                      ['id' => 3, 'parent' => 1, 'name' => 'Highlander'],
                      ['id' => 56, 'parent' => 6, 'name' => 'IS300'],
                      ['id' => 34, 'parent' => 4, 'name' => 'Impala'],
                      ['id' => 29, 'parent' => 3, 'name' => 'Insight'],
                      ['id' => 55, 'parent' => 6, 'name' => 'LS500'],
                      ['id' => 60, 'parent' => 6, 'name' => 'LX570'],
                      ['id' => 33, 'parent' => 4, 'name' => 'Malibu'],
                      ['id' => 44, 'parent' => 5, 'name' => 'Maxima'],
                      ['id' => 45, 'parent' => 5, 'name' => 'Murano'],
                      ['id' => 14, 'parent' => 2, 'name' => 'Mustang'],
                      ['id' => 59, 'parent' => 6, 'name' => 'NX300'],
                      ['id' => 25, 'parent' => 3, 'name' => 'Odyssey'],
                      ['id' => 30, 'parent' => 3, 'name' => 'Passport'],
                      ['id' => 46, 'parent' => 5, 'name' => 'Pathfinder'],
                      ['id' => 24, 'parent' => 3, 'name' => 'Pilot'],
                      ['id' => 5, 'parent' => 1, 'name' => 'Prius'],
                      ['id' => 4, 'parent' => 1, 'name' => 'RAV4'],
                      ['id' => 62, 'parent' => 6, 'name' => 'RC350'],
                      ['id' => 53, 'parent' => 6, 'name' => 'RX350'],
                      ['id' => 51, 'parent' => 6, 'name' => 'RX400'],
                      ['id' => 52, 'parent' => 6, 'name' => 'RX450'],
                      ['id' => 16, 'parent' => 2, 'name' => 'Ranger'],
                      ['id' => 27, 'parent' => 3, 'name' => 'Ridgeline'],
                      ['id' => 43, 'parent' => 5, 'name' => 'Rogue'],
                      ['id' => 42, 'parent' => 5, 'name' => 'Sentra'],
                      ['id' => 10, 'parent' => 1, 'name' => 'Sequoia'],
                      ['id' => 7, 'parent' => 1, 'name' => 'Sienna'],
                      ['id' => 31, 'parent' => 4, 'name' => 'Silverado'],
                      ['id' => 40, 'parent' => 4, 'name' => 'Suburban'],
                      ['id' => 39, 'parent' => 4, 'name' => 'Tahoe'],
                      ['id' => 19, 'parent' => 2, 'name' => 'Taurus'],
                      ['id' => 48, 'parent' => 5, 'name' => 'Titan'],
                      ['id' => 38, 'parent' => 4, 'name' => 'Traverse'],
                      ['id' => 9, 'parent' => 1, 'name' => 'Tundra'],
                      ['id' => 61, 'parent' => 6, 'name' => 'UX200'],
                      ['id' => 49, 'parent' => 5, 'name' => 'Versa'],
                      ['id' => 8, 'parent' => 1, 'name' => 'Yaris'],
                    ];
                  @endphp
                  @foreach($models as $m)
                    <option value="{{ $m['id'] }}" data-parent="{{ $m['parent'] }}" {{ request('model_id') == (string)$m['id'] ? 'selected' : '' }}>{{ $m['name'] }}</option>
                  @endforeach
                </select>
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Type</label>
                <select name="car_type_id" class="w-full rounded-xl border border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 px-3 py-2 text-sm focus:ring-2 focus:ring-primary focus:border-primary">
                  <option value="">All types</option>
                  <option value="2" {{ request('car_type_id') == '2' ? 'selected' : '' }}>Hatchback</option>
                  <option value="6" {{ request('car_type_id') == '6' ? 'selected' : '' }}>Jeep</option>
                  <option value="5" {{ request('car_type_id') == '5' ? 'selected' : '' }}>Minivan</option>
                  <option value="4" {{ request('car_type_id') == '4' ? 'selected' : '' }}>Pickup Truck</option>
                  <option value="3" {{ request('car_type_id') == '3' ? 'selected' : '' }}>SUV</option>
                  <option value="1" {{ request('car_type_id') == '1' ? 'selected' : '' }}>Sedan</option>
                </select>
              </div>
              <div class="grid grid-cols-2 gap-2">
                <div>
                  <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Year from</label>
                  <input type="number" name="year_from" placeholder="e.g. 2018" value="{{ request('year_from') }}" class="w-full rounded-xl border border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 px-3 py-2 text-sm focus:ring-2 focus:ring-primary focus:border-primary" min="1990" max="{{ date('Y') + 1 }}">
                </div>
                <div>
                  <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Year to</label>
                  <input type="number" name="year_to" placeholder="e.g. 2024" value="{{ request('year_to') }}" class="w-full rounded-xl border border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 px-3 py-2 text-sm focus:ring-2 focus:ring-primary focus:border-primary" min="1990" max="{{ date('Y') + 1 }}">
                </div>
              </div>
              <div class="grid grid-cols-2 gap-2">
                <div>
                  <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Price from</label>
                  <input type="number" name="price_from" placeholder="Min" value="{{ request('price_from') }}" class="w-full rounded-xl border border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 px-3 py-2 text-sm focus:ring-2 focus:ring-primary focus:border-primary" min="0">
                </div>
                <div>
                  <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Price to</label>
                  <input type="number" name="price_to" placeholder="Max" value="{{ request('price_to') }}" class="w-full rounded-xl border border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 px-3 py-2 text-sm focus:ring-2 focus:ring-primary focus:border-primary" min="0">
                </div>
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Mileage</label>
                <select name="mileage" class="w-full rounded-xl border border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 px-3 py-2 text-sm focus:ring-2 focus:ring-primary focus:border-primary">
                  <option value="">Any</option>
                  <option value="10000" {{ request('mileage') == '10000' ? 'selected' : '' }}>10,000 or less</option>
                  <option value="50000" {{ request('mileage') == '50000' ? 'selected' : '' }}>50,000 or less</option>
                  <option value="100000" {{ request('mileage') == '100000' ? 'selected' : '' }}>100,000 or less</option>
                  <option value="200000" {{ request('mileage') == '200000' ? 'selected' : '' }}>200,000 or less</option>
                </select>
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">State</label>
                <select id="stateSelect" name="state_id" class="w-full rounded-xl border border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 px-3 py-2 text-sm focus:ring-2 focus:ring-primary focus:border-primary">
                  <option value="">All states</option>
                  <option value="4" {{ request('state_id') == '4' ? 'selected' : '' }}>California</option>
                  <option value="2" {{ request('state_id') == '2' ? 'selected' : '' }}>Kansas</option>
                  <option value="1" {{ request('state_id') == '1' ? 'selected' : '' }}>Ohio</option>
                  <option value="5" {{ request('state_id') == '5' ? 'selected' : '' }}>Oregon</option>
                </select>
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">City</label>
                <select id="citySelect" name="city_id" class="w-full rounded-xl border border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 px-3 py-2 text-sm focus:ring-2 focus:ring-primary focus:border-primary">
                  <option value="">All cities</option>
                </select>
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Fuel type</label>
                <select name="fuel_type_id" class="w-full rounded-xl border border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 px-3 py-2 text-sm focus:ring-2 focus:ring-primary focus:border-primary">
                  <option value="">All</option>
                  <option value="2" {{ request('fuel_type_id') == '2' ? 'selected' : '' }}>Diesel</option>
                  <option value="3" {{ request('fuel_type_id') == '3' ? 'selected' : '' }}>Electric</option>
                  <option value="1" {{ request('fuel_type_id') == '1' ? 'selected' : '' }}>Gasoline</option>
                  <option value="4" {{ request('fuel_type_id') == '4' ? 'selected' : '' }}>Hybrid</option>
                </select>
              </div>
            </div>
            <div class="p-4 border-t border-gray-200 dark:border-gray-700 flex gap-2">
              <button type="button" id="search-form-reset" class="flex-1 px-4 py-2 rounded-xl border border-gray-200 dark:border-gray-600 text-gray-700 dark:text-gray-300 text-sm font-medium hover:bg-gray-50 dark:hover:bg-gray-700 transition">Reset</button>
              <button type="submit" class="flex-1 px-4 py-2 rounded-xl bg-primary text-white text-sm font-medium hover:opacity-90 transition shadow-md">Search</button>
            </div>
          </form>
        </div>
      </aside>

      <!-- Overlay for mobile when sidebar is open -->
      <div id="search-sidebar-overlay" class="fixed inset-0 bg-black/50 z-40 opacity-0 pointer-events-none transition lg:hidden" aria-hidden="true"></div>

      <!-- Results -->
      <div class="flex-1 min-w-0">
        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-4 gap-4 sm:gap-5">
          @forelse($cars as $car)
            <x-car-item :car="$car" />
          @empty
            <div class="col-span-full rounded-2xl bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 p-12 text-center">
              <p class="text-gray-500 dark:text-gray-400">No cars match your criteria. Try adjusting the filters.</p>
              <a href="{{ route('cars.search') }}" class="inline-block mt-4 text-primary font-medium hover:underline">Clear filters</a>
            </div>
          @endforelse
        </div>
        @if($cars->hasPages())
          <div class="mt-8 flex justify-center">
            {{ $cars->onEachSide(1)->links('pagination') }}
          </div>
        @endif
      </div>
    </div>
  </main>

  <script>
    (function () {
      var sidebar = document.getElementById('search-sidebar');
      var overlay = document.getElementById('search-sidebar-overlay');
      var showBtn = document.getElementById('search-show-filters');
      var closeBtn = document.getElementById('search-close-filters');
      function openSidebar() {
        if (!sidebar) return;
        sidebar.classList.remove('hidden');
        sidebar.classList.add('fixed', 'inset-y-0', 'left-0', 'z-50', 'w-80', 'max-w-[85vw]', 'overflow-y-auto', 'bg-white', 'dark:bg-gray-800', 'shadow-xl');
        if (overlay) { overlay.classList.remove('opacity-0', 'pointer-events-none'); overlay.classList.add('opacity-100'); }
        document.body.style.overflow = 'hidden';
      }
      function closeSidebar() {
        if (!sidebar) return;
        sidebar.classList.add('hidden');
        sidebar.classList.remove('fixed', 'inset-y-0', 'left-0', 'z-50', 'w-80', 'max-w-[85vw]', 'overflow-y-auto', 'bg-white', 'dark:bg-gray-800', 'shadow-xl');
        if (overlay) { overlay.classList.add('opacity-0', 'pointer-events-none'); overlay.classList.remove('opacity-100'); }
        document.body.style.overflow = '';
      }
      showBtn && showBtn.addEventListener('click', openSidebar);
      closeBtn && closeBtn.addEventListener('click', closeSidebar);
      overlay && overlay.addEventListener('click', closeSidebar);

      var sortSelect = document.getElementById('search-sort');
      var sortForm = document.getElementById('search-sort-form');
      if (sortSelect && sortForm) sortSelect.addEventListener('change', function () { sortForm.submit(); });

      var resetBtn = document.getElementById('search-form-reset');
      var form = document.getElementById('search-form');
      if (resetBtn && form) resetBtn.addEventListener('click', function () { window.location.href = '{{ route("cars.search") }}'; });

      var makerSelect = document.getElementById('makerSelect');
      var modelSelect = document.getElementById('modelSelect');
      if (makerSelect && modelSelect) {
        function filterModels() {
          var makerId = makerSelect.value;
          Array.prototype.forEach.call(modelSelect.options, function (opt) {
            if (opt.value === '') { opt.style.display = 'block'; opt.disabled = !makerId; return; }
            var show = !makerId || opt.getAttribute('data-parent') === makerId;
            opt.style.display = show ? 'block' : 'none';
            opt.disabled = !show;
          });
        }
        makerSelect.addEventListener('change', filterModels);
        filterModels();
      }

      var stateSelect = document.getElementById('stateSelect');
      var citySelect = document.getElementById('citySelect');
      if (stateSelect && citySelect) {
        stateSelect.addEventListener('change', function () {
          var stateId = stateSelect.value;
          citySelect.innerHTML = '<option value="">All cities</option>';
          citySelect.disabled = true;
          if (!stateId) return;
          fetch('{{ url("/cars/cities") }}/' + stateId, { headers: { 'Accept': 'application/json' } })
            .then(function (r) { return r.json(); })
            .then(function (cities) {
              cities.forEach(function (c) {
                var opt = document.createElement('option');
                opt.value = c.id;
                opt.textContent = c.name;
                citySelect.appendChild(opt);
              });
              citySelect.disabled = false;
            });
        });
        if (stateSelect.value) stateSelect.dispatchEvent(new Event('change'));
      }
    })();
  </script>
</x-app-layout>
