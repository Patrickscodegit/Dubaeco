@props(['listing'])

<a href="/listings/{{$listing->id}}" class="block hover:shadow-lg transition-shadow duration-200">
  <x-card>
    <div class="flex">
      <img class="w-32 md:w-48 mr-6 object-cover"
        src="{{$listing->logo ? asset('storage/' . $listing->logo) : asset('/images/no-image.png')}}" 
        alt="{{$listing->title}}" />
      <div>
        <h3 class="text-2xl hover:text-laravel">{{$listing->title}}</h3>
        <div class="text-xl font-bold mb-4">{{$listing->company}}</div>
        <x-listing-tags :tagsCsv="$listing->tags" />
        <div class="text-lg mt-4">
          <i class="fa-solid fa-location-dot"></i> {{$listing->location}}
        </div>
      </div>
    </div>
  </x-card>
</a>