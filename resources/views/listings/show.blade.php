<x-layout>
    <a href="/" class="inline-block text-black ml-4 mb-4"><i class="fa-solid fa-arrow-left"></i> Back</a>
    <div class="mx-4">
        <x-card class="p-10">
            <div class="flex flex-col items-center justify-center text-center">
                <img class="w-48 mr-6 mb-6 cursor-pointer"
                     src="{{ $listing->logo ? asset('storage/' . $listing->logo) : asset('/images/no-image.png') }}"
                     alt="Company Logo"
                     onclick="openModal(this.src)"/>

                <h3 class="text-2xl mb-2">{{ $listing->title }}</h3>
                <x-listing-tags :tagsCsv="$listing->tags" />
                <div class="text-lg my-4">
                    <i class="fa-solid fa-location-dot"></i> {{ $listing->location }}
                </div>
                <div class="border border-gray-200 w-full mb-6"></div>

                <div class="flex flex-col items-center">
                    <div class="w-1/3 text-center">
                        <h3 class="text-3xl font-bold mb-4">Car Description</h3>
                        <div class="text-lg space-y-6 whitespace-pre-wrap text-left">
                            {{ $listing->description }}
                        </div>
                    </div>

                    @auth
                        @if (auth()->user()->isAdmin())
                            <a href="mailto:{{ $listing->email }}"
                               class="block bg-laravel text-white mt-6 py-2 mb-2 rounded-xl hover:opacity-80 w-full">
                                <i class="fa-solid fa-envelope"></i> Contact Info
                            </a>
                            <a href="{{ $listing->website }}" target="_blank"
                               class="block bg-black text-white py-2 rounded-xl hover:opacity-80 w-full">
                                <i class="fa-solid fa-globe"></i> Link to Listing
                            </a>
                        @endif
                    @endauth
                </div>

                <button onclick="contactViaWhatsApp();"
                        class="bg-green-500 text-white rounded-xl py-2 px-4 hover:bg-green-600 mt-2 w-4/5 mx-auto">
                    Contact via WhatsApp
                </button>

                @if($listing->images->count() > 0)
                    <div class="mt-6">
                        <h3 class="text-2xl font-bold mb-4">Gallery</h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                            @foreach($listing->images as $image)
                                <img src="{{ asset('storage/' . $image->image_path) }}"
                                     alt="Gallery Image"
                                     class="rounded-lg shadow-lg cursor-pointer transition duration-200 ease-in transform hover:scale-105"
                                     onclick="openModal(this.src)">
                            @endforeach
                        </div>
                    </div>
                @else
                    <p class="mt-6 text-gray-500">No additional images provided.</p>
                @endif
            </div>

            @auth
                @if (auth()->user()->isAdmin())
                    <x-card class="mt-4 p-2 flex space-x-6">
                        <a href="/listings/{{ $listing->id }}/edit" class="text-blue-500">
                            <i class="fa-solid fa-pencil"></i> Edit
                        </a>
                        <form method="POST" action="/listings/{{ $listing->id }}">
                            @csrf
                            @method('DELETE')
                            <button class="text-red-500"><i class="fa-solid fa-trash"></i> Delete</button>
                        </form>
                    </x-card>
                @endif
            @endauth
        </x-card>
    </div>

    {{-- Modal for displaying enlarged image --}}
    <div id="imageModal" class="fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center p-4 hidden">
        <img id="modalImage" class="max-w-full max-h-full">
        <span class="absolute top-4 right-4 text-white text-3xl cursor-pointer" onclick="closeModal()">&times;</span>
    </div>

    <script>
        function openModal(src) {
            var modal = document.getElementById('imageModal');
            var modalImg = document.getElementById('modalImage');
            modal.classList.remove('hidden');
            modalImg.src = src;
        }

        function closeModal() {
            var modal = document.getElementById('imageModal');
            modal.classList.add('hidden');
        }
    </script>

    <script>
        function contactViaWhatsApp() {
            var pageUrl = encodeURIComponent(window.location.href);
            var message = "I'm interested in your listing for the car shown on the website. Here's the link to the listing: " + pageUrl;
            var whatsappUrl = `https://wa.me/+32491280944?text=${message}`;
            window.open(whatsappUrl, '_blank');
        }
    </script>
</x-layout>
