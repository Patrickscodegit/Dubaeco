@props(['listing'])

<style>
  a.block:hover {
    transform: scale(1.02);
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
  }

  a.block {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
  }

  h3:hover {
    color: #ff2d20; /* Laravel red */
  }
</style>

<a href="/listings/{{$listing->id}}" class="block hover:shadow-lg transition-shadow duration-200">
  <x-card>
    <div class="flex">
      <img class="w-32 md:w-48 mr-6 object-cover rounded-lg"
        src="{{$listing->logo ? asset('storage/' . $listing->logo) : asset('/images/no-image.png')}}" 
        alt="{{$listing->title}}" />
      <div class="flex-1">
        <h3 class="text-2xl hover:text-laravel font-bold">{{$listing->title}}</h3>
        <div class="text-xl font-bold mb-4 text-gray-600">{{$listing->company}}</div>
        @if($listing->tags)
          <x-listing-tags :tagsCsv="$listing->tags" />
        @endif
        <div class="text-lg mt-4">
          <i class="fa-solid fa-location-dot"></i> {{$listing->location}}
        </div>
        @if($listing->price)
          <div class="text-lg mt-2 font-semibold text-green-600">
            {{$listing->price}}
          </div>
        @endif
      </div>
    </div>
  </x-card>
</a>