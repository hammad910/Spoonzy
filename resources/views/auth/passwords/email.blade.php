@extends('layouts.app')

@section('title') {{__('auth.password_recover')}} -@endsection

@section('css')
  <script type="text/javascript">
      var error_scrollelement = {{ count($errors) > 0 ? 'true' : 'false' }};
  </script>
@endsection

@section('content')
<div class="d-flex justify-content-center align-items-center min-vh-100 position-relative" 
     style="background: #fff; overflow: hidden;">
    
    <!-- Top gradient -->
    <div style="
        position: absolute;
        top: -100px;
        right: -100px;
        width: 300px;
        height: 300px;
        background: radial-gradient(circle at center, rgba(70,157,250,0.4), transparent 70%);
        filter: blur(60px);
        z-index: 0;
    "></div>

    <!-- Bottom gradient (desktop only) -->
    <div class="d-none d-md-block" style="
        position: absolute;
        bottom: -100px;
        left: -100px;
        width: 300px;
        height: 300px;
        background: radial-gradient(circle at center, rgba(70,157,250,0.4), transparent 70%);
        filter: blur(60px);
        z-index: 0;
    "></div>

    <!-- Bottom gradient (mobile only) -->
    <div class="d-block d-md-none" style="
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 180px;
        background: linear-gradient(to top, rgba(70,157,250,0.3), transparent);
        filter: blur(20px);
        z-index: 0;
    "></div>

    <!-- Forgot Password Card -->
    <div class="forgot-container p-4 rounded bg-white position-relative border-0 b-radio-custom" 
         style="max-width: 400px; width: 100%; z-index: 1;">

        <div class="illustration text-center mb-4">
            <img src="/images/reset-image.png" alt="Forgot Illustration" 
                 style="max-width: 100%; height: auto;">
        </div>

        <h4 class="text-center mb-0 font-weight-bold">{{__('auth.password_recover')}}</h4>
        <small class="btn-block text-center mt-2">{{ __('auth.recover_pass_subtitle') }}</small>

        <div class="card-body px-0 py-4">
            @if (session('status'))
                <div class="alert alert-success">
                    {{{ session('status') }}}
                </div>
            @endif

            @include('errors.errors-forms')

            <form method="POST" action="{{ route('password.email') }}" id="passwordEmailForm">
                @csrf
                <div class="form-group mb-3">
                    <div class="input-group input-group-alternative">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="feather icon-mail"></i></span>
                        </div>
                        <input class="form-control @if (count($errors) > 0) is-invalid @endif" 
                               value="{{ old('email')}}" 
                               placeholder="{{__('auth.email')}}" 
                               name="email" required type="text">
                    </div>
                </div>

                <div class="text-center">
                    @if ($settings->captcha == 'on')
                        {!! NoCaptcha::displaySubmit('passwordEmailForm', __('auth.send_pass_reset'), ['data-size' => 'invisible', 'class' => 'btn w-100 text-white', 'style' => 'background-color:#469DFA;']) !!}
                        {!! NoCaptcha::renderJs() !!}
                    @else
                        <button type="submit" class="btn w-100 text-white" style="background-color:#469DFA;">
                            {{__('auth.send_pass_reset')}}
                        </button>
                    @endif
                </div>
            </form>

            @if ($settings->captcha == 'on')
                <small class="btn-block text-center mt-2">
                    {{__('auth.protected_recaptcha')}} 
                    <a href="https://policies.google.com/privacy" target="_blank">{{__('general.privacy')}}</a> - 
                    <a href="https://policies.google.com/terms" target="_blank">{{__('general.terms')}}</a>
                </small>
            @endif

            <div class="text-center mt-4">
                Remember your Password?
                <a href="{{ route('login') }}" style="color:#469DFA;">Back to log in</a>
            </div>
        </div>
    </div>
</div>
@endsection
