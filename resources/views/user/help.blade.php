@extends('user.layouts.app')
@section('content')

<section id="page-help" class="">
    <div style="margin-bottom:16px">
        <h2 class="font-jakarta" style="font-size:1.3rem;font-weight:800;color:#f1f5f9">How Can We Help?</h2>
        <p style="font-size:.82rem;color:#64748b;margin-top:3px">Find answers, guides, and support resources</p>
    </div>
    <div class="card" style="padding:14px;margin-bottom:20px">
        <div class="search-box"><i class="ri-search-line" style="color:#64748b"></i><input id="help-search" placeholder="Search help articles, FAQs…" oninput="filterFaq(this.value)" style="font-size:.87rem;color:inherit"></div>
    </div>
    <div class="g4" style="margin-bottom:24px">
        <div class="help-card" onclick="document.querySelector('.faq-item .faq-q').click()">
            <div style="width:52px;height:52px;border-radius:14px;background:rgba(20,184,166,.12);display:flex;align-items:center;justify-content:center;margin:0 auto 10px"><i class="ri-rocket-line" style="color:#2dd4bf;font-size:1.4rem"></i></div>
            <div class="font-jakarta" style="font-weight:700;font-size:.87rem;color:#f1f5f9;margin-bottom:4px">Getting Started</div>
            <div style="font-size:.77rem;color:#64748b;margin-bottom:12px">Learn the basics of D-Remind</div><button class="btn btn-primary btn-sm">Start Tutorial</button>
        </div>
        <div class="help-card" onclick="openModal('support-modal')">
            <div style="width:52px;height:52px;border-radius:14px;background:rgba(124,58,237,.15);display:flex;align-items:center;justify-content:center;margin:0 auto 10px"><i class="ri-customer-service-2-line" style="color:#a78bfa;font-size:1.4rem"></i></div>
            <div class="font-jakarta" style="font-weight:700;font-size:.87rem;color:#f1f5f9;margin-bottom:4px">Contact Support</div>
            <div style="font-size:.77rem;color:#64748b;margin-bottom:12px">Get personalized help</div><button class="btn btn-primary btn-sm">Contact Us</button>
        </div>
        <div class="help-card" onclick="toast('User guide downloading…','info')">
            <div style="width:52px;height:52px;border-radius:14px;background:rgba(16,185,129,.12);display:flex;align-items:center;justify-content:center;margin:0 auto 10px"><i class="ri-book-3-line" style="color:#10b981;font-size:1.4rem"></i></div>
            <div class="font-jakarta" style="font-weight:700;font-size:.87rem;color:#f1f5f9;margin-bottom:4px">User Guides</div>
            <div style="font-size:.77rem;color:#64748b;margin-bottom:12px">Download comprehensive guides</div><button class="btn btn-primary btn-sm">Download PDF</button>
        </div>
        <div class="help-card" onclick="go('feedback')">
            <div style="width:52px;height:52px;border-radius:14px;background:rgba(245,158,11,.12);display:flex;align-items:center;justify-content:center;margin:0 auto 10px"><i class="ri-feedback-line" style="color:#f59e0b;font-size:1.4rem"></i></div>
            <div class="font-jakarta" style="font-weight:700;font-size:.87rem;color:#f1f5f9;margin-bottom:4px">Send Feedback</div>
            <div style="font-size:.77rem;color:#64748b;margin-bottom:12px">Help us improve D-Remind</div><button class="btn btn-primary btn-sm">Give Feedback</button>
        </div>
    </div>
    <div class="card" style="padding:18px;margin-bottom:16px">
        <h3 class="font-jakarta" style="font-weight:700;font-size:.87rem;color:#f1f5f9;margin-bottom:14px">Frequently Asked Questions</h3>
        <div id="faq-container" style="display:flex;flex-direction:column;gap:0"></div>
    </div>
    <div class="g2">
        <div class="card" style="padding:18px;text-align:center"><i class="ri-mail-line" style="font-size:2.2rem;color:rgba(45,212,191,.4);display:block;margin-bottom:8px"></i>
            <div class="font-jakarta" style="font-weight:700;font-size:.87rem;color:#f1f5f9;margin-bottom:4px">Email Support</div>
            <div style="font-size:.77rem;color:#64748b;margin-bottom:8px">Get help from our team</div><a href="mailto:support@winngoodremind.co.uk" style="font-size:.84rem;color:#a78bfa;font-weight:600;text-decoration:none">support@winngoodremind.co.uk</a>
        </div>
        <div class="card" style="padding:18px;text-align:center"><i class="ri-time-line" style="font-size:2.2rem;color:rgba(16,185,129,.4);display:block;margin-bottom:8px"></i>
            <div class="font-jakarta" style="font-weight:700;font-size:.87rem;color:#f1f5f9;margin-bottom:4px">Response Time</div>
            <div style="font-size:.77rem;color:#64748b;margin-bottom:8px">Average response time</div>
            <div class="font-jakarta" style="font-size:1.3rem;font-weight:800;color:#10b981">Within 24 Hours</div>
        </div>
    </div>
</section>

@endsection
