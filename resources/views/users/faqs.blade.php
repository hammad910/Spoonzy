@extends('layouts.app')

@section('title')
    {{ trans('general.faqs') }} -
@endsection

<style>
    .faq-section {
        max-width: 900px;
        margin: auto;
    }

    .faq-item {
        border-bottom: 1px solid #eee;
        padding: 20px 0;
        cursor: pointer;
    }

    .faq-title {
        font-size: 16px;
        font-weight: 600;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .faq-title svg {
        transition: 0.3s ease;
    }

    .faq-item .collapse.show+.faq-title svg {
        transform: rotate(45deg);
    }

    .faq-content {
        color: #777;
        padding-top: 10px;
        font-size: 14px;
    }
</style>

@section('content')
    <section class="section section-sm d-flex">
        <div class="menu-sidebar d-none d-lg-block" style="width: 20%; border-right: 1px solid #ddd; padding: 20px;">
            @include('includes.menu-sidebar-home')
        </div>
        <div class="container" style="background: #FBFBFB;">
            <div class="row justify-content-center text-center mb-sm">
                <div class="col-lg-8 py-5">
                    <h2 class="mb-0 font-montserrat">
                        {{ trans('general.faqs') }}</h2>
                </div>
            </div>
            <div class="row">

                @include('includes.cards-settings')
                
                <div class="col-md-6 col-lg-9 mb-5 mb-lg-0">
                    <div class="faq-section">
    
                        <h3 class="mb-2">FAQs</h3>
                        <p class="text-muted mb-4">
                            Everything you need to know about the product and billing. Can’t find what you’re looking for?
                            <a href="#">Chat to our friendly team.</a>
                        </p>
    
                        <div id="faqList">
    
                            <!-- FAQ 1 -->
                            <div class="faq-item" data-bs-toggle="collapse" data-bs-target="#faq1">
                                <div class="faq-title">
                                    <span>Is there a free trial available?</span>
                                    <svg width="20" height="20" viewBox="0 0 24 24">
                                        <path d="M12 5v14M5 12h14" stroke="currentColor" stroke-width="2" fill="none" />
                                    </svg>
                                </div>
                                <div id="faq1" class="collapse">
                                    <div class="faq-content">
                                        Yes, you can try us for free for 30 days. If you want, we’ll provide you with a free,
                                        personalized 30-minute onboarding call to get you up and running as soon as possible.
                                    </div>
                                </div>
                            </div>
    
                            <!-- FAQ 2 -->
                            <div class="faq-item" data-bs-toggle="collapse" data-bs-target="#faq2">
                                <div class="faq-title">
                                    <span>Can I change my plan later?</span>
                                    <svg width="20" height="20" viewBox="0 0 24 24">
                                        <path d="M12 5v14M5 12h14" stroke="currentColor" stroke-width="2" fill="none" />
                                    </svg>
                                </div>
                                <div id="faq2" class="collapse">
                                    <div class="faq-content">
                                        Yes. You can switch plans any time directly from your account dashboard.
                                    </div>
                                </div>
                            </div>
    
                            <!-- FAQ 3 -->
                            <div class="faq-item" data-bs-toggle="collapse" data-bs-target="#faq3">
                                <div class="faq-title">
                                    <span>What is your cancellation policy?</span>
                                    <svg width="20" height="20" viewBox="0 0 24 24">
                                        <path d="M12 5v14M5 12h14" stroke="currentColor" stroke-width="2" fill="none" />
                                    </svg>
                                </div>
                                <div id="faq3" class="collapse">
                                    <div class="faq-content">
                                        You can cancel anytime before the billing date, no hidden conditions.
                                    </div>
                                </div>
                            </div>
    
                            <!-- Continue adding more if you want -->
    
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>