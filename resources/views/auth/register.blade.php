@extends('layouts.app')

@section('title')
    {{ __('auth.sign_up') }} -
@endsection

@section('content')
    <style>
        .login-container {
            display: flex;
            min-height: 100vh;
        }

        .login-left {
            flex: 1;
            background: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px;
        }

        .login-right {
            flex: 1;
            background: url('/images/signup-img.jpg') no-repeat center center;
            background-size: cover;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: flex-start;
            min-height: 100vh;
            position: relative;
            border-top-left-radius: 80px;
            border-bottom-left-radius: 80px;
            overflow: hidden;
        }

        .login-right::after {
            content: "";
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, 0.4);
        }

        .testimonial {
            position: relative;
            color: white;
            max-width: 100%;
            z-index: 1;
            padding: 0 50px;
            top: 130px;
        }

        .testimonial h4 {
            font-size: 48px;
            line-height: 1.3;
            font-weight: 500 !important;
            margin-bottom: 30px;
        }

        .testimonial h5 {
            font-weight: 600;
            margin-top: 15px;
            font-size: 30px;
            margin-bottom: 0;
        }

        .testimonial p {
            opacity: 0.9;
            margin-bottom: 5px;
            font-size: 14px;
        }

        .testimonial-bottom {
            position: relative;
            top: 190px;
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            width: 60%
        }

        /* Arrow Navigation Styles - Now on left side */
        .testimonial-nav {
            display: flex;
            gap: 12px;
            justify-content: end;
            margin-top: 130px;
        }

        .nav-arrow {
            background: transparent;
            border: 1px solid #FFFFFF80;
            border-radius: 50%;
            color: white;
            width: 44px;
            height: 44px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 18px;
        }

        .nav-arrow:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: scale(1.05);
        }

        .nav-arrow:disabled {
            opacity: 0.4;
            cursor: not-allowed;
            transform: none;
        }

        /* Testimonial slider styles */
        .testimonial-slide {
            display: none;
        }

        .testimonial-slide.active {
            display: block;
        }

        /* Author info container */
        .author-info {
            flex: 1;
        }

        /* Laptop / smaller desktops (but still >=992px) */
        @media (max-width: 1200px) {
            .testimonial-bottom {
                top: 80px;
            }
        }

        @media (max-width: 768px) {
            .login-right {
                border-top-left-radius: 40px;
                border-top-right-radius: 40px;
                border-bottom-left-radius: 0;
                border-bottom-right-radius: 0;
            }
        }

        @media (max-width: 992px) {
            .login-right {
                display: none;
            }
        }

        .login-box {
            width: 100%;
            max-width: 380px;
        }

        .logo {
            display: flex;
            align-items: center;
            margin-bottom: 30px;
        }

        .logo img {
            height: 75px;
            width: 75px;
            margin-right: 10px;
        }

        .btn-signup {
            background-color: #469DFA;
            color: #fff;
            width: 100%;
            border-radius: 8px;
            padding: 10px;
            font-weight: 500;
            border: none;
        }

        .btn-google,
        .btn-facebook,
        .btn-twitter {
            border: 1px solid #ddd;
            background: #fff;
            width: 100%;
            border-radius: 8px;
            padding: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 500;
            margin-bottom: 10px;
            transition: all 0.3s ease;
        }

        .btn-google:hover,
        .btn-facebook:hover,
        .btn-twitter:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .btn-google img,
        .btn-facebook img,
        .btn-twitter img {
            height: 18px;
            margin-right: 8px;
        }

        .btn-facebook {
            background: #1877f2;
            color: white;
            border: none;
        }

        .btn-twitter {
            background: #000;
            color: white;
            border: none;
        }

        .or-divider {
            display: flex;
            align-items: center;
            margin: 20px 0;
            color: #6c757d;
        }

        .or-divider::before,
        .or-divider::after {
            content: "";
            flex: 1;
            border-bottom: 1px solid #dee2e6;
        }

        .or-divider span {
            padding: 0 15px;
            font-size: 14px;
            font-weight: 500;
        }

        .password-input-group {
            position: relative;
        }

        .toggle-password {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            color: #6c757d;
        }

        .alert {
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .form-check-input {
            margin-right: 8px;
        }

        .terms-checkbox {
            margin: 20px 0;
        }

        .terms-checkbox .form-check-label {
            font-size: 0.875rem;
        }

        .terms-checkbox a {
            color: #469DFA;
            text-decoration: none;
        }

        .terms-checkbox a:hover {
            text-decoration: underline;
        }

        @media (max-width: 992px) {
            .login-container {
                flex-direction: column;
            }

            .login-right {
                display: none;
            }
        }

        /* Remove all default select arrows */
.custom-select-no-arrow {
    appearance: none !important;
    -webkit-appearance: none !important;
    -moz-appearance: none !important;
    background-image: none !important;
    padding-right: 38px !important; /* space for icon */
}

/* Icon positioning */
.select-wrapper .select-icon {
    position: absolute;
    right: 12px;
    top: 50%;
    transform: translateY(-50%);
    pointer-events: none; /* keep select clickable */
    color: #666;
}

    </style>

    <div class="login-container">
        <!-- Left Section -->
        <div class="login-left">
            <div class="login-box">
                <div class="logo">
                    <img src="/images/login-logo.png" alt="LabVlog logo" style="border-radius: 20px">
                </div>

                <h3 class="fw-semibold mb-2" style="color: #101828; font-size: 36px;">{{ __('auth.sign_up') }}</h3>
                <p class="text-muted mb-4" style="color: #475467; font-size: 16px;">{{ __('auth.signup_welcome') }}</p>

                <!-- Display Alert Messages -->
                @if (session('status'))
                    <div class="alert alert-success" id="successAlert">
                        {{ session('status') }}
                    </div>
                @endif

                <!-- Display Form Errors -->
                @include('errors.errors-forms')

                <!-- Social Login Buttons -->
                @if ($settings->facebook_login == 'on' || $settings->google_login == 'on' || $settings->twitter_login == 'on')
                    <div class="social-login-buttons mb-3">
                        @if ($settings->facebook_login == 'on')
                            <a href="{{ url('oauth/facebook') }}" class="btn btn-facebook">
                                <i class="fab fa-facebook mr-2"></i> {{ __('auth.sign_up_with') }} Facebook
                            </a>
                        @endif

                        @if ($settings->twitter_login == 'on')
                            <a href="{{ url('oauth/twitter') }}" class="btn btn-twitter">
                                <i class="fab fa-twitter mr-2"></i> {{ __('auth.sign_up_with') }} X
                            </a>
                        @endif

                        @if ($settings->google_login == 'on')
                            <a href="{{ url('oauth/google') }}" class="btn btn-google">
                                <img src="{{ asset('img/google.svg') }}" alt="Google" class="mr-2">
                                {{ __('auth.sign_up_with') }} Google
                            </a>
                        @endif
                    </div>

                    @if (!$settings->disable_login_register_email)
                        <div class="or-divider">
                            <span>{{ __('general.or') }}</span>
                        </div>
                    @endif
                @endif

                <!-- Signup Form -->
                @if (!$settings->disable_login_register_email)
                    <form method="POST" action="{{ route('register') }}" id="formLoginRegister">
                        @csrf

                        {{-- <div class="mb-3">
                            <label class="form-label">{{__('auth.full_name')}}</label>
                            <input type="text" 
                                   name="name" 
                                   class="form-control @error('name') is-invalid @enderror" 
                                   placeholder="{{__('auth.full_name')}}" 
                                   value="{{ old('name')}}" 
                                   required>
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div> --}}

                        <div class="mb-3">
                            <label class="form-label">{{ __('auth.email') }}</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                placeholder="{{ __('auth.email') }}" value="{{ old('email') }}" required>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="mb-3 position-relative">
                            <label class="form-label">User Role</label>
                        
                            <div class="select-wrapper position-relative">
                                <select name="role" id="userRole" class="form-control custom-select-no-arrow">
                                    <option value="subscriber" selected>Subscriber</option>
                                    <option value="creator">Creator</option>
                                </select>
                        
                                <!-- Feather icon -->
                                <img src="/svg/chevron-svg.svg" class="select-icon" alt="">
                            </div>
                        </div>
                        

                        <div class="mb-3">
                            <label class="form-label">{{ __('auth.password') }}</label>
                            <div class="password-input-group">
                                <input type="password" name="password" id="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    placeholder="{{ __('auth.password') }}" required>
                                <button type="button" class="toggle-password" id="togglePassword">
                                    <i class="feather icon-eye-off"></i>
                                </button>
                            </div>
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="terms-checkbox">
                            <div class="form-check">
                                <input class="form-check-input @error('agree_gdpr') is-invalid @enderror"
                                    id="customCheckRegister" type="checkbox" name="agree_gdpr" required>
                                <label class="form-check-label" for="customCheckRegister">
                                    <span>
                                        {{-- {{ __('admin.i_agree_gdpr') }}
                                        <a href="{{ $settings->link_terms }}"
                                            target="_blank">{{ __('admin.terms_conditions') }}</a>
                                        {{ __('general.and') }}
                                        <a href="{{ $settings->link_privacy }}"
                                            target="_blank">{{ __('admin.privacy_policy') }}</a> --}}
                                        Remember for 30 days
                                    </span>
                                </label>
                                @error('agree_gdpr')
                                    <div class="invalid-feedback d-block">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <!-- Error Display Container -->
                        <div class="alert alert-danger display-none mb-0 mt-3" id="errorLogin">
                            <ul class="list-unstyled m-0" id="showErrorsLogin"></ul>
                        </div>

                        <!-- Success Message Container -->
                        <div class="alert alert-success mb-0 mt-3 display-none" id="checkAccount"></div>

                        <div class="text-center">
                            @if ($settings->captcha == 'on')
                                {!! NoCaptcha::displaySubmit('formLoginRegister', '<i></i> ' . __('auth.sign_up'), [
                                    'data-size' => 'invisible',
                                    'id' => 'btnLoginRegister',
                                    'class' => 'btn btn-signup mb-3',
                                ]) !!}
                                {!! NoCaptcha::renderJs() !!}
                            @else
                                <button type="submit" class="btn btn-signup mb-3" id="btnLoginRegister">
                                    <i></i> {{ __('auth.sign_up') }}
                                </button>
                            @endif
                        </div>

                        @if ($settings->captcha == 'on')
                            <small class="btn-block text-center mt-3">{{ __('auth.protected_recaptcha') }}
                                <a href="https://policies.google.com/privacy"
                                    target="_blank">{{ __('general.privacy') }}</a> -
                                <a href="https://policies.google.com/terms" target="_blank">{{ __('general.terms') }}</a>
                            </small>
                        @endif
                    </form>
                @endif

                <!-- Login Link -->
                <p class="text-center text-muted mt-3">
                    {{ __('auth.already_have_an_account') }}
                    <a href="{{ url('login') }}" class="text-decoration-none" style="color: #469DFA;">
                        {{ __('auth.login') }}
                    </a>
                </p>
            </div>
        </div>

        <!-- Right Section -->
        <div class="login-right d-none d-md-flex flex-column justify-content-center align-items-center">
            <div class="testimonial text-white">
                <!-- Testimonial 1 -->
                <div class="testimonial-slide active">
                    <h4 style="font-size: 48px; line-height: 1.3; font-weight: 500 !important;">
                        “We've been using LabVlog to kick start every new project and can't imagine working without it.”
                    </h4>
                    <div class="testimonial-bottom">
                        <div class="author-info">
                            <h5 class="mt-3 mb-0 text-white" style="font-size: 30px;">Olivia Rhye</h5>
                            <p class="text-white mb-0">
                                Lead Designer, Layers<br>Web Development Agency
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Testimonial 2 -->
                <div class="testimonial-slide">
                    <h4 style="font-size: 48px; line-height: 1.3; font-weight: 500 !important;">
                        “LabVlog has completely transformed our workflow. The collaboration features are exceptional!.”
                    </h4>
                    <div class="testimonial-bottom">
                        <div class="author-info">
                            <h5 class="mt-3 mb-0 text-white" style="font-size: 30px;">Michael Chen</h5>
                            <p class="text-white mb-0">
                                CTO, TechSolutions Inc.<br>Software Development
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Testimonial 3 -->
                <div class="testimonial-slide">
                    <h4 style="font-size: 48px; line-height: 1.3; font-weight: 500 !important;">
                        “As a startup founder, LabVlog gave us the competitive edge we needed to scale rapidly.”
                    </h4>
                    <div class="testimonial-bottom">
                        <div class="author-info">
                            <h5 class="mt-3 mb-0 text-white" style="font-size: 30px;">Sarah Johnson</h5>
                            <p class="text-white mb-0">
                                Founder & CEO, InnovateCo<br>Startup Consulting
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Navigation Arrows - MOVED OUTSIDE ALL SLIDES (SINGLE INSTANCE) -->
                <div class="testimonial-nav">
                    <button class="nav-arrow" id="prevTestimonial">
                        <img src="/svg/left-icon.svg" alt="">
                    </button>
                    <button class="nav-arrow" id="nextTestimonial">
                        <img src="/svg/right-icon.svg" alt="">
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Password toggle functionality
        document.addEventListener('DOMContentLoaded', function() {
            const togglePassword = document.querySelector('#togglePassword');
            const password = document.querySelector('#password');

            if (togglePassword && password) {
                togglePassword.addEventListener('click', function() {
                    const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
                    password.setAttribute('type', type);

                    const icon = this.querySelector('i');
                    if (type === 'password') {
                        icon.className = 'feather icon-eye-off';
                    } else {
                        icon.className = 'feather icon-eye';
                    }
                });
            }

            // Form submission handling for error display
            const form = document.getElementById('formLoginRegister');
            if (form) {
                form.addEventListener('submit', function() {
                    const btn = document.getElementById('btnLoginRegister');
                    if (btn) {
                        btn.disabled = true;
                        btn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> ' + btn.textContent;

                        // Re-enable button after 3 seconds if still disabled (fallback)
                        setTimeout(() => {
                            if (btn.disabled) {
                                btn.disabled = false;
                                btn.innerHTML = '<i></i> {{ __('auth.sign_up') }}';
                            }
                        }, 3000);
                    }
                });
            }

            const slides = document.querySelectorAll('.testimonial-slide');
            const prevBtn = document.getElementById('prevTestimonial');
            const nextBtn = document.getElementById('nextTestimonial');
            let currentSlide = 0;

            function showSlide(index) {
                // Hide all slides
                slides.forEach(slide => slide.classList.remove('active'));

                // Show current slide
                slides[index].classList.add('active');

                // Update button states
                prevBtn.disabled = index === 0;
                nextBtn.disabled = index === slides.length - 1;
            }

            // Next testimonial
            nextBtn.addEventListener('click', function() {
                if (currentSlide < slides.length - 1) {
                    currentSlide++;
                    showSlide(currentSlide);
                }
            });

            // Previous testimonial
            prevBtn.addEventListener('click', function() {
                if (currentSlide > 0) {
                    currentSlide--;
                    showSlide(currentSlide);
                }
            });

            // Pause auto-advance on hover
            const testimonialContainer = document.querySelector('.testimonial');
            testimonialContainer.addEventListener('mouseenter', () => {
                clearInterval(slideInterval);
            });

            showSlide(currentSlide);
        });
    </script>
@endsection
