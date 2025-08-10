<x-layout>
    <div class="mx-4">
        <x-card class="p-10 print:p-0 print:border-0">
            <div class="flex flex-col items-center justify-center text-center">
                <!-- Main Image -->
                <div class="w-full max-w-3xl mx-auto mb-6 bg-gray-100 rounded-lg shadow-lg overflow-hidden">
                    <div class="relative pt-[56.25%]">
                        <img class="absolute inset-0 w-full h-full cursor-pointer object-contain p-2"
                             src="{{ $listing->logo ? asset('storage/' . $listing->logo) : asset('/images/no-image.png') }}"
                             alt="Main Car Image"
                             onclick="openModal(this.src)"/>
                    </div>
                </div>

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

                <!-- Gallery Section -->
                @if($listing->images->count() > 0)
                    <div class="mt-6 print:mt-0">
                        <h3 class="text-2xl font-bold mb-4 print:text-3xl">Gallery</h3>
                        <div class="gallery-viewer relative w-full max-w-4xl mx-auto mb-6">
                            <div class="gallery-container overflow-hidden rounded-lg shadow-lg bg-gray-100">
                                <div class="h-[400px] md:h-[500px] lg:h-[600px]"> <!-- Fixed height container -->
                                    <div class="gallery-track flex h-full transition-transform duration-300" data-current="0">
                                        @foreach($listing->images as $index => $image)
                                            <div class="gallery-slide w-full flex-shrink-0 h-full flex items-center justify-center">
                                                <img src="{{ asset('storage/' . $image->image_path) }}" 
                                                     class="max-w-full max-h-full object-contain cursor-pointer p-4"
                                                     alt="Gallery image {{ $index + 1 }}"
                                                     onclick="openModal(this.src)">
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            @if($listing->images->count() > 1)
                                <!-- Navigation Buttons -->
                                <button onclick="moveSlide(-1)" 
                                        class="gallery-prev absolute left-0 top-1/2 -translate-y-1/2 bg-black/50 text-white p-2 rounded-r-lg hover:bg-black/75 focus:outline-none">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                    </svg>
                                </button>

                                <button onclick="moveSlide(1)"
                                        class="gallery-next absolute right-0 top-1/2 -translate-y-1/2 bg-black/50 text-white p-2 rounded-l-lg hover:bg-black/75 focus:outline-none">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </button>

                                <!-- Indicators -->
                                <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 flex space-x-2">
                                    @foreach($listing->images as $index => $image)
                                        <button onclick="goToSlide({{ $index }})"
                                                class="gallery-dot w-2 h-2 rounded-full bg-white/50 transition-colors duration-200"
                                                data-index="{{ $index }}">
                                        </button>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                @else
                    <p class="mt-6 text-gray-500 print:hidden">No additional images provided.</p>
                @endif

                <style>
                    .gallery-container {
                        background: #f8f8f8;
                    }
                    
                    .gallery-track {
                        display: flex;
                        transition: transform 0.3s ease-in-out;
                    }
                    
                    .gallery-slide {
                        width: 100%;
                        flex-shrink: 0;
                    }

                    .gallery-dot {
                        width: 8px;
                        height: 8px;
                        border-radius: 50%;
                        background-color: rgba(255, 255, 255, 0.5);
                        transition: background-color 0.3s ease;
                    }

                    .gallery-dot.active {
                        background-color: white;
                        transform: scale(1.2);
                    }

                    /* Navigation button hover effects */
                    .gallery-prev:hover, .gallery-next:hover {
                        background-color: rgba(0, 0, 0, 0.75);
                    }
                </style>

                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        initGallery();
                    });

                    function initGallery() {
                        updateDots(0);
                        // Add touch support
                        const gallery = document.querySelector('.gallery-container');
                        if (!gallery) return;
                        
                        let startX, moved;
                        
                        gallery.addEventListener('touchstart', (e) => {
                            startX = e.touches[0].clientX;
                            moved = false;
                        }, { passive: true });
                        
                        gallery.addEventListener('touchmove', () => {
                            moved = true;
                        }, { passive: true });
                        
                        gallery.addEventListener('touchend', (e) => {
                            if (!moved) return;
                            const diffX = e.changedTouches[0].clientX - startX;
                            if (Math.abs(diffX) > 50) {
                                moveSlide(diffX < 0 ? 1 : -1);
                            }
                        }, { passive: true });
                    }

                    function moveSlide(direction) {
                        const track = document.querySelector('.gallery-track');
                        if (!track) return;
                        
                        const current = parseInt(track.dataset.current || 0);
                        const slides = track.children.length;
                        let next = (current + direction) % slides;
                        
                        if (next < 0) next = slides - 1;
                        goToSlide(next);
                    }

                    function goToSlide(index) {
                        const track = document.querySelector('.gallery-track');
                        if (!track) return;

                        // Ensure smooth transition
                        track.style.transition = 'transform 0.3s ease-in-out';
                        track.style.transform = `translateX(-${index * 100}%)`;
                        track.dataset.current = index;
                        
                        // Update navigation state
                        updateDots(index);
                        
                        // Handle edge cases
                        setTimeout(() => {
                            track.style.transition = '';
                        }, 300);
                    }

                    function updateDots(activeIndex) {
                        document.querySelectorAll('.gallery-dot').forEach((dot, index) => {
                            dot.classList.toggle('active', index === activeIndex);
                        });
                    }
                </script>
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
    <div id="imageModal" class="fixed inset-0 bg-black bg-opacity-90 flex items-center justify-center p-4 hidden z-50">
        <div class="relative max-w-7xl w-full h-full flex items-center justify-center">
            <img id="modalImage" class="max-w-full max-h-[90vh] object-contain">
            <button class="absolute top-4 right-4 text-white text-3xl hover:text-gray-300 focus:outline-none" 
                    onclick="closeModal()">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
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
