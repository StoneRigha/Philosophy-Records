<script setup>
import { useRouter } from 'vue-router'

const router = useRouter()

const explore = () => {
  router.push({ name: 'catalog' })
}
</script>

<template>
  <div class="min-h-screen bg-black text-white">

    <!-- HERO SECTION -->
    <section class="min-h-[85vh] md:h-screen flex items-center justify-center bg-cover bg-center px-4 sm:px-6"
      style="background-image: url('/hero.jpg');">

      <div class="text-center bg-black/70 backdrop-blur-sm p-8 sm:p-10 rounded-[30px] max-w-3xl w-full">
        <h1 class="text-5xl sm:text-6xl font-bold">Philosophy Records</h1>
        <p class="tracking-[0.3em] uppercase mt-4 text-muted text-sm sm:text-base">
          Sound • Culture • Identity
        </p>

        <button 
          @click="explore"
          class="mt-8 px-8 py-3 bg-white text-black rounded-full hover:bg-zinc-200 transition font-semibold text-sm sm:text-base"
        >
          Explore
        </button>

        <div class="mt-8 text-left max-w-2xl mx-auto">
          <h2 class="text-2xl sm:text-3xl font-semibold mb-3">About Us</h2>
          <p class="text-muted leading-relaxed text-sm sm:text-base">
            We build culture-driven music experiences inspired by philosophy and sound design. Our artists blend life, lyricism, and emotion into immersive releases that feel cinematic and true.
          </p>
        </div>
      </div>

    </section>

    <!-- SECTION 2 removed; content moved into hero overlay -->

  </div>
</template>