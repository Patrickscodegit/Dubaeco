@props(['images'])

<div class="gallery-viewer relative w-full max-w-3xl mx-auto mb-6">
    <div class="gallery-container overflow-hidden rounded-lg shadow-lg bg-gray-100">
        <div class="gallery-track flex transition-transform duration-300" data-current="0">
            @foreach($images as $index => $image)
                <div class="gallery-slide w-full flex-shrink-0">
                    <div class="relative pt-[56.25%]"> <!-- 16:9 aspect ratio container -->
                        <img src="{{ $image->image_url }}" 
                             class="absolute inset-0 w-full h-full object-contain p-2 cursor-pointer"
                             alt="Gallery image {{ $index + 1 }}"
                             onclick="openModal(this.src)">
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    @if(count($images) > 1)
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

        <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 flex space-x-2">
            @foreach($images as $index => $image)
                <button onclick="goToSlide({{ $index }})"
                        class="gallery-dot w-2 h-2 rounded-full bg-white/50 transition-colors duration-200"
                        data-index="{{ $index }}">
                </button>
            @endforeach
        </div>
    @endif
</div>

<style>
    .gallery-container {
        overflow: hidden;
    }
    
    .gallery-track {
        display: flex;
        transition: transform 0.3s ease-in-out;
    }
    
    .gallery-slide {
        width: 100%;
        flex-shrink: 0;
    }

    /* Add loading animation */
    .gallery-slide img {
        opacity: 0;
        transition: opacity 0.3s ease-in-out;
    }

    .gallery-slide img.loaded {
        opacity: 1;
    }
    
    .gallery-dot.active {
        background-color: white;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        initGallery();
        initImageLoading();
    });

    function initImageLoading() {
        document.querySelectorAll('.gallery-slide img').forEach(img => {
            if (img.complete) {
                img.classList.add('loaded');
            } else {
                img.addEventListener('load', function() {
                    this.classList.add('loaded');
                });
            }
        });

    function initGallery() {
        updateDots(0);
        // Add touch support
        const gallery = document.querySelector('.gallery-container');
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
        const current = parseInt(track.dataset.current);
        const slides = track.children.length;
        let next = (current + direction) % slides;
        
        if (next < 0) next = slides - 1;
        goToSlide(next);
    }

    function goToSlide(index) {
        const track = document.querySelector('.gallery-track');
        track.style.transform = `translateX(-${index * 100}%)`;
        track.dataset.current = index;
        updateDots(index);
    }

    function updateDots(activeIndex) {
        document.querySelectorAll('.gallery-dot').forEach((dot, index) => {
            dot.classList.toggle('active', index === activeIndex);
        });
    }
</script>
