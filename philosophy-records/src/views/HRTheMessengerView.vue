<template>
  <div class="min-h-screen bg-black text-white">
    
    <!-- HEADER SLIDER -->
    <div class="relative h-72 sm:h-96 overflow-hidden rounded-b-3xl bg-black">
      <div
        class="absolute inset-0 flex h-full"
        :style="{ transform: `translateX(-${activeSlide * 100}%)` }"
      >
        <img src="../assets/hr-slide-1.jpg" class="w-full h-full object-cover" alt="HR Slide 1" />
        <img src="../assets/hr-slide-2.jpg" class="w-full h-full object-cover" alt="HR Slide 2" />
        <img src="../assets/hr-slide-3.jpg" class="w-full h-full object-cover" alt="HR Slide 3" />
        <img src="../assets/hr-slide-4.jpg" class="w-full h-full object-cover" alt="HR Slide 4" />
        <img src="../assets/hr-slide-5.jpg" class="w-full h-full object-cover" alt="HR Slide 5" />
      </div>

      <div class="absolute inset-0 bg-black/30"></div>

      <div class="absolute inset-x-0 bottom-0 p-8 text-center">
        <h1 class="text-5xl font-bold text-white mb-3">HR The Messenger</h1>
        <p class="text-muted text-lg">A Philosophy Records Release</p>
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
        <h2 class="text-3xl sm:text-4xl font-bold mb-4">About HR The Messenger</h2>
        <p class="text-zinc-300 leading-relaxed mb-4 text-base sm:text-lg">
          HR The Messenger an award-winning Kenyan rapper, writer, and producer who fuses hip-hop and soul with raw vulnerability. Known for soulful storytelling and heartfelt lyricism, his music blends classic hip-hop with modern beats, prompting both reflection and rhythmic appeal
        </p>
        <p class="text-zinc-300 leading-relaxed">
          Each track is meticulously crafted to challenge listeners and inspire deeper reflection 
          on the role of music in shaping our understanding of culture and identity. His authentic exploration of identity, love, and mental health has earned him a dedicated global fanbase.
        </p>
      </div>

      <div class="mb-12">
       
      </div>

      <div class="mb-12">
        
      </div>

      <a
        href="https://www.youtube.com/@HRTheMessenger"
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
