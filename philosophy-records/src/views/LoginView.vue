<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'

import {
  googleLogin,
  facebookLogin
} from "../services/authService"

// router instance
const router = useRouter()

// form state
const email = ref('')
const password = ref('')

// normal login (redirect to /home)
const login = () => {
  console.log('Email:', email.value)
  console.log('Password:', password.value)

  // redirect after login
  router.push('/home')
}

// Google login (redirect to /home)
const loginGoogle = async () => {
  try {
    const user = await googleLogin()
    console.log('Google user:', user)

    // redirect after success
    router.push('/home')
  } catch (err) {
    console.error('Google login failed:', err)
  }
}

// Facebook login (redirect to /home)
const loginFacebook = async () => {
  try {
    const user = await facebookLogin()
    console.log('Facebook user:', user)

    // redirect after success
    router.push('/home')
  } catch (err) {
    console.error('Facebook login failed:', err)
  }
}
</script>

<template>
  <div class="min-h-screen flex bg-black">

    <!-- LEFT SIDE -->
    <div class="hidden lg:block lg:w-1/2 relative">

      <img
        src="../assets/philosophy-bg.jpg"
        class="w-full h-full object-cover"
        alt="background"
      />

      <div class="absolute inset-0 bg-black/40"></div>

      <div class="absolute inset-0 flex flex-col justify-center items-center text-white">
        <!-- (optional branding area) -->
      </div>

    </div>

    <!-- RIGHT SIDE -->
    <div class="w-full lg:w-1/2 flex items-center justify-center bg-[#0A0A0A]">

      <div class="w-full max-w-md px-8">

        <h2 class="text-4xl text-white font-bold">
          Welcome Back
        </h2>

        <p class="text-zinc-500 mt-2 mb-8 pb-1">
          Sign in to your account
        </p>

        <!-- EMAIL -->
        <input
          v-model="email"
          type="email"
          placeholder="Email"
          class="w-full p-4 rounded-xl bg-zinc-900 border border-zinc-700 text-white mb-4"
        />

        <!-- PASSWORD -->
        <input
          v-model="password"
          type="password"
          placeholder="Password"
          class="w-full p-4 rounded-xl bg-zinc-900 border border-zinc-700 text-white mb-4"
        />

        <!-- LOGIN BUTTON -->
        <button
          @click="login"
          class="w-full p-4 rounded-xl bg-white text-black font-semibold"
        >
          Login
        </button>

        <!-- DIVIDER -->
        <div class="my-6 flex items-center gap-4 text-zinc-600">
          <div class="flex-1 h-px bg-zinc-800"></div>
          <span class="text-sm">OR</span>
          <div class="flex-1 h-px bg-zinc-800"></div>
        </div>

        <!-- GOOGLE LOGIN -->
        <button
          @click="loginGoogle"
          class="w-full bg-white text-black p-4 rounded-xl"
        >
          Continue with Google
        </button>

        <!-- FACEBOOK LOGIN -->
        <button
          @click="loginFacebook"
          class="w-full bg-blue-600 text-white p-4 rounded-xl mt-4"
        >
          Continue with Facebook
        </button>

      </div>

    </div>

  </div>
</template>