 @props(['color', 'bgColor' => 'white'])
   
   <div {{ $attributes->merge(['lang'=>'ka'])->class([
      " card card-text-$color card-bg-$bgColor"]) }}>
    <div class="card-header">{{ $header }}</div>
    {{ $slot }}
    <div class="card-footer">
        {{ $footer }}
    </div>
   </div>