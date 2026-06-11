<nav class="nav" id="mainNav">
  <div class="max-w-7xl mx-auto px-6 lg:px-8">
    <div class="flex items-center justify-between h-[76px]">
      <a href="{{route('index')}}" class="flex items-center gap-3 z-20"><img src="https://www.vishakarex.in/assets/img/projects/d-remind.png" class="w-[160px]" alt="DRemind"></a>
      <div class="hidden md:flex items-center gap-1 nav-desktop">
        <a href="{{route('index')}}" class="nav-link" data-page="index">Home</a>
        <a href="{{route('about')}}" class="nav-link" data-page="about">About</a>
        <!-- <a href="category" class="nav-link" data-page="category">Category</a> -->
        <a href="{{route('faq.page')}}" class="nav-link" data-page="faq">FAQ</a>
        <a href="{{route('pricing.page')}}" class="nav-link" data-page="pricing">Pricing</a>
        <a href="{{route('blog.page')}}" class="nav-link" data-page="blog">Blog</a>
        <a href="{{route('contact')}}" class="nav-link" data-page="contact">Contact</a>
      </div>
      <div class="hidden md:flex items-center gap-3 nav-cta-desktop z-20">

        @if(Auth::guard('admin')->check())
        <a href="{{ route('admin.dashboard') }}" class="btn-primary text-sm !py-[11px] !px-6">
          <i class="ri-dashboard-line text-base"></i>
          Admin Dashboard
        </a>

        @elseif(Auth::guard('web')->check())
        <a href="{{ route('user.dashboard') }}" class="btn-primary text-sm !py-[11px] !px-6">
          <i class="ri-dashboard-line text-base"></i>
          User Dashboard
        </a>

        @else
        <a href="{{ route('loginpage') }}" class="nav-link" data-page="login">
          Login
        </a>

        <a href="{{ route('registerpage') }}" class="btn-primary text-sm !py-[11px] !px-6">
          <i class="ri-user-add-line text-base"></i>
          Register
        </a>
        @endif

      </div>
      <button id="mobToggle" class="mob-toggle-btn w-10 h-10 flex flex-col items-center justify-center gap-1.5 rounded-xl border border-white/10 z-20">
        <span class="w-5 h-[1.5px] bg-white/70 rounded transition-all"></span><span class="w-5 h-[1.5px] bg-white/70 rounded transition-all"></span><span class="w-3.5 h-[1.5px] bg-white/70 rounded transition-all"></span>
      </button>
    </div>
    <div class="mob-menu" id="mobMenu">
      <div class="pb-6 pt-2 flex flex-col gap-1 px-2">
    <a href="{{ route('index') }}" class="nav-link block !text-base">Home</a>
    <a href="{{ route('about') }}" class="nav-link block !text-base">About</a>
    <a href="{{ route('category') }}" class="nav-link block !text-base">Category</a>
    <a href="{{ route('faq.page') }}" class="nav-link block !text-base">FAQ</a>
    <a href="{{ route('contact') }}" class="nav-link block !text-base">Contact</a>

    @if(Auth::guard('admin')->check())
        <a href="{{ route('admin.dashboard') }}" class="btn-primary text-center mt-2">
            Admin Dashboard
        </a>

    @elseif(Auth::guard('web')->check())
        <a href="{{ route('user.dashboard') }}" class="btn-primary text-center mt-2">
            User Dashboard
        </a>

    @else
        <a href="{{ route('loginpage') }}" class="nav-link block !text-base">
            Login
        </a>

        <a href="{{ route('registerpage') }}" class="btn-primary text-center mt-2">
            Register
        </a>
    @endif
</div>
    </div>
  </div>
</nav>