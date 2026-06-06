
@extends('layouts.app')
@section('content')

<script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            primary:'#7c3aed',
            secondary:'#06b6d4',
            accent:'#10b981',
            dark:'#030014',
            surface:'#0a0a1f',
            card:'#0f0f2a',
          },
          fontFamily:{sans:['Inter','system-ui','sans-serif']}
        }
      }
    }
  </script>

<section class="page-hero-dark section-alt relative" data-particles="purple" data-p-count="40" data-p-connect="false">
  <div class="gradient-blob w-[460px] h-[460px] bg-primary top-[-18%] left-[15%]"></div>
  <div class="max-w-[840px] mx-auto px-6 relative z-10">
    <div class="page-breadcrumb">
      <a href="index">Home</a><span class="sep">/</span><span>Legal</span>
    </div>
    <div class="badge bg-primary/10 border border-primary/20 text-purple-300 mx-auto mb-6 w-fit reveal">
      <span class="w-2 h-2 rounded-full bg-primary animate-pulse"></span> Terms &amp; Conditions
    </div>
    <h1 class="reveal"> {{ $terms->title }}</span></h1>
    <p class="reveal" data-delay="1">
      We take privacy and security seriously. Review the key policies that govern how DRemind works.
    </p>
  </div>
</section>

<section class="relative py-16 md:py-20 section-dark overflow-hidden">
    <div class="max-w-100 mx-auto px-6 lg:px-40">
        <div class="legal-tab-dark">

            <h1 class="text-3xl font-bold mb-6">
                {{ $terms->title }}
            </h1>

            {!! $terms->content !!}

        </div>
    </div>
</section>

<script src="{{ asset('assets/js/distortion.js') }}"></script>

<script src="{{ asset('assets/js/script.js') }}"></script>
@endsection
