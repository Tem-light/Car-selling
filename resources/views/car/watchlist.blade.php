<x-app-layout>
    <main>
      <!-- New Cars -->
      <section>
        <div class="container">
          <div class="justify items-center flex ">
          <h2>My Favourite Cars</h2>
          @if($cars->total()>0)
          </div>
          <div class="car-items-listing">
            @foreach ($cars as $car)
              <x-car-item :car="$car" />
            @endforeach
          </div>

          {{ $cars->onEachSide(1)->links('pagination') }}
        </div>
      </section>
      <!--/ New Cars -->
    </main>

</x-layouts.app>