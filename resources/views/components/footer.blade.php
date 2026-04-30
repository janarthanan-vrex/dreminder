<footer class="relative bg-gradient-to-b from-slate-950 to-black overflow-hidden">
  
  <!-- Background Pattern -->
  <div class="absolute inset-0 opacity-30">
    <svg class="w-full h-full" xmlns="http://www.w3.org/2000/svg">
      <defs>
        <pattern id="grid" width="32" height="32" patternUnits="userSpaceOnUse">
          <path d="M 32 0 L 0 0 0 32" fill="none" stroke="white" stroke-width="0.5" opacity="0.1"/>
        </pattern>
      </defs>
      <rect width="100%" height="100%" fill="url(#grid)"/>
    </svg>
  </div>

  <!-- Floating Gradient Orbs -->
  <div class="absolute inset-0 overflow-hidden pointer-events-none">
    <div class="absolute top-20 left-10 w-64 h-64 bg-purple-600/10 rounded-full blur-3xl animate-float"></div>
    <div class="absolute bottom-20 right-10 w-80 h-80 bg-blue-600/10 rounded-full blur-3xl animate-float-delayed"></div>
  </div>

  <div class="relative max-w-7xl mx-auto px-6 lg:px-8">

    <!-- Main Footer -->
    <div class="py-16 grid md:grid-cols-2 lg:grid-cols-5 gap-12">
      
      <!-- Brand -->
      <div class="md:col-span-2 lg:col-span-2 animate-fade-in">
        <a href="index" class="inline-block mb-6 group">
          <img src="https://www.vishakarex.in/assets/img/projects/d-remind.png" 
               class="w-40 transition-all duration-300 group-hover:scale-105 group-hover:brightness-110" alt="DRemind">
        </a>
        <p class="text-white/50 text-sm leading-relaxed mb-6 hover:text-white/70 transition-colors duration-300">
          Intelligent reminder system designed for modern teams. Automate your workflow and never miss important deadlines again.
        </p>

        <!-- Social Links -->
        <div class="space-y-3 mb-6">
          <p class="text-xs text-white/40 uppercase tracking-wider font-semibold flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
            </svg>
            Connect With Us
          </p>
          <div class="flex items-center gap-3">
            <!-- Facebook -->
            <a href="#" class="group relative w-10 h-10 bg-gradient-to-br from-white/10 to-white/5 hover:from-blue-600/30 hover:to-blue-700/20 border border-white/10 hover:border-blue-500/30 rounded-xl flex items-center justify-center transition-all duration-300 hover:scale-110 hover:-translate-y-1 hover:shadow-lg hover:shadow-blue-500/20">
              <svg class="w-4 h-4 text-white/70 group-hover:text-blue-400 transition-colors duration-300" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
              <span class="absolute -top-8 left-1/2 -translate-x-1/2 bg-gray-900 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity duration-300 whitespace-nowrap">Facebook</span>
            </a>
            
            <!-- Twitter -->
            <a href="#" class="group relative w-10 h-10 bg-gradient-to-br from-white/10 to-white/5 hover:from-sky-600/30 hover:to-sky-700/20 border border-white/10 hover:border-sky-500/30 rounded-xl flex items-center justify-center transition-all duration-300 hover:scale-110 hover:-translate-y-1 hover:shadow-lg hover:shadow-sky-500/20">
              <svg class="w-4 h-4 text-white/70 group-hover:text-sky-400 transition-colors duration-300" fill="currentColor" viewBox="0 0 24 24"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg>
              <span class="absolute -top-8 left-1/2 -translate-x-1/2 bg-gray-900 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity duration-300 whitespace-nowrap">Twitter</span>
            </a>
            
            <!-- Instagram -->
            <a href="#" class="group relative w-10 h-10 bg-gradient-to-br from-white/10 to-white/5 hover:from-pink-600/30 hover:to-purple-700/20 border border-white/10 hover:border-pink-500/30 rounded-xl flex items-center justify-center transition-all duration-300 hover:scale-110 hover:-translate-y-1 hover:shadow-lg hover:shadow-pink-500/20">
              <svg class="w-4 h-4 text-white/70 group-hover:text-pink-400 transition-colors duration-300" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
              <span class="absolute -top-8 left-1/2 -translate-x-1/2 bg-gray-900 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity duration-300 whitespace-nowrap">Instagram</span>
            </a>

            <!-- LinkedIn -->
            <a href="#" class="group relative w-10 h-10 bg-gradient-to-br from-white/10 to-white/5 hover:from-blue-700/30 hover:to-blue-800/20 border border-white/10 hover:border-blue-600/30 rounded-xl flex items-center justify-center transition-all duration-300 hover:scale-110 hover:-translate-y-1 hover:shadow-lg hover:shadow-blue-600/20">
              <svg class="w-4 h-4 text-white/70 group-hover:text-blue-500 transition-colors duration-300" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
              <span class="absolute -top-8 left-1/2 -translate-x-1/2 bg-gray-900 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity duration-300 whitespace-nowrap">LinkedIn</span>
            </a>
          </div>
        </div>
        
      </div>

      <!-- Quick Links -->
      <div class="animate-fade-in-up" style="animation-delay: 100ms;">
        <h4 class="text-white font-bold text-sm mb-6 flex items-center gap-2">
          Quick Links
        </h4>
        <ul class="space-y-4">
          <li>
            <a href="index" class="group text-sm text-white/50 hover:text-white transition-all duration-300 flex items-center gap-2">
              <svg class="w-4 h-4 opacity-0 group-hover:opacity-100 -ml-6 group-hover:ml-0 transition-all duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
              </svg>
              <span class="relative">
                Home
                <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-gradient-to-r from-purple-500 to-blue-500 group-hover:w-full transition-all duration-300"></span>
              </span>
            </a>
          </li>
          <li>
            <a href="about" class="group text-sm text-white/50 hover:text-white transition-all duration-300 flex items-center gap-2">
              <svg class="w-4 h-4 opacity-0 group-hover:opacity-100 -ml-6 group-hover:ml-0 transition-all duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
              </svg>
              <span class="relative">
                About Us
                <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-gradient-to-r from-purple-500 to-blue-500 group-hover:w-full transition-all duration-300"></span>
              </span>
            </a>
          </li>
          <li>
            <a href="contact" class="group text-sm text-white/50 hover:text-white transition-all duration-300 flex items-center gap-2">
              <svg class="w-4 h-4 opacity-0 group-hover:opacity-100 -ml-6 group-hover:ml-0 transition-all duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
              </svg>
              <span class="relative">
                Contact
                <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-gradient-to-r from-purple-500 to-blue-500 group-hover:w-full transition-all duration-300"></span>
              </span>
            </a>
          </li>
          <li>
            <a href="pricing" class="group text-sm text-white/50 hover:text-white transition-all duration-300 flex items-center gap-2">
              <svg class="w-4 h-4 opacity-0 group-hover:opacity-100 -ml-6 group-hover:ml-0 transition-all duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
              </svg>
              <span class="relative">
                Pricing
                <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-gradient-to-r from-purple-500 to-blue-500 group-hover:w-full transition-all duration-300"></span>
              </span>
            </a>
          </li>
        </ul>
      </div>

      <!-- Account -->
      <div class="animate-fade-in-up" style="animation-delay: 300ms;">
        <h4 class="text-white font-bold text-sm mb-6 flex items-center gap-2">
          Resources
        </h4>
        <ul class="space-y-4">
            <li>
            <a href="blog" class="group text-sm text-white/50 hover:text-white transition-all duration-300 flex items-center gap-2">
              <svg class="w-4 h-4 opacity-0 group-hover:opacity-100 -ml-6 group-hover:ml-0 transition-all duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
              </svg>
              <span class="relative">
                Blog
                <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-gradient-to-r from-blue-500 to-cyan-500 group-hover:w-full transition-all duration-300"></span>
              </span>
            </a>
          </li>
          <li>
            <a href="faq" class="group text-sm text-white/50 hover:text-white transition-all duration-300 flex items-center gap-2">
              <svg class="w-4 h-4 opacity-0 group-hover:opacity-100 -ml-6 group-hover:ml-0 transition-all duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
              </svg>
              <span class="relative">
                FAQ
                <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-gradient-to-r from-blue-500 to-cyan-500 group-hover:w-full transition-all duration-300"></span>
              </span>
            </a>
          </li>
            <li>
            <a href="privacy" class="group text-sm text-white/50 hover:text-white transition-all duration-300 flex items-center gap-2">
              <svg class="w-4 h-4 opacity-0 group-hover:opacity-100 -ml-6 group-hover:ml-0 transition-all duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
              </svg>
              <span class="relative">
                Privacy Policy
                <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-gradient-to-r from-orange-500 to-red-500 group-hover:w-full transition-all duration-300"></span>
              </span>
            </a>
          </li>
          <li>
            <a href="terms" class="group text-sm text-white/50 hover:text-white transition-all duration-300 flex items-center gap-2">
              <svg class="w-4 h-4 opacity-0 group-hover:opacity-100 -ml-6 group-hover:ml-0 transition-all duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
              </svg>
              <span class="relative">
                Terms & Conditions
                <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-gradient-to-r from-orange-500 to-red-500 group-hover:w-full transition-all duration-300"></span>
              </span>
            </a>
          </li>
        </ul>
      </div>

      <!-- Contact / Address -->
        <div class="animate-fade-in-up" style="animation-delay: 400ms;">
            <h4 class="text-white font-bold text-sm mb-6 flex items-center gap-2">
                Contact
            </h4>

            <ul class="space-y-4">

                <!-- Address -->
                <li class="flex items-start gap-3 text-sm text-white/50 hover:text-white transition">
                <i class="ri-map-pin-line text-orange-400 text-base"></i>
                <span>
                    123, Business Street,<br>
                    Chennai, Tamil Nadu,<br>
                    India - 600001
                </span>
                </li>

                <!-- Email -->
                <li class="flex items-center gap-3 text-sm text-white/50 hover:text-white transition">
                <svg class="w-4 h-4 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8m0 0v8a2 2 0 01-2 2H5a2 2 0 01-2-2V8z"/>
                </svg>
                <a href="mailto:info@dremind.com" class="hover:underline">
                    info@dremind.com
                </a>
                </li>

                <!-- Phone -->
                <li class="flex items-center gap-3 text-sm text-white/50 hover:text-white transition">
                <svg class="w-4 h-4 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                    d="M3 5h2l3 7-1.5 2a11 11 0 005 5L14 17l7 3v2a2 2 0 01-2 2A19 19 0 013 7a2 2 0 012-2z"/>
                </svg>
                <a href="tel:+919876543210" class="hover:underline">
                    +91 98765 43210
                </a>
                </li>

            </ul>
        </div>

    </div>

    <!-- Bottom Bar -->
    <div class="border-t border-white/5 py-8 animate-fade-in" style="animation-delay: 500ms;">
      <div class="flex flex-col lg:flex-row justify-center items-center gap-6">

        <!-- Copyright -->
        <div class="text-xs text-white/30 order-2 lg:order-1 text-center lg:text-left hover:text-white/50 transition-colors duration-300 flex items-center gap-2">
          &copy; 2026 Winngoo DRemind. All rights reserved.
        </div>
      </div>
    </div>

  </div>
</footer>

<style>
/* Floating Animation */
@keyframes float {
  0%, 100% { transform: translateY(0px) translateX(0px); }
  50% { transform: translateY(-20px) translateX(10px); }
}

@keyframes float-delayed {
  0%, 100% { transform: translateY(0px) translateX(0px); }
  50% { transform: translateY(-30px) translateX(-15px); }
}

.animate-float {
  animation: float 8s ease-in-out infinite;
}

.animate-float-delayed {
  animation: float-delayed 10s ease-in-out infinite;
}

/* Fade In Animation */
@keyframes fadeIn {
  from {
    opacity: 0;
    transform: translateY(20px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.animate-fade-in {
  animation: fadeIn 0.8s ease-out forwards;
}

.animate-fade-in-up {
  animation: fadeIn 0.8s ease-out forwards;
  opacity: 0;
}

/* Pulse glow effect for social icons */
@keyframes pulse-glow {
  0%, 100% {
    box-shadow: 0 0 0 0 rgba(139, 92, 246, 0);
  }
  50% {
    box-shadow: 0 0 20px 2px rgba(139, 92, 246, 0.3);
  }
}
</style>