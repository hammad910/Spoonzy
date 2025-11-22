@extends('layouts.app')

@section('title', __('auth.login'))

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
            background: url('/images/login-img.jpg') no-repeat center center;
            background-size: cover;
            color: #fff;
            display: flex;
            flex-direction: column;
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
            width: 100%;
            z-index: 1;
            padding: 50px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            height: 100%;
            box-sizing: border-box;
        }

        .testimonial-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .testimonial-slide {
            display: none;
        }

        .testimonial-slide.active {
            display: block;
        }

        .testimonial-slide h4 {
            font-size: 32px;
            line-height: 1.4;
            font-weight: 500 !important;
            /* margin-bottom: 30px; */
            text-align: left;
        }

        .author-info {
            text-align: left;
            /* margin-top: 20px; */
        }

        .author-info h5 {
            font-weight: 600;
            font-size: 20px;
            margin-bottom: 5px;
        }

        .author-info p {
            opacity: 0.85;
            font-size: 13px;
            line-height: 1.4;
            margin: 0;
        }

        /* Arrow Navigation Styles */
        .testimonial-bottom {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            /* padding-top: 20px; */
        }

        .testimonial-nav {
            display: flex;
            gap: 12px;
        }

        .nav-arrow {
            background: transparent;
            border: 1px solid rgba(255, 255, 255, 0.5);
            color: white;
            width: 44px;
            height: 44px;
            border-radius: 50%;
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

        @media (max-width: 1200px) {
            .testimonial-slide h4 {
                font-size: 30px;
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

        .btn-login {
            background-color: #007bff;
            color: #fff;
            width: 100%;
            border-radius: 8px;
            padding: 10px;
            font-weight: 500;
            border: none;
        }

        .btn-google, .btn-facebook, .btn-twitter {
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

        .btn-google:hover, .btn-facebook:hover, .btn-twitter:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }

        .btn-google img, .btn-facebook img, .btn-twitter img {
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

        @media (max-width: 992px) {
            .login-container {
                flex-direction: column;
            }

            .login-right {
                display: none;
            }
        }
    </style>

    <div class="login-container">
        <!-- Left Section -->
        <div class="login-left">
            <div class="login-box">
                <div class="logo">
                    <img src="/images/login-logo.png" alt="LabVlog logo" style="border-radius: 20px">
                </div>

                <h3 class="fw-semibold mb-2" style="color: #101828; font-size: 36px;">Log in</h3>
                <p class="text-muted mb-4" style="color: #475467; font-size: 16px;">Welcome back! Please enter your details.</p>

                <!-- Display Alert Messages -->
                @if (session('login_required'))
                    <div class="alert alert-danger" id="dangerAlert">
                        <i class="fa fa-exclamation-triangle"></i> {{ session('login_required') }}
                    </div>
                @endif

                @if (session('error_social_login'))
                    <div class="alert alert-danger" id="dangerAlert">
                        <i class="fa fa-exclamation-triangle"></i> {{ __('general.error') }} "{{ session('error_social_login') }}"
                    </div>
                @endif

                <!-- Display Form Errors -->
                @include('errors.errors-forms')

                <!-- Login Form -->
                @if (!$settings->disable_login_register_email || request()->route()->named('login.admin'))
                    <form method="POST" action="{{ route('login') }}" id="formLoginRegister" enctype="multipart/form-data">
                        @csrf

                        <input type="hidden" name="return" value="{{ count($errors) > 0 ? old('return') : url()->previous() }}">

                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="text" 
                                   name="username_email" 
                                   class="form-control @error('username_email') is-invalid @enderror" 
                                   placeholder="Enter your email" 
                                   value="{{ old('username_email') }}" 
                                   required>
                            @error('username_email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">{{ __('auth.password') }}</label>
                            <div class="password-input-group">
                                <input type="password" 
                                       name="password" 
                                       id="password"
                                       class="form-control @error('password') is-invalid @enderror" 
                                       placeholder="••••••••" 
                                       required>
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

                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="form-check">
                                <input class="form-check-input" 
                                       type="checkbox" 
                                       name="remember" 
                                       id="remember" 
                                       {{ old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label" for="remember">
                                    Remember for 30 days
                                </label>
                            </div>
                            <a href="{{ url('password/reset') }}" class="text-decoration-none" style="color: #469DFA;">
                                Forgot password
                            </a>
                        </div>

                        <!-- Error Display Container -->
                        <div class="alert alert-danger display-none mb-0 mt-3" id="errorLogin">
                            <ul class="list-unstyled m-0" id="showErrorsLogin"></ul>
                        </div>

                        <div class="text-center">
                            @if ($settings->captcha == 'on')
                                {!! NoCaptcha::displaySubmit('formLoginRegister', '<i></i> '.__('auth.login'), ['data-size' => 'invisible', 'id' => 'btnLoginRegister', 'class' => 'btn btn-login mb-3', 'style' => 'background-color: #469DFA']) !!}
                                {!! NoCaptcha::renderJs() !!}
                            @else
                                <button id="btnLoginRegister" type="submit" class="btn btn-login mb-3" style="background-color: #469DFA">
                                    <i></i> Log in
                                </button>
                            @endif
                        </div>

                        @if ($settings->captcha == 'on')
                            <small class="btn-block text-center mt-3">{{ __('auth.protected_recaptcha') }} 
                                <a href="https://policies.google.com/privacy" target="_blank">{{ __('general.privacy') }}</a> - 
                                <a href="https://policies.google.com/terms" target="_blank">{{ __('general.terms') }}</a>
                            </small>
                        @endif
                    </form>
                @endif

                <!-- Social Login Buttons -->
                @if ($settings->facebook_login == 'on' || $settings->google_login == 'on' || $settings->twitter_login == 'on')
                    @if ($settings->google_login == 'on')
                        <a href="{{ url('oauth/google') }}" class="btn btn-google">
                            <img src="{{ asset('img/google.svg') }}" alt="Google" class="mr-2">
                            Log in with Google
                        </a>
                    @endif
                @endif

                <!-- Sign Up Link -->
                @if ($settings->registration_active == '1')
                    <p class="text-center text-muted mt-3">
                        Don't have an account? 
                        <a href="{{ url('signup') }}" class="text-decoration-none" style="color: #469DFA;">
                            Sign up
                        </a>
                    </p>
                @endif
            </div>
        </div>

        <!-- Right Section -->
        <div class="login-right d-none d-lg-flex">
            <div class="testimonial">
                <!-- Quote Content - Vertically Centered -->
                <div class="testimonial-content">
                    <div class="testimonial-slide active" data-author="Olivia Rhye" data-role="Lead Designer, Layers" data-company="Web Development Agency">
                        <h4>“We've been using LabVlog to kick start every new project and can't imagine working without it.”</h4>
                    </div>
            
                    <div class="testimonial-slide" data-author="Michael Chen" data-role="CTO, TechSolutions Inc." data-company="Software Development">
                        <h4>“LabVlog has completely transformed our workflow. The collaboration features are exceptional!”</h4>
                    </div>
            
                    <div class="testimonial-slide" data-author="Sarah Johnson" data-role="Founder & CEO, InnovateCo" data-company="Startup Consulting">
                        <h4>“As a startup founder, LabVlog gave us the competitive edge we needed to scale rapidly.”</h4>
                    </div>
                </div>
                
                <!-- Bottom Section - Author Info + Arrows -->
                <div class="testimonial-bottom">
                    <div class="author-info">
                        <h5 class="text-white" id="authorName">Olivia Rhye</h5>
                        <p class="text-white" id="authorDetails">Lead Designer, Layers<br>Web Development Agency</p>
                    </div>
                    <div class="testimonial-nav">
                        <button class="nav-arrow" id="prevTestimonial">
                            <img src="/svg/left-icon.svg" alt="Previous">
                        </button>
                        <button class="nav-arrow" id="nextTestimonial">
                            <img src="/svg/right-icon.svg" alt="Next">
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Password toggle functionality
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
    
            // Form submission handling
            const form = document.getElementById('formLoginRegister');
            if (form) {
                form.addEventListener('submit', function() {
                    const btn = document.getElementById('btnLoginRegister');
                    if (btn) {
                        btn.disabled = true;
                        btn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> ' + btn.textContent;
                    }
                });
            }
    
            // Testimonial slider functionality
            const slides = document.querySelectorAll('.testimonial-slide');
            const prevBtn = document.getElementById('prevTestimonial');
            const nextBtn = document.getElementById('nextTestimonial');
            const authorName = document.getElementById('authorName');
            const authorDetails = document.getElementById('authorDetails');
            let currentSlide = 0;
    
            function showSlide(index) {
                slides.forEach(slide => slide.classList.remove('active'));
                slides[index].classList.add('active');
                
                // Update author info
                const activeSlide = slides[index];
                authorName.textContent = activeSlide.dataset.author;
                authorDetails.innerHTML = activeSlide.dataset.role + '<br>' + activeSlide.dataset.company;
                
                prevBtn.disabled = index === 0;
                nextBtn.disabled = index === slides.length - 1;
            }
    
            nextBtn.addEventListener('click', function() {
                if (currentSlide < slides.length - 1) {
                    currentSlide++;
                    showSlide(currentSlide);
                }
            });
    
            prevBtn.addEventListener('click', function() {
                if (currentSlide > 0) {
                    currentSlide--;
                    showSlide(currentSlide);
                }
            });
    
            showSlide(currentSlide);
        });
    </script>
@endsection