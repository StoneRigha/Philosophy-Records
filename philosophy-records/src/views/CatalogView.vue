<template>
  <div class="min-h-screen bg-black text-white py-12 px-4 sm:px-6 md:px-10">
    
    <div class="max-w-6xl mx-auto">
      <button 
        @click="goBack" 
        class="mb-8 px-4 py-2 bg-zinc-800 hover:bg-zinc-700 rounded-full text-sm"
      >
        ← Back
      </button>

      <h1 class="text-4xl sm:text-5xl font-bold mb-4">Our Records</h1>
      <p class="text-muted max-w-2xl mb-10 text-base sm:text-lg">
        Explore our collection of culture-driven music from artists with a strong philosophical voice.
      </p>

      <!-- RECORDS GRID -->
      <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        
        <!-- HR THE MESSENGER -->
        <div
          @click="navigateTo('hr-the-messenger')"
          class="bg-zinc-900 hover:bg-zinc-800 cursor-pointer rounded-xl overflow-hidden transition"
        >
          <img src="../assets/hr2.jpg" alt="HR The Messenger" class="w-full h-64 object-cover">
          <div class="p-6">
            <h2 class="text-2xl font-bold mb-2">HR The Messenger</h2>
            <p class="text-muted">
              Award winning recording, performing, artist, & producer.
            </p>
          </div>
        </div>

        <!-- LORD ARNOLD -->
        <div
          @click="navigateTo('lord-arnold')"
          class="bg-zinc-900 hover:bg-zinc-800 cursor-pointer rounded-xl overflow-hidden transition"
        >
          <img src="../assets/la.jpg" alt="Lord Arnold" class="w-full h-64 object-cover">
          <div class="p-6">
            <h2 class="text-2xl font-bold mb-2">Lord Arnold</h2>
            <p class="text-muted">
              Delving into the depths of The Lyricist , The Philosopher.
            </p>
          </div>
        </div>

      </div>
    </div>

  </div>
</template>

<script setup>
import { useRouter } from 'vue-router'

const router = useRouter()

const navigateTo = (page) => {
  router.push({ name: page })
}

const goBack = () => {
  router.back()
}
</script>
