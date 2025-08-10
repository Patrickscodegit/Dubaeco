<x-layout>
    <div class="mx-4">
        <x-card class="p-10 print:p-0 print:border-0">
            <div class="flex flex-col items-center justify-center text-center">
                <!-- Main Image -->
                <img class="w-full max-w-3xl mx-auto mb-6 cursor-pointer object-cover rounded-lg shadow-lg"
                     src="{{ $listing->logo ? asset('storage/' . $listing->logo) : asset('/images/no-image.png') }}"
                     alt="Main Car Image"
                     onclick="openModal(this.src)"/>

                <h3 class="text-2xl mb-2 print:text-3xl">{{ $listing->title }}</h3>
                <div class="text-lg my-4 print:hidden">
                    <i class="fa-solid fa-location-dot"></i> {{ $listing->location }}
                </div>
                <div class="border border-gray-200 w-full mb-6 print:hidden"></div>

                <div class="flex flex-col items-center print:block">
                    <!-- Description section, centrally aligned with text left-aligned -->
                    <div class="w-full text-center print:w-full">
                        <h3 class="text-3xl font-bold mb-4 print:text-4xl">Car Description</h3>
                        <div class="text-lg space-y-6 whitespace-pre-wrap text-left print:text-xl print:whitespace-pre-wrap">
                            {{ $listing->description }}
                        </div>
                    </div>

                

            

                    <div class="flex flex-col items-center print:hidden">
                        <!-- Description section, centrally aligned with text left-aligned -->
                        <div class="w-full text-center">
                            <h3 class="text-3xl font-bold mb-4">Price</h3>
                            <div class="text-lg space-y-6 whitespace-pre-wrap text-center">
                                {{ $listing->price }}
                            </div>
                        </div>
                    </div>
                    <button onclick="window.print();" class="bg-red-500 text-white rounded-xl py-2 px-4 hover:bg-red-600 w-full mt-2 mb-4 mx-auto print:hidden">Print this page</button>

                    <!-- Contact information and website link, full width -->
                    @auth
                        @if (auth()->user()->isAdmin())
                            <a href="mailto:{{ $listing->email }}"
                               class="block bg-laravel text-white mt-6 py-2 mb-2 rounded-xl hover:opacity-80 w-full print:hidden">
                                <i class="fa-solid fa-envelope"></i> Contact Info
                            </a>
                            <a href="{{ $listing->website }}" target="_blank"
                               class="block bg-black text-white py-2 rounded-xl hover:opacity-80 w-full print:hidden">
                                <i class="fa-solid fa-globe"></i> Link to Listing
                            </a>
                        @endif
                    @endauth
                </div>

                <!-- WhatsApp button, full width and centered -->
                <button onclick="contactViaWhatsApp();"
                        class="bg-green-500 text-white rounded-xl py-2 px-4 hover:bg-green-600 mt-2 w-4/5 mx-auto print:hidden">
                    Contact via WhatsApp
                </button>

                <!-- Gallery Carousel -->
                @if($listing->images->count() > 0)
                    <div class="mt-6 print:mt-0">
                        <h3 class="text-2xl font-bold mb-4 print:text-3xl">Gallery</h3>
                        <div x-data="imageCarousel([
                            @foreach($listing->images as $image)
                                '{{ asset('storage/' . $image->image_path) }}',
                            @endforeach
                        ])" 
                        class="relative w-full max-w-3xl mx-auto">
                            <div class="overflow-hidden rounded-lg shadow-lg aspect-w-16 aspect-h-9">
                                <template x-for="(image, index) in images" :key="index">
                                    <img :src="image" 
                                         :class="{'opacity-100': currentIndex === index, 'opacity-0': currentIndex !== index}"
                                         class="absolute w-full h-full object-cover transition-opacity duration-500 cursor-pointer"
                                         @click="openModal(image)"
                                         alt="Gallery image">
                                </template>
                            </div>
                            
                            <!-- Navigation Buttons -->
                            <button @click="prev()" 
                                    class="absolute left-0 top-1/2 -translate-y-1/2 bg-black/50 text-white p-2 rounded-r-lg hover:bg-black/75">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                                </svg>
                            </button>
                            <button @click="next()" 
                                    class="absolute right-0 top-1/2 -translate-y-1/2 bg-black/50 text-white p-2 rounded-l-lg hover:bg-black/75">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </button>
                            
                            <!-- Indicators -->
                            <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 flex space-x-2">
                                <template x-for="(image, index) in images" :key="index">
                                    <button @click="currentIndex = index" 
                                            :class="{'bg-white': currentIndex === index, 'bg-white/50': currentIndex !== index}"
                                            class="w-2 h-2 rounded-full transition-colors duration-200">
                                    </button>
                                </template>
                            </div>
                        </div>
                    </div>
                @else
                    <p class="mt-6 text-gray-500 print:hidden">No additional images provided.</p>
                @endif
            </div>

            @auth
                @if (auth()->user()->isAdmin())
                    <x-card class="mt-4 p-2 flex space-x-6 print:hidden">
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

    <!-- Modal for displaying enlarged image -->
    <div id="imageModal" class="fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center p-4 hidden">
        <img id="modalImage" class="max-w-full max-h-full">
        <span class="absolute top-4 right-4 text-white text-3xl cursor-pointer" onclick="closeModal()">&times;</span>
    </div>

    <!-- Alpine.js initialization -->
    <script src="//unpkg.com/alpinejs" defer></script>
    <script>
        function imageCarousel(images) {
            return {
                images: images,
                currentIndex: 0,
                next() {
                    this.currentIndex = (this.currentIndex + 1) % this.images.length;
                },
                prev() {
                    this.currentIndex = this.currentIndex === 0 
                        ? this.images.length - 1 
                        : this.currentIndex - 1;
                }
            }
        }

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

        function contactViaWhatsApp() {
            var pageUrl = encodeURIComponent(window.location.href);
            var message = "I'm interested in your listing for the car shown on the website. Here's the link to the listing: " + pageUrl;
            var whatsappUrl = `https://wa.me/+32491280944?text=${message}`;
            window.open(whatsappUrl, '_blank');
        }

        // Auto-advance carousel every 5 seconds
        setInterval(() => {
            const carousel = document.querySelector('[x-data="imageCarousel"]')?.__x.$data;
            if (carousel) {
                carousel.next();
            }
        }, 5000);
    </script>

<script>
    function adjustTextareaHeight() {
        const textarea = document.getElementById('feeTextarea');
        textarea.style.height = 'auto';
        textarea.style.height = textarea.scrollHeight + 'px';
    }

    // Adjust the height when the document loads
    window.onload = function() {
        adjustTextareaHeight();
    };
</script>
</x-layout>
