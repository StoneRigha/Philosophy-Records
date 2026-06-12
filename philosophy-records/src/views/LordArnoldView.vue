<template>
  <div class="min-h-screen bg-black text-white">
    
    <!-- HEADER SLIDER -->
    <div class="relative h-96 overflow-hidden rounded-b-3xl bg-black">
      <div
        class="absolute inset-0 flex h-full"
        :style="{ transform: `translateX(-${activeSlide * 100}%)` }"
      >
        <img src="../assets/la-slide-1.jpg" class="w-full h-full object-cover" alt="LA Slide 1" />
        <img src="../assets/la-slide-2.jpg" class="w-full h-full object-cover" alt="LA Slide 2" />
        <img src="../assets/la-slide-3.webp" class="w-full h-full object-cover" alt="LA Slide 3" />
        <img src="../assets/la-slide-4.webp" class="w-full h-full object-cover" alt="LA Slide 4" />
        <img src="../assets/la-slide-5.webp" class="w-full h-full object-cover" alt="LA Slide 5" />
      </div>

      <div class="absolute inset-0 bg-black/30"></div>

      <div class="absolute inset-x-0 bottom-0 p-8 text-center">
        <h1 class="text-5xl font-bold text-white mb-3">Lord Arnold</h1>
        <p class="text-muted text-lg">A Philosophy Records Artist</p>
      </div>

      <button
        @click="prevSlide"
        class="absolute left-4 top-1/2 -translate-y-1/2 rounded-full bg-black/60 border border-white/10 p-3 text-white hover:bg-black/80"
        aria-label="Previous slide"
      >
        ←
      </button>
      <button
        @click="nextSlide"
        class="absolute right-4 top-1/2 -translate-y-1/2 rounded-full bg-black/60 border border-white/10 p-3 text-white hover:bg-black/80"
        aria-label="Next slide"
      >
        →
      </button>
    </div>

    <!-- CONTENT -->
    <div class="max-w-5xl mx-auto py-16 px-4 sm:px-6 md:px-10">
      
      <button 
        @click="goBack" 
        class="mb-8 inline-flex w-full sm:w-auto justify-center px-5 py-3 bg-zinc-800 hover:bg-zinc-700 rounded-full text-sm"
      >
        ← Back to Catalog
      </button>

      <div class="mb-12">
        <h2 class="text-3xl sm:text-4xl font-bold mb-4">About This Release</h2>
        <p class="text-zinc-300 leading-relaxed mb-4 text-base sm:text-lg">
          Lord Arnold is a builder in every sense of the word. Translating the discipline of construction into soulful hip-hop, he crafts heavy verses and smooth flows that take listeners on an effortless journey. Existing at the intersection of labor and lyricism, his grounded artistry reflects a life lived both on-site and on stage.
        </p>
        <p class="text-zinc-300 leading-relaxed">
          Through carefully composed soundscapes and philosophical undertones, Lord Arnold invites 
          listeners to question their perceptions and embrace the evolving nature of contemporary music culture.
        </p>
      </div>

      <div class="mb-12">
        
      </div>

      

      <a
        href="https://www.youtube.com/@lordarnold653"
        target="_blank"
        rel="noreferrer noopener"
        class="inline-flex px-8 py-3 bg-white text-black rounded-xl hover:bg-zinc-200 transition font-semibold"
      >
        Listen on YouTube
      </a>

    </div>

  </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue'
import { useRouter } from 'vue-router'

const router = useRouter()
const activeSlide = ref(0)
const totalSlides = 5
let slideInterval

const goBack = () => {
  router.back()
}

const nextSlide = () => {
  activeSlide.value = (activeSlide.value + 1) % totalSlides
}

const prevSlide = () => {
  activeSlide.value = (activeSlide.value - 1 + totalSlides) % totalSlides
}

const goToSlide = (index) => {
  activeSlide.value = index
}

const startAutoSlide = () => {
  slideInterval = setInterval(() => {
    nextSlide()
  }, 4000)
}

const stopAutoSlide = () => {
  if (slideInterval) clearInterval(slideInterval)
}

onMounted(() => {
  startAutoSlide()
})

onUnmounted(() => {
  stopAutoSlide()
})
</script>
