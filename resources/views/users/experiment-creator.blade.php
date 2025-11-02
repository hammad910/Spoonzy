@extends('layouts.app')

@section('title')
    Health Tracking -
@endsection

@section('css')
    <style>
        /* Full Width Experiment Section */
        .experiment-hero {
            position: relative;
            width: 100%;
            height: 400px;
            overflow: hidden;
            margin-bottom: 30px;
        }

        .experiment-bg-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            filter: brightness(60%);
        }

        .experiment-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            color: #fff;
        }

        .experiment-header h1 {
            font-weight: 700;
            font-size: 2.5rem;
            margin-bottom: 10px;
        }

        .badge-healthcare {
            background-color: #b341f9;
            font-size: 0.9rem;
            font-weight: 600;
            border-radius: 20px;
            padding: 8px 16px;
            margin-left: 15px;
        }

        .profile-section {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .profile-section img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #fff;
        }

        .btn-subscribe {
            background-color: #4c8ef7;
            color: #fff;
            border: none;
            border-radius: 25px;
            padding: 10px 25px;
            font-size: 1rem;
            font-weight: 600;
        }

        .btn-join {
            background-color: transparent;
            border: 2px solid #fff;
            color: #fff;
            border-radius: 25px;
            padding: 10px 25px;
            font-size: 1rem;
            font-weight: 600;
        }

        .progress-container {
            background: rgba(255, 255, 255, 0.95);
            color: #333;
            padding: 20px 40px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-weight: 600;
            font-size: 1.1rem;
        }

        .progress {
            width: 250px;
            height: 8px;
            border-radius: 10px;
            background: #e0e0e0;
        }

        .progress-bar {
            background-color: #4c8ef7;
            border-radius: 10px;
        }

        @media (max-width: 768px) {
            .experiment-hero {
                height: 300px;
            }

            .experiment-overlay {
                padding: 20px;
            }

            .experiment-header h1 {
                font-size: 1.8rem;
            }

            .btn-subscribe,
            .btn-join {
                padding: 8px 20px;
                font-size: 0.9rem;
            }

            .progress-container {
                padding: 15px 20px;
                flex-direction: column;
                gap: 10px;
                text-align: center;
            }

            .progress {
                width: 100%;
            }
        }

        .menu-sidebar {
            margin-top: 4%;
        }

        .main-content {
            margin-top: 4%;
        }

        /* When screen width < 1400px */
        @media (max-width: 1399.98px) {
            .menu-sidebar {
                margin-top: 6%;
            }

            .main-content {
                margin-top: 6%;
            }
        }

        @media (max-width: 1199.98px) {
            .menu-sidebar {
                margin-top: 8%;
            }

            .main-content {
                margin-top: 8%;
            }
        }

        @media (max-width: 999.98px) {
            .main-content {
                margin-top: 10%;
            }
        }

        @media (max-width: 699.98px) {
            .main-content {
                margin-top: 15%;
            }
        }

        @media (max-width: 499.98px) {
            .main-content {
                margin-top: 20%;
            }
        }

        @media (max-width: 399.98px) {
            .main-content {
                margin-top: 24%;
            }
        }

        /* Post Card Styles */
        .post-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            margin-bottom: 25px;
            overflow: hidden;
            border: 1px solid #f0f0f0;
        }

        .post-header {
            padding: 20px;
            border-bottom: 1px solid #f0f0f0;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .post-avatar {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            object-fit: cover;
        }

        .post-user-info h5 {
            margin: 0;
            font-size: 16px;
            font-weight: 600;
            color: #333;
        }

        .post-user-info span {
            font-size: 15px;
            color: #475467;
        }

        .post-content {
            padding: 20px;
        }

        .post-content p {
            margin-bottom: 15px;
            font-size: 15px;
            line-height: 1.5;
            color: #555;
        }

        .experiment-image {
            border-radius: 10px;
            margin-bottom: 15px;
            max-height: 300px;
            width: 100%;
        }

        .post-actions {
            padding: 15px 20px;
            border-top: 1px solid #f0f0f0;
            display: flex;
            gap: 20px;
        }

        .post-action {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #666;
            cursor: pointer;
            transition: color 0.3s ease;
            font-weight: 500;
        }

        .post-action:hover {
            color: #3897f0;
        }

        .post-action i {
            font-size: 18px;
        }

        /* Navigation Styles */
        .nav-profile {
            background: white;
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            margin: 30px 0;
            padding: 10px;
        }

        .nav-profile .nav-link {
            color: #666;
            padding: 15px 25px;
            border-bottom: 3px solid transparent;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .nav-profile .nav-link.active {
            color: #3897f0;
            border-bottom-color: #3897f0;
            background: rgba(56, 151, 240, 0.1);
            border-radius: 10px;
        }

        .nav-profile .nav-link:hover {
            color: #3897f0;
            background: rgba(56, 151, 240, 0.05);
            border-radius: 10px;
        }

        /* Content Container */
        .content-container {
            background: #FBFBFB;
            min-height: 100vh;
        }

        /* New Layout Styles */
        .posts-container {
            display: flex;
            gap: 30px;
            margin-top: 30px;
        }

        .posts-main {
            flex: 2;
            /* Wider section for posts */
        }

        .widgets-sidebar {
            flex: 1;
            /* Narrower section for widgets */
            max-width: 350px;
        }

        /* Widget Card Styles */
        .widget-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            margin-bottom: 25px;
            overflow: hidden;
            border: 1px solid #f0f0f0;
        }

        .widget-header {
            padding: 15px 20px;
            border-bottom: 1px solid #f0f0f0;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .widget-header h5 {
            margin: 0;
            font-size: 18px;
            font-weight: 600;
            color: #333;
        }

        .widget-content {
            padding: 20px;
        }

        .widget-content p {
            font-size: 16px;
            line-height: 1.5;
            color: #555;
            margin-bottom: 15px;
        }

        .widget-image {
            width: 100%;
            border-radius: 10px;
            margin-bottom: 15px;
        }

        .widget-actions {
            padding: 15px 20px;
            border-top: 1px solid #f0f0f0;
            display: flex;
            justify-content: space-between;
        }

        .widget-btn {
            background-color: #4c8ef7;
            color: white;
            border: none;
            border-radius: 20px;
            padding: 8px 16px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .widget-btn:hover {
            background-color: #3a7de0;
        }

        /* Loading States */
        .loading {
            opacity: 0.6;
            pointer-events: none;
        }

        .spinner-border-sm {
            width: 1rem;
            height: 1rem;
        }

        /* Responsive adjustments */
        @media (max-width: 992px) {
            .posts-container {
                flex-direction: column;
            }

            .widgets-sidebar {
                max-width: 100%;
            }
        }
    </style>
@endsection

@section('content')
    <div class="d-flex flex-column flex-lg-row content-container">
        <!-- Sidebar -->
        <div class="menu-sidebar d-none d-lg-block" style="width: 20%; border-right: 1px solid #ddd; padding: 20px;">
            @include('includes.menu-sidebar-home')
        </div>

        <!-- Main Content -->
        <div class="flex-grow-1 main-content">
            <!-- Full Width Experiment Hero Section -->
            <div class="experiment-hero">
                <img alt="30-Day Beef Tallow Skin Transformation" class="experiment-bg-image">

                <div class="experiment-overlay">
                    <!-- Top Section: Title and Badge -->
                    <div class="experiment-header">
                        <div class="d-flex align-items-center flex-wrap">
                            <h1 id="experiment-title">Loading...</h1>
                            <span class="badge-healthcare" id="experiment-category">Loading...</span>
                        </div>
                    </div>

                    <!-- Bottom Section: Profile and Buttons -->
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="profile-section">
                            <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="James Danton">
                            <div>
                                <span class="fw-semibold fs-5" id="experiment-days">Loading...</span>
                                <span class="d-none" id="userLabel">
                                    {{ auth()->user()->first_name }}
                                </span>
                                @if ($user->verified_id == 'yes')
                                            <small style="color: #fff; font-size: 16px" title="{{ __('general.verified_account') }}"
                                                data-toggle="tooltip" data-placement="top">
                                                <i class="bi-patch-check-fill"></i>
                                            </small>
                                        @endif
                                {{-- <button class="btn btn-sm btn-primary rounded-pill ms-3"
                                    style="background-color:#4c8ef7;border:none;">
                                    Follow
                                </button> --}}
                            </div>
                        </div>

                        <div class="d-flex gap-3">
                            @if (
                                ($userPlanMonthlyActive && $user->verified_id == 'yes') ||
                                    ($user->free_subscription == 'yes' && $user->verified_id == 'yes'))

                                @if (auth()->check() &&
                                        auth()->id() != $user->id &&
                                        !$checkSubscription &&
                                        !$paymentIncomplete &&
                                        $user->free_subscription == 'no' &&
                                        $totalPosts != 0)
                                    <a href="javascript:void(0);" data-toggle="modal" data-target="#subscriptionForm"
                                        class="btn btn-primary btn-profile mr-1">
                                        <i class="feather icon-unlock mr-1"></i>
                                        {{ __('general.subscribe_month', ['price' => Helper::formatPrice($user->getPlan('monthly', 'price'))]) }}
                                    </a>
                                @elseif (auth()->check() && auth()->id() != $user->id && !$checkSubscription && $paymentIncomplete)
                                    <a href="{{ route('cashier.payment', $paymentIncomplete->last_payment) }}"
                                        class="btn btn-warning btn-profile mr-1">
                                        <i class="fa fa-exclamation-triangle"></i>
                                        {{ __('general.confirm_payment') }}
                                    </a>
                                @elseif (auth()->check() && auth()->id() != $user->id && $checkSubscription)
                                    @if ($checkSubscription->stripe_status == 'active' && $checkSubscription->stripe_id != '')
                                        <form method="POST"
                                            action="{{ url('subscription/cancel/' . $checkSubscription->stripe_id) }}"
                                            class="d-inline formCancel">
                                            @csrf
                                            <button type="button"
                                                data-expiration="{{ __('general.subscription_expire') . ' ' . Helper::formatDate(auth()->user()->subscription('main', $checkSubscription->stripe_price)->asStripeSubscription()->current_period_end, true) }}"
                                                class="btn btn-success btn-profile mr-1 cancelBtn subscriptionActive">
                                                <i class="feather icon-user-check mr-1"></i>
                                                {{ __('general.your_subscribed') }}
                                            </button>
                                        </form>
                                    @elseif ($checkSubscription->stripe_id == '' && $checkSubscription->free == 'yes')
                                        <form method="POST"
                                            action="{{ url('subscription/free/cancel/' . $checkSubscription->id) }}"
                                            class="d-inline formCancel">
                                            @csrf
                                            <button type="button"
                                                data-expiration="{{ __('general.confirm_cancel_subscription') }}"
                                                class="btn btn-success btn-profile mr-1 cancelBtn subscriptionActive">
                                                <i class="feather icon-user-check mr-1"></i>
                                                {{ __('general.your_subscribed') }}
                                            </button>
                                        </form>
                                    @elseif ($paymentGatewaySubscription == 'Paystack' && $checkSubscription->cancelled == 'no')
                                        <form method="POST"
                                            action="{{ url('subscription/paystack/cancel/' . $checkSubscription->subscription_id) }}"
                                            class="d-inline formCancel">
                                            @csrf
                                            <button type="button"
                                                data-expiration="{{ __('general.subscription_expire') . ' ' . Helper::formatDate($checkSubscription->ends_at) }}"
                                                class="btn btn-success btn-profile mr-1 cancelBtn subscriptionActive">
                                                <i class="feather icon-user-check mr-1"></i>
                                                {{ __('general.your_subscribed') }}
                                            </button>
                                        </form>
                                    @elseif ($paymentGatewaySubscription == 'Wallet' && $checkSubscription->cancelled == 'no')
                                        <form method="POST"
                                            action="{{ url('subscription/wallet/cancel/' . $checkSubscription->id) }}"
                                            class="d-inline formCancel">
                                            @csrf
                                            <button type="button"
                                                data-expiration="{{ __('general.subscription_expire') . ' ' . Helper::formatDate($checkSubscription->ends_at) }}"
                                                class="btn btn-success btn-profile mr-1 cancelBtn subscriptionActive">
                                                <i class="feather icon-user-check mr-1"></i>
                                                {{ __('general.your_subscribed') }}
                                            </button>
                                        </form>
                                    @elseif ($paymentGatewaySubscription == 'PayPal' && $checkSubscription->cancelled == 'no')
                                        <form method="POST"
                                            action="{{ url('subscription/paypal/cancel/' . $checkSubscription->id) }}"
                                            class="d-inline formCancel">
                                            @csrf
                                            <button type="button"
                                                data-expiration="{{ __('general.subscription_expire') . ' ' . Helper::formatDate($checkSubscription->ends_at) }}"
                                                class="btn btn-success btn-profile mr-1 cancelBtn subscriptionActive">
                                                <i class="feather icon-user-check mr-1"></i>
                                                {{ __('general.your_subscribed') }}
                                            </button>
                                        </form>
                                    @elseif ($paymentGatewaySubscription == 'CCBill' && $checkSubscription->cancelled == 'no')
                                        <form method="POST"
                                            action="{{ url('subscription/ccbill/cancel/' . $checkSubscription->id) }}"
                                            class="d-inline formCancel">
                                            @csrf
                                            <button type="button"
                                                data-expiration="{{ __('general.subscription_expire') . ' ' . Helper::formatDate($checkSubscription->ends_at) }}"
                                                class="btn btn-success btn-profile mr-1 cancelBtn subscriptionActive">
                                                <i class="feather icon-user-check mr-1"></i>
                                                {{ __('general.your_subscribed') }}
                                            </button>
                                        </form>
                                    @elseif ($paymentGatewaySubscription == 'Redsys' && $checkSubscription->cancelled == 'no')
                                        <form method="POST"
                                            action="{{ url('subscription/redsys/cancel/' . $checkSubscription->id) }}"
                                            class="d-inline formCancel">
                                            @csrf
                                            <button type="button"
                                                data-expiration="{{ __('general.subscription_expire') . ' ' . Helper::formatDate($checkSubscription->ends_at) }}"
                                                class="btn btn-success btn-profile mr-1 cancelBtn subscriptionActive">
                                                <i class="feather icon-user-check mr-1"></i>
                                                {{ __('general.your_subscribed') }}
                                            </button>
                                        </form>
                                    @elseif ($paymentGatewaySubscription == 'Netvalve' && $checkSubscription->cancelled == 'no')
                                        <form method="POST"
                                            action="{{ url('subscription/netvalve/cancel/' . $checkSubscription->id) }}"
                                            class="d-inline formCancel">
                                            @csrf
                                            <button type="button"
                                                data-expiration="{{ __('general.subscription_expire') . ' ' . Helper::formatDate($checkSubscription->ends_at) }}"
                                                class="btn btn-success btn-profile mr-1 cancelBtn subscriptionActive">
                                                <i class="feather icon-user-check mr-1"></i>
                                                {{ __('general.your_subscribed') }}
                                            </button>
                                        </form>
                                    @elseif ($checkSubscription->cancelled == 'yes' || $checkSubscription->stripe_status == 'canceled')
                                        <a href="javascript:void(0);" class="btn btn-success btn-profile mr-1 disabled">
                                            <i class="feather icon-user-check mr-1"></i>
                                            {{ __('general.subscribed_until') }}
                                            {{ Helper::formatDate($checkSubscription->ends_at) }}
                                        </a>
                                    @endif
                                @elseif (auth()->check() && auth()->id() != $user->id && $user->free_subscription == 'yes' && $totalPosts != 0)
                                    <a href="javascript:void(0);" data-toggle="modal" data-target="#subscriptionFreeForm"
                                        class="btn btn-primary btn-profile mr-1">
                                        <i class="feather icon-user-plus mr-1"></i>
                                        {{ __('general.subscribe_for_free') }}
                                    </a>
                                @elseif (auth()->guest() && $totalPosts != 0)
                                    <a href="{{ url('login') }}" data-toggle="modal" data-target="#loginFormModal"
                                        class="btn btn-primary btn-profile mr-1">
                                        @if ($user->free_subscription == 'yes')
                                            <i class="feather icon-user-plus mr-1"></i>
                                            {{ __('general.subscribe_for_free') }}
                                        @else
                                            <i class="feather icon-unlock mr-1"></i>
                                            {{ __('general.subscribe_month', ['price' => Helper::formatPrice($user->getPlan('monthly', 'price'))]) }}
                                        @endif
                                    </a>
                                @endif
                            @endif
                            @if (auth()->check() && auth()->id() != $user->id && !$checkSubscription && $user->verified_id == 'yes')

                            @if ($user->free_subscription == 'no')
                                <div class="modal modal-subscribe fade" id="subscriptionForm" tabindex="-1" role="dialog"
                                    aria-labelledby="modal-form" aria-hidden="true">
                                    <div class="modal-dialog modal- modal-dialog-centered modal-sm" role="document">
                                        <div class="modal-content">
                                            <div class="modal-body p-0">
                                                <div class="card bg-white shadow border-0">
                                                    <div class="card-header pb-2 border-0 position-relative"
                                                        style="height: 100px; background: {{ $settings->color_default }} @if ($user->cover != '') url('{{ Helper::getFile(config('path.cover') . $user->cover) }}') no-repeat center center @endif; background-size: cover; border-top-left-radius: 0.7rem;border-top-right-radius: 0.7rem;">
            
                                                    </div>
                                                    <div class="card-body px-lg-5 py-lg-5 position-relative">
            
                                                        <div class="text-muted text-center mb-3 position-relative modal-offset">
                                                            <img src="{{ Helper::getFile(config('path.avatar') . $user->avatar) }}"
                                                                width="100"
                                                                alt="{{ $user->hide_name == 'yes' ? $user->username : $user->name }}"
                                                                class="avatar-modal rounded-circle mb-1">
                                                            <h6 class="font-weight-light">
                                                                {!! __('general.subscribe_month', [
                                                                    'price' =>
                                                                        '<span class="font-weight-bold">' . Helper::formatPrice($user->getPlan('monthly', 'price'), true) . '</span>',
                                                                ]) !!} {{ __('general.unlocked_content') }}
                                                                {{ $user->hide_name == 'yes' ? $user->username : $user->name }}
            
                                                                <small class="w-100 d-block font-12">*
                                                                    {{ __('general.in_currency', ['currency_code' => $settings->currency_code]) }}</small>
                                                            </h6>
                                                        </div>
            
                                                        @if ($totalPosts == 0)
                                                            <div class="alert alert-warning fade show small" role="alert">
                                                                <i class="fa fa-exclamation-triangle mr-1"></i>
                                                                {{ $user->first_name }} {{ __('general.not_posted_any_content') }}
                                                            </div>
                                                        @endif
            
                                                        <div class="text-center text-muted mb-2">
                                                            <h5>{{ __('general.what_will_you_get') }}</h5>
                                                        </div>
            
                                                        <ul class="list-unstyled" style="color: #5f5f5f">
                                                            <li><i
                                                                    class="fa fa-check mr-2 @if (auth()->user()->dark_mode == 'on') text-white @else text-primary @endif"></i>
                                                                {{ __('general.full_access_content') }}</li>
                                                            <li><i
                                                                    class="fa fa-check mr-2 @if (auth()->user()->dark_mode == 'on') text-white @else text-primary @endif"></i>
                                                                {{ __('general.direct_message_with_this_user') }}</li>
                                                            <li><i
                                                                    class="fa fa-check mr-2 @if (auth()->user()->dark_mode == 'on') text-white @else text-primary @endif"></i>
                                                                {{ __('general.cancel_subscription_any_time') }}</li>
                                                        </ul>
            
                                                        <div
                                                            class="text-center text-muted mb-2 @if ($allPayment->count() == 1) d-none @endif">
                                                            <small><i class="far fa-credit-card mr-1"></i>
                                                                {{ __('general.choose_payment_gateway') }}</small>
                                                        </div>
            
                                                        <form method="post" action="{{ url('buy/subscription') }}"
                                                            id="formSubscription">
                                                            @csrf
            
                                                            <input type="hidden" name="id" value="{{ $user->id }}" />
                                                            <input name="interval" value="monthly" id="plan-monthly" class="d-none"
                                                                type="radio">
            
                                                            @foreach ($plans as $plan)
                                                                <input name="interval" value="{{ $plan->interval }}"
                                                                    id="plan-{{ $plan->interval }}" class="d-none" type="radio">
                                                            @endforeach
            
                                                            @foreach ($allPayment as $payment)
                                                                @php
            
                                                                    if ($payment->recurrent == 'no') {
                                                                        $recurrent =
                                                                            '<br><small>' .
                                                                            __('general.non_recurring') .
                                                                            '</small>';
                                                                    } elseif ($payment->id == 1) {
                                                                        $recurrent =
                                                                            '<br><small>' .
                                                                            __('general.redirected_to_paypal_website') .
                                                                            '</small>';
                                                                    } else {
                                                                        $recurrent =
                                                                            '<br><small>' .
                                                                            __('general.automatically_renewed') .
                                                                            ' (' .
                                                                            $payment->name .
                                                                            ')</small>';
                                                                    }
            
                                                                    if ($payment->type == 'card') {
                                                                        $paymentName =
                                                                            '<i class="far fa-credit-card mr-1"></i> ' .
                                                                            __('general.debit_credit_card') .
                                                                            $recurrent;
                                                                    } elseif ($payment->id == 1) {
                                                                        $paymentName =
                                                                            '<img src="' .
                                                                            url(
                                                                                'public/img/payments',
                                                                                auth()->user()->dark_mode == 'off'
                                                                                    ? $payment->logo
                                                                                    : 'paypal-white.png',
                                                                            ) .
                                                                            '" width="70"/> <small class="w-100 d-block">' .
                                                                            __('general.redirected_to_paypal_website') .
                                                                            '</small>';
                                                                    } elseif ($payment->name == 'Netvalve') {
                                                                        $paymentName =
                                                                            '<img src="' .
                                                                            url('public/img/payments', $payment->logo) .
                                                                            '" width="100"/>';
                                                                    } else {
                                                                        $paymentName =
                                                                            '<img src="' .
                                                                            url('public/img/payments', $payment->logo) .
                                                                            '" width="70"/>' .
                                                                            $recurrent;
                                                                    }
            
                                                                @endphp
            
                                                                <div class="custom-control custom-radio mb-3">
                                                                    <input name="payment_gateway" required
                                                                        value="{{ $payment->name }}"
                                                                        id="radio{{ $payment->name }}"
                                                                        @if ($allPayment->count() == 1 && Helper::userWallet('balance') == 0) checked @endif
                                                                        class="custom-control-input" type="radio">
                                                                    <label class="custom-control-label"
                                                                        for="radio{{ $payment->name }}">
                                                                        <span><strong>{!! $paymentName !!}</strong></span>
                                                                    </label>
                                                                </div>
            
                                                                @if ($payment->name == 'Stripe' && !auth()->user()->pm_type != '')
                                                                    <div id="stripeContainer"
                                                                        class="@if ($allPayment->count() == 1 && $payment->name == 'Stripe') d-block @else display-none @endif">
                                                                        <a href="{{ url('settings/payments/card') }}"
                                                                            class="btn btn-secondary btn-sm mb-3 w-100">
                                                                            <i class="far fa-credit-card mr-2"></i>
                                                                            {{ __('general.add_payment_card') }}
                                                                        </a>
                                                                    </div>
                                                                @endif
            
                                                                @if ($payment->name == 'Paystack' && !auth()->user()->paystack_authorization_code)
                                                                    <div id="paystackContainer"
                                                                        class="@if ($allPayment->count() == 1 && $payment->name == 'Paystack') d-block @else display-none @endif">
                                                                        <a href="{{ url('my/cards') }}"
                                                                            class="btn btn-secondary btn-sm mb-3 w-100">
                                                                            <i class="far fa-credit-card mr-2"></i>
                                                                            {{ __('general.add_payment_card') }}
                                                                        </a>
                                                                    </div>
                                                                @endif
                                                            @endforeach
            
                                                            @if (($settings->disable_wallet == 'on' && Helper::userWallet('balance') != 0) || $settings->disable_wallet == 'off')
                                                                <div class="custom-control custom-radio mb-3">
                                                                    <input name="payment_gateway" required
                                                                        @if (Helper::userWallet('balance') == 0) disabled @endif
                                                                        value="wallet" id="radio0" class="custom-control-input"
                                                                        type="radio">
                                                                    <label class="custom-control-label" for="radio0">
                                                                        <span>
                                                                            <strong>
                                                                                <i class="fas fa-wallet mr-1 icon-sm-radio"></i>
                                                                                {{ __('general.wallet') }}
                                                                                <span class="w-100 d-block font-weight-light">
                                                                                    {{ __('general.available_balance') }}: <span
                                                                                        class="font-weight-bold mr-1">{{ Helper::userWallet() }}</span>
            
                                                                                    @if (Helper::userWallet('balance') != 0 && $settings->wallet_format != 'real_money')
                                                                                        <i class="bi-info-circle text-muted"
                                                                                            data-toggle="tooltip" data-placement="top"
                                                                                            title="{{ Helper::equivalentMoney($settings->wallet_format) }}"></i>
                                                                                    @endif
            
                                                                                    @if (Helper::userWallet('balance') == 0)
                                                                                        <a href="{{ url('my/wallet') }}"
                                                                                            class="link-border">{{ __('general.recharge') }}</a>
                                                                                    @endif
                                                                                </span>
                                                                                <span
                                                                                    class="w-100 d-block small">{{ __('general.automatically_renewed_wallet') }}</span>
                                                                            </strong>
                                                                        </span>
                                                                    </label>
                                                                </div>
                                                            @endif
            
                                                            <div class="alert alert-danger display-none" id="error">
                                                                <ul class="list-unstyled m-0" id="showErrors"></ul>
                                                            </div>
            
                                                            <div class="custom-control custom-control-alternative custom-checkbox">
                                                                <input class="custom-control-input" required id=" customCheckLogin"
                                                                    name="agree_terms" type="checkbox">
                                                                <label class="custom-control-label" for=" customCheckLogin">
                                                                    <span style="color: #5f5f5f">{{ __('general.i_agree_with') }} <a
                                                                            href="{{ $settings->link_terms }}"
                                                                            target="_blank">{{ __('admin.terms_conditions') }}</a></span>
                                                                </label>
                                                            </div>
            
                                                            @if ($taxRatesCount != 0 && auth()->user()->isTaxable()->count())
                                                                <ul class="list-group list-group-flush border-dashed-radius mt-3">
                                                                    @foreach (auth()->user()->isTaxable() as $tax)
                                                                        <li class="list-group-item py-1 list-taxes">
                                                                            <div class="row">
                                                                                <div class="col">
                                                                                    <small>{{ $tax->name }}
                                                                                        {{ $tax->percentage }}%
                                                                                        {{ __('general.applied_price') }}</small>
                                                                                </div>
                                                                            </div>
                                                                        </li>
                                                                    @endforeach
                                                                </ul>
                                                            @endif
            
                                                            <div class="text-center">
                                                                <button type="submit"
                                                                    class="btn btn-primary mt-4 w-100 subscriptionBtn"
                                                                    onclick="$('#plan-monthly').trigger('click');">
                                                                    <i></i>
                                                                    {{ __('general.subscribe_month', ['price' => Helper::formatPrice($user->getPlan('monthly', 'price'), true)]) }}
                                                                </button>
            
                                                                @if ($plans->count())
                                                                    <a class="d-block my-3 btn-arrow-expand-bi" data-toggle="collapse"
                                                                        href="#collapseSubscriptionBundles" role="button"
                                                                        aria-expanded="false" aria-controls="collapseExample">
                                                                        <i class="bi-box mr-1"></i>
                                                                        {{ __('general.subscription_bundles') }} <i
                                                                            class="bi-chevron-down transition-icon"></i>
                                                                    </a>
            
                                                                    <div class="collapse" id="collapseSubscriptionBundles">
                                                                        @foreach ($plans as $plan)
                                                                            <button type="submit"
                                                                                class="btn btn-primary mt-2 w-100 subscriptionBtn"
                                                                                onclick="$('#plan-{{ $plan->interval }}').trigger('click');">
                                                                                <i></i>
                                                                                {{ __('general.subscribe_' . $plan->interval, ['price' => Helper::formatPrice($plan->price, true)]) }}
                                                                            </button>
            
                                                                            @if (Helper::calculateSubscriptionDiscount($plan->interval, $user->getPlan('monthly', 'price'), $plan->price) > 0)
                                                                                <small
                                                                                    class="@if (auth()->user()->dark_mode == 'on') text-white @else text-success @endif subscriptionDiscount">
                                                                                    <em>{{ Helper::calculateSubscriptionDiscount($plan->interval, $user->getPlan('monthly', 'price'), $plan->price) }}%
                                                                                        {{ __('general.discount') }} </em>
                                                                                </small>
                                                                            @endif
                                                                        @endforeach
                                                                    </div>
            
                                                                @endif
            
                                                                <div class="w-100 mt-2">
                                                                    <button type="button" class="btn e-none p-0"
                                                                        data-dismiss="modal">{{ __('admin.cancel') }}</button>
                                                                </div>
                                                            </div>
            
                                                            @include('includes.site-billing-info')
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div><!-- End Modal Subscription -->
                            @endif
            
                            <!-- Subscription Free -->
                            <div class="modal modal-subscribe fade" id="subscriptionFreeForm" tabindex="-1" role="dialog"
                                aria-labelledby="modal-form" aria-hidden="true">
                                <div class="modal-dialog modal- modal-dialog-centered modal-sm" role="document">
                                    <div class="modal-content">
                                        <div class="modal-body p-0">
                                            <div class="card bg-white shadow border-0">
                                                <div class="card-header pb-2 border-0 position-relative"
                                                    style="height: 100px; background: {{ $settings->color_default }} @if ($user->cover != '') url('{{ Helper::getFile(config('path.cover') . $user->cover) }}') no-repeat center center @endif; background-size: cover; border-top-left-radius: 0.7rem;border-top-right-radius: 0.7rem;">
            
                                                </div>
                                                <div class="card-body px-lg-5 py-lg-5 position-relative">
            
                                                    <div class="text-muted text-center mb-3 position-relative modal-offset">
                                                        <img src="{{ Helper::getFile(config('path.avatar') . $user->avatar) }}"
                                                            width="100"
                                                            alt="{{ $user->hide_name == 'yes' ? $user->username : $user->name }}"
                                                            class="avatar-modal rounded-circle mb-1">
                                                        <h6 class="font-weight-light">
                                                            {{ __('general.subscribe_free_content') }}
                                                            {{ $user->hide_name == 'yes' ? $user->username : $user->name }}
                                                        </h6>
                                                    </div>
            
                                                    @if ($totalPosts == 0)
                                                        <div class="alert alert-warning fade show small" role="alert">
                                                            <i class="fa fa-exclamation-triangle mr-1"></i> {{ $user->first_name }}
                                                            {{ __('general.not_posted_any_content') }}
                                                        </div>
                                                    @endif
            
                                                    <div class="text-center text-muted mb-2">
                                                        <h5>{{ __('general.what_will_you_get') }}</h5>
                                                    </div>
            
                                                    <ul class="list-unstyled" style="color: #5f5f5f">
                                                        <li><i class="fa fa-check mr-2 text-primary"></i>
                                                            {{ __('general.full_access_content') }}</li>
                                                        <li><i class="fa fa-check mr-2 text-primary"></i>
                                                            {{ __('general.direct_message_with_this_user') }}</li>
                                                        <li><i class="fa fa-check mr-2 text-primary"></i>
                                                            {{ __('general.cancel_subscription_any_time') }}</li>
                                                    </ul>
            
                                                    <div class="w-100 text-center">
                                                        <a href="javascript:void(0);" data-id="{{ $user->id }}"
                                                            id="subscribeFree" class="btn btn-primary btn-profile mr-1">
                                                            <i class="feather icon-user-plus mr-1"></i>
                                                            {{ __('general.subscribe_for_free') }}
                                                        </a>
                                                        <div class="w-100 mt-2">
                                                            <button type="button" class="btn e-none p-0"
                                                                data-dismiss="modal">{{ __('admin.cancel') }}</button>
                                                        </div>
                                                    </div>
            
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- End Modal Subscription Free -->
                        @endif
                        </div>
                    </div>
                </div>

                <!-- Progress Bar Section -->
                <div class="progress-container">
                    <span class="fs-6" id="progress-text">Loading...</span>
                    <div class="progress">
                        <div class="progress-bar" id="progress-bar" style="width:0%;"></div>
                    </div>
                </div>
            </div>

            <div class="container py-4">
                <div class="posts-container">
                    <!-- Left Side - Wider Post Cards -->
                    <div class="posts-main" id="posts-container">
                        <!-- Posts will be loaded here dynamically -->
                        <div class="text-center py-5">
                            <div class="spinner-border text-primary" role="status">
                            </div>
                            <p class="mt-2">Loading experiment posts...</p>
                        </div>
                    </div>

                    <div class="widgets-sidebar">
                        <div class="widget-card">
                            <div class="widget-header">
                                <img src="/images/experiment-summary.png" alt="">
                                <h5>Experiment Summary</h5>
                            </div>
                            <div class="widget-content" id="experiment-summary">
                                <div class="text-center py-3">
                                    <div class="spinner-border spinner-border-sm text-primary" role="status">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card border-0 rounded-4 p-3 widget-card">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h6 class="fw-bold mb-0 d-flex align-items-center"
                                    style="color: #000; font-size: 18px; gap: 5px;">
                                    <img src="/images/experiment-vector.png" alt="" class="me-2 img-fluid"
                                        style="width: 24px;">
                                    Supplements
                                </h6>
                            </div>

                            <div id="supplements-container">
                                <div class="text-center py-3">
                                    <div class="spinner-border spinner-border-sm text-primary" role="status">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('javascript')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Load all data from single API call
            loadAllExperimentData();

            // Like functionality
            document.addEventListener('click', function(e) {
                if (e.target.closest('.post-action')) {
                    const action = e.target.closest('.post-action');
                    if (action.querySelector('.bi-heart')) {
                        const heart = action.querySelector('.bi-heart');
                        const count = action.querySelector('span');

                        if (heart.classList.contains('bi-heart')) {
                            heart.classList.remove('bi-heart');
                            heart.classList.add('bi-heart-fill', 'text-danger');
                            count.textContent = parseInt(count.textContent) + 1;
                        } else {
                            heart.classList.remove('bi-heart-fill', 'text-danger');
                            heart.classList.add('bi-heart');
                            count.textContent = parseInt(count.textContent) - 1;
                        }
                    }
                }
            });

            // Navigation active state
            document.querySelectorAll('.nav-profile .nav-link').forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    document.querySelectorAll('.nav-profile .nav-link').forEach(l => l.classList
                        .remove('active'));
                    this.classList.add('active');
                });
            });
        });

        // Load all data from single API call
        function loadAllExperimentData() {
            fetch(`/experiment/{{ $id ?? 1 }}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        const experiment = data;
                        $('.experiment-bg-image').attr('src', experiment.image_url || '/images/experiment-img.jpg');

                        // Update hero section with experiment data
                        updateHeroSection(experiment);

                        // Update experiment summary
                        updateExperimentSummary(experiment);

                        // Create and display posts from experiment data
                        createPostsFromExperimentData(experiment);

                        // Load supplements
                        loadSupplementsData();

                    } else {
                        throw new Error(data.message || 'Failed to load experiment data');
                    }
                })
                .catch(error => {
                    console.error('Error loading experiment data:', error);
                    showError('experiment-summary', 'Failed to load experiment data');
                    // Set default values
                    setDefaultValues();
                });
        }

        // Update hero section with experiment data
        function updateHeroSection(experiment) {
            const userLabel = document.getElementById('userLabel').textContent.trim();
            document.getElementById('experiment-title').textContent = experiment.title;
            document.getElementById('experiment-category').textContent = experiment.category || 'Healthcare';

            // Calculate days based on completed and total
            const completed = experiment.completed || 12;
            const total = experiment.total || 30;
            document.getElementById('experiment-days').textContent = userLabel;

            // Update progress
            const progressPercentage = (completed / total) * 100;
            document.getElementById('progress-text').textContent = `${completed}/${total} Days Complete`;
            document.getElementById('progress-bar').style.width = `${progressPercentage}%`;

            // Update profile image if available
            if (experiment.user && experiment.user.avatar) {
                document.querySelector('.profile-section img').src = `/uploads/avatar/${experiment.user.avatar}`;
                document.querySelector('.profile-section img').alt = experiment.user.name;
            }
        }

        // Create posts from experiment data
        function createPostsFromExperimentData(experiment) {
            const container = document.getElementById('posts-container');
            container.innerHTML = '';

            // Create main experiment post using the experiment data
            const mainPost = {
                title: experiment.title,
                content: experiment.description ||
                    `This is the main post for the experiment "${experiment.title}". Follow along for daily updates and progress.`,
                image: experiment.image_url,
                created_at: new Date(experiment.created_at).toLocaleDateString(),
                likes_count: Math.floor(Math.random() * 50) + 10,
                comments_count: Math.floor(Math.random() * 20) + 5
            };

            const postElement = createPostElement(mainPost, experiment.title);
            container.appendChild(postElement);
        }

        // Create additional sample posts
        function createAdditionalPosts(experiment) {
            const posts = [];
            const completed = experiment.completed || 12;

            // Create posts for recent days
            for (let i = completed - 2; i <= completed; i++) {
                if (i > 0) {
                    posts.push({
                        title: `Day ${i} Progress`,
                        content: `Update for day ${i} of "${experiment.title}". Making steady progress towards the goal!`,
                        image: experiment.image_url || '/images/experiment-img.jpg',
                        created_at: new Date(Date.now() - (completed - i) * 24 * 60 * 60 * 1000)
                        .toLocaleDateString(),
                        likes_count: Math.floor(Math.random() * 30) + 5,
                        comments_count: Math.floor(Math.random() * 15) + 2
                    });
                }
            }

            return posts.reverse(); // Show latest first
        }

        // Load supplements data
        function loadSupplementsData() {
            fetch("/api/get-supplements")
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(response => {
                    const container = document.getElementById('supplements-container');
                    container.innerHTML = '';

                    if (!response.success || response.data.length === 0) {
                        container.innerHTML = `
                            <div class="text-center py-3">
                                <p class="text-muted">No supplements listed for this experiment.</p>
                            </div>
                        `;
                        return;
                    }

                    response.data.forEach(supplement => {
                        const supplementElement = createSupplementElement(supplement);
                        container.appendChild(supplementElement);
                    });
                })
                .catch(error => {
                    console.error('Error loading supplements:', error);
                    showSampleSupplements();
                });
        }

        // Update experiment summary widget
        function updateExperimentSummary(data) {
            const summaryHtml = `
                <div class="d-flex justify-content-between" style="border-bottom: 1px solid #00000012; margin-bottom: 10px;">
                    <p>Content Type</p>
                    <p style="color: #101828; font-weight: 700">${data.content_type || 'Experiment'}</p>
                </div>
                <div class="d-flex justify-content-between" style="border-bottom: 1px solid #00000012; margin-bottom: 10px;">
                    <p>Created At</p>
                    <p style="color: #101828; font-weight: 700">${new Date(data.created_at).toLocaleDateString()}</p>
                </div>
                <div class="d-flex justify-content-between" style="border-bottom: 1px solid #00000012; margin-bottom: 10px;">
                    <p>Status</p>
                    <p style="color: #101828; font-weight: 700">${data.status || 'Active'}</p>
                </div>
            `;
            document.getElementById('experiment-summary').innerHTML = summaryHtml;
        }

        // Create post element - Now uses experiment title instead of day number
        function createPostElement(post, experimentTitle) {
            const div = document.createElement('div');
            div.className = 'post-card';
            div.innerHTML = `
                <div class="post-header">
                    <div class="post-user-info">
                        <h2 style="color: black; margin-bottom: 0px !important;">${experimentTitle}</h2>
                        <span>${post.created_at}</span>
                    </div>
                </div>
                <div class="post-content">
                    <p>${post.content}</p>
                    ${post.image ? `<img src="${post.image}" alt="${experimentTitle}" class="experiment-image">` : ''}
                </div>
            `;
            return div;
        }

        function createSupplementElement(supplement) {
            const div = document.createElement('div');
            div.className =
            'experiment-item d-flex justify-content-between align-items-center p-2 rounded-3 mb-2 flex-wrap';
            div.innerHTML = `
                <div class="d-flex align-items-center flex-grow-1" style="gap: 10px; min-width: 0;">
                    <span class="me-2 fs-5">
                        <img src="/images/supplement-img.png" alt="${supplement.name}" style="width: 45px; height: 45px;">
                    </span>
                    <div class="text-truncate">
                        <div style="color: #000; font-weight: 600;">${supplement.supplement_name}</div>
                        <div class="small text-muted text-nowrap">
                            ${supplement.dosage}
                        </div>
                    </div>
                </div>
            `;
            return div;
        }

        // Set default values when API fails
        function setDefaultValues() {
            const userLabel = document.getElementById('userLabel').textContent.trim();
            document.getElementById('experiment-title').textContent = '30-Day Beef Tallow Skin Transformation';
            document.getElementById('experiment-category').textContent = 'Healthcare';
            document.getElementById('experiment-days').textContent = userLabel;
            document.getElementById('progress-text').textContent = '12/30 Days Complete';
            document.getElementById('progress-bar').style.width = '40%';

            // Show sample posts
            showSamplePosts();
        }

        // Show sample posts when API fails
        function showSamplePosts() {
            const container = document.getElementById('posts-container');
            const samplePosts = [{
                    title: "30-Day Beef Tallow Skin Transformation",
                    content: "Day 12 of the Beef Tallow experiment! My skin is feeling incredibly smooth and hydrated. The natural vitamins in beef tallow are doing wonders! 🌟",
                    image: "/images/skin-progress.jpg",
                    created_at: new Date().toLocaleDateString(),
                    likes_count: 24,
                    comments_count: 8
                },
                {
                    title: "30-Day Beef Tallow Skin Transformation",
                    content: "Just completed my weekly measurements. Noticeable improvement in skin elasticity and reduction in fine lines. The data doesn't lie! 📊",
                    image: "/images/measurement-chart.jpg",
                    created_at: new Date(Date.now() - 24 * 60 * 60 * 1000).toLocaleDateString(),
                    likes_count: 18,
                    comments_count: 5
                }
            ];

            container.innerHTML = '';
            samplePosts.forEach(post => {
                const postElement = createPostElement(post, '30-Day Beef Tallow Skin Transformation');
                container.appendChild(postElement);
            });
        }

        // Show sample supplements when API fails
        function showSampleSupplements() {
            const container = document.getElementById('supplements-container');
            const sampleSupplements = [{
                    supplement_name: "Vitamin D3",
                    dosage: "2000 IU daily"
                },
                {
                    supplement_name: "Omega-3 Fish Oil",
                    dosage: "1000 mg daily"
                },
                {
                    supplement_name: "Zinc",
                    dosage: "30 mg daily"
                }
            ];

            container.innerHTML = '';
            sampleSupplements.forEach(supplement => {
                const supplementElement = createSupplementElement(supplement);
                container.appendChild(supplementElement);
            });
        }

        // Show error message
        function showError(containerId, message) {
            const container = document.getElementById(containerId);
            container.innerHTML = `
                <div class="text-center py-3">
                    <p class="text-danger">${message}</p>
                    <button class="btn btn-sm btn-outline-primary" onclick="location.reload()">Retry</button>
                </div>
            `;
        }
    </script>
@endsection
