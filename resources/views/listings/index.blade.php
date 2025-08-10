<x-layout>


  @if (!Auth::check())
    @include('partials._hero')
  @endif

  @include('partials._search')

  <div class="mx-4">
    @unless(count($listings) == 0)
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
        @foreach($listings as $listing)
          <x-listing-card :listing="$listing" />
        @endforeach
      </div>
    @else
      <p>No listings found</p>
    @endunless
  </div>

  <div class="mt-6 p-4">
    {{$listings->links()}}
  </div>
</x-layout>
