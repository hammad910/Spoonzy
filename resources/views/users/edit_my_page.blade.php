@extends('layouts.app')

@section('title')
    {{ auth()->user()->verified_id == 'yes' ? trans('general.edit_my_page') : trans('users.edit_profile') }} -
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('public/plugins/datepicker/datepicker3.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('public/plugins/select2/select2.min.css') }}?v={{ $settings->version }}" rel="stylesheet"
        type="text/css" />
@endsection

<style>
    .main-sec {
        padding: 40px 30px;
    }

    @media (max-width: 425px) {
        .main-sec {
            padding: 40px 15px;
            width: 62%;
        }
    }

    @media (max-width: 375px) {
        .main-sec {
            padding: 40px 15px;
            width: 55%;
        }
    }

    @media (max-width: 340px) {
        .main-sec {
            padding: 40px 15px;
            width: 47%;
        }
    }

    .nav-link {
        padding: 0 1rem;
    } 

    .nav-tabs .nav-link {
        color: #475467;
        border: none;
        font-weight: 500;
        cursor: pointer;
    }

    .nav-tabs .nav-link.active {
        border-radius: 11px !important;
        color: {{ $settings->theme_color_pwa ?? '#469DFA' }} !important;
        background: #E5F3F9 !important;
        border: none;
        padding: 4px 15px;
        font-weight: 600;
    }

    .nav-tabs .nav-link:hover {
        border: none;
        color: #475467 !important;
        background: transparent;
        padding: 4px 15px !important;
        font-weight: 600 !important;
    }
    .nav-tabs .nav-link.active {
        color: {{ $settings->theme_color_pwa ?? '#469DFA' }} !important;
    }

    .form-group {
        display: flex;
        margin-bottom: 1.2rem !important;
        border-bottom: 1px solid #1C1C1C1A;
    }

    label {
        width: 25%;
        color: #101828;
        font-size: 14px;
        font-weight: 500;
    }

    input.form-control {
        border-radius: 8px;
    }

    .input-group {}

    .input-group .form-control:not(:first-child) {
        width: 50% !imprortant;
        border-radius: 8px;
    }



    .section {
        padding: 25px 0;
        border-bottom: 1px solid #e5e5e5;
        display: flex;
        /* justify-content: space-between; */
        gap: 35%;
        align-items: flex-start;
    }

    .main-heading {
        width: 40%;
    }


    .section:last-child {
        border-bottom: none;
    }


    .section-title {
        font-size: 14px;
        font-weight: 500;
        margin-bottom: 6px;
        color: #101828;
    }


    .section-desc {
        font-size: 14px;
        color: #475467;
    }


    .options {
        display: flex;
        flex-direction: column;
        gap: 30px;
        min-width: 260px;
    }


    .toggle-wrapper {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 16px;
        color: #475467;
        width: 50%;
        font-weight: 500;
    }

    .input-group {
        width: 50% !important;
    }

    input.form-control {
        width: 50% !important;
    }

    .upload {
        width: 50% !important;
    }

    @media (max-width: 786px) {
        .section {
            flex-direction: column;
            gap: 15px;
        }

        .form-group {
            flex-direction: column;
        }

        .input-group {
            width: 100% !important;
        }

        input.form-control {
            width: 100% !important;
        }

        .upload {
            width: 100% !important;
        }
    }

    /* Toggle Switch */
    .toggle {
        position: relative;
        width: 44px;
        height: 24px;
    }


    .toggle input {
        opacity: 0;
        width: 0;
        height: 0;
    }


    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #d6d6d6;
        transition: 0.3s;
        border-radius: 24px;
    }


    .slider:before {
        position: absolute;
        content: "";
        height: 18px;
        width: 18px;
        left: 3px;
        bottom: 3px;
        background-color: white;
        transition: 0.3s;
        border-radius: 50%;
    }


    input:checked+.slider {
        background-color: {{ $settings->theme_color_pwa ?? '#469DFA' }};
    }


    input:checked+.slider:before {
        transform: translateX(20px);
    }

    .privacy-sec {
        margin-top: 16px;
    }

    .privacy-block {
        margin-bottom: 40px;
    }

    .privacy-block h2 {
        font-size: 24px;
        font-weight: 600 !important;
        margin-bottom: 16px;
        color: #222;
    }

    .privacy-block p {
        font-size: 18px;
        line-height: 1.7;
        margin-bottom: 14px;
        color: #475467;
    }

    .privacy-block ol {
        margin-top: 10px;
        padding-left: 20px;
        font-size: 15px;
        line-height: 1.7;
        color: #444;
    }

    .subscription-wrapper {
        margin-top: 16px;
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    /* PLAN CARD */
    .plan-card {
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        cursor: pointer;
        transition: all 0.2s ease;
        background: #fff;
        margin-bottom: 15px;
    }

    .plan-card:hover {
        border-color: #93c5fd;
    }

    .plan-card.active {
        border: 2px solid {{ $settings->theme_color_pwa }};
    }

    .plan-header {
        /* display: flex; */
        align-items: center;
        gap: 8px;
        margin-bottom: 12px;
        padding: 10px 12px;
        border-bottom: 1px solid #EAECF0;
    }

    .plan-header.active {
        background: #E5F3F9;
        border-bottom: 2px solid {{ $settings->theme_color_pwa }};
        border-radius: 12px 12px 0 0;
    }

    .plan-content {
        padding: 2px 18px;
    }

    .plan-icon {
        width: 22px;
        height: 22px;
        border: 2px solid #d1d5db;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .plan-icon.selected {
        border: none;
        background: #3b82f6;
    }

    .plan-icon.selected svg {
        display: block;
    }

    .plan-icon svg {
        display: none;
        width: 14px;
        height: 14px;
        color: #fff;
    }

    .plan-icon.enterprise {
        background: #dbeafe;
        border: none;
    }

    .plan-icon.enterprise svg {
        display: block;
        color: #3b82f6;
    }

    .plan-title {
        font-size: 16px;
        font-weight: 600;
        color: #101828;
    }

    .plan-card.active .plan-title {
        color: {{ $settings->theme_color_pwa }};
    }

    .price {
        font-size: 30px;
        font-weight: 600 !important;
        color: #101828;
        line-height: 1.2;
    }

    .price span {
        font-size: 14px;
        font-weight: 400;
        color: #475467;
    }

    .plan-description {
        margin-top: 4px;
        font-size: 14px;
        color: #475467;
        line-height: 1.5;
    }

    /* BADGE */
    .badge {
        background: #ecfdf5;
        color: #059669;
        padding: 6px 12px;
        border-radius: 16px;
        font-size: 13px;
        font-weight: 500;
        white-space: nowrap;
    }

    /* PAYMENT SECTION */
    .payment-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 40px;
        margin-bottom: 16px;
    }

    .payment-title {
        font-size: 24px;
        font-weight: 600 !important;
        color: #101828;
    }

    .download-btn {
        display: flex;
        align-items: center;
        gap: 8px;
        background: #fff;
        border: 1px solid {{ $settings->theme_color_pwa }};
        color: {{ $settings->theme_color_pwa }};
        padding: 10px 16px;
        border-radius: 36px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
    }

    .download-btn:hover {
        background: #eff6ff;
    }

    .limited-btn {
        background: #ECFDF3;
        color: #027A48;
        padding: 4px 10px;
        border-radius: 36px;
        font-size: 14px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s;
    }

    .limited-btn:hover {
        background: #eff6ff;
    }

    /* PAYMENT TABLE */
    .payment-table {
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        overflow: hidden;
        min-width: 700px;
    }

    .payment-table-container {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        width: 100%;
        /* Smooth scrolling on iOS */
    }

    .payment-row {
        display: grid;
        grid-template-columns: 4fr 1fr 1fr 1fr 50px;
        padding: 16px 20px;
        border-bottom: 1px solid #e5e7eb;
        font-size: 14px;
        align-items: center;
    }

    .payment-row:last-child {
        border-bottom: none;
    }

    .payment-row.header {
        background: #F9FAFB;
        font-weight: 500;
        font-size: 14px;
        color: #475467;
        padding: 10px 20px;
    }

    .payment-row.header .invoice-col {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .payment-row.header .invoice-col svg {
        width: 14px;
        height: 14px;
    }

    .checkbox-col {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .checkbox {
        width: 18px;
        height: 18px;
        border: 2px solid #d1d5db;
        border-radius: 4px;
        cursor: pointer;
    }

    .invoice-name {
        font-weight: 500;
        color: #101828;
        font-size: 16px;
    }

    .amount-col {
        color: #475467;
        font-size: 14px;
        font-weight: 400;
    }

    .date-col {
        color: #475467;
        font-size: 14px;
        font-weight: 400;
    }

    /* STATUS */
    .status {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 13px;
        font-weight: 500;
    }

    .status.paid {
        color: #027A48;
        background: #ECFDF3;
        padding: 2px 9px;
        border-radius: 16px
    }

    .status.progress {
        color: #469DFA;
        background: #F0F9FF;
        padding: 12px 9px;
        border-radius: 16px
    }

    .status.declined {
        color: #FF5F59;
        background: #FFF0EF;
        padding: 2px 9px;
        border-radius: 16px
    }

    .download-icon {
        display: flex;
        justify-content: flex-end;
    }

    .download-icon svg {
        width: 20px;
        height: 20px;
        color: #9ca3af;
        cursor: pointer;
        transition: color 0.2s;
    }

    .download-icon svg:hover {
        color: #6b7280;
    }

    @media (max-width: 768px) {
        .payment-table-container {
            border-radius: 8px;
        }

        .payment-table {
            min-width: 650px;
            /* Slightly smaller min-width for mobile */
        }

        .payment-row {
            padding: 12px 16px;
        }

        .invoice-name {
            font-size: 14px;
        }

        .amount-col,
        .date-col {
            font-size: 13px;
        }

        .status {
            font-size: 12px;
        }
    }


    /* faq */
    .faq-section {
        margin: 0 auto;
        padding: 10px 20px;
    }

    .faq-header {
        margin-bottom: 32px;
    }

    .faq-header h1 {
        font-size: 24px;
        font-weight: 600 !important;
        color: #101828;
        margin-bottom: 12px;
    }

    .faq-header p {
        font-size: 16px;
        color: #475467;
        line-height: 1.5;
    }

    .faq-header a {
        color: #6b7280;
        text-decoration: underline;
    }

    .faq-header a:hover {
        color: #374151;
    }

    .faq-list {
        display: flex;
        flex-direction: column;
        gap: 0;
    }

    .faq-item {
        margin-bottom: 12px;
        overflow: hidden;
        transition: box-shadow 0.2s ease;
    }

    .faq-item:hover {
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
    }

    .faq-item.active {
        border-color: #00000012;
        box-shadow: 0 0 0 1px #00000012;
        background: #ffffff;
        border: 1px solid #00000012;
        border-radius: 12px;
    }

    .faq-question {
        width: 100%;
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 20px 24px;
        background: none;
        border: none;
        cursor: pointer;
        text-align: left;
    }

    .faq-question h3 {
        font-size: 16px;
        font-weight: 600;
        color: #111827;
        margin: 0;
    }

    .faq-icon {
        width: 28px;
        height: 28px;
        border: 2px solid #A2A9B2;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .faq-item.active .faq-icon {
        border-color: #469DFA;
        border: 2px solid #469DFA;
    }

    .faq-icon svg {
        width: 14px;
        height: 14px;
        stroke: #9ca3af;
        transition: all 0.3s ease;
    }

    .faq-item.active .faq-icon svg {
        stroke: #3b82f6;
    }

    .icon-plus {
        display: block;
    }

    .icon-minus {
        display: none;
    }

    .faq-item.active .icon-plus {
        display: none;
    }

    .faq-item.active .icon-minus {
        display: block;
    }

    .faq-answer {
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.3s ease;
    }

    .faq-answer-content {
        padding: 0 24px 20px 24px;
        font-size: 15px;
        color: #6b7280;
        line-height: 1.6;
    }

    .faq-item.active .faq-answer {
        max-height: 200px;
    }

    /* Responsive Styles */
    @media (max-width: 640px) {
        .faq-section {
            padding: 24px 16px;
        }

        .faq-header h1 {
            font-size: 20px;
        }

        .faq-header p {
            font-size: 14px;
        }

        .faq-question {
            padding: 16px 20px;
        }

        .faq-question h3 {
            font-size: 15px;
        }

        .faq-answer-content {
            padding: 0 20px 16px 20px;
            font-size: 14px;
        }

        .faq-icon {
            width: 24px;
            height: 24px;
        }

        .faq-icon svg {
            width: 12px;
            height: 12px;
        }
    }
</style>

@section('content')
    <section id="main-sec" style="padding: 40px 30px;">
        {{-- <div class="menu-sidebar d-none d-lg-block" style="width: 20%; border-right: 1px solid #ddd; padding: 20px;">
            @include('includes.menu-sidebar-home')
        </div> --}}
        <div>
            <div class="">
                <div>
                    <h2 class="mb-0" style=" color: #101828; font-size: 30px; font-weight: 600 !important; ">
                        {{-- {{ auth()->user()->verified_id == 'yes' ? trans('general.edit_my_page') : trans('users.edit_profile') }} --}}
                        Settings
                    </h2>
                    <ul class="nav nav-tabs border-0 flex-wrap align-items-center" id="experimentTabs" style="padding: 20px 0;">
                        <li class="nav-item">
                            <a class="nav-link active profile" href="#">Profile & Notifications</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link privacy" href="#">Privacy & Security</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link subscription" href="#">Subscription & Billing</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link faq" href="#">Help & FAQ</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link about" href="#">About & Terms</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="profile-sec">
                <div>

                    {{-- @include('includes.cards-settings') --}}

                    <div>

                        @if (session('status'))
                            <div class="alert alert-success">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>

                                {{ trans('admin.success_update') }}
                            </div>
                        @endif

                        @include('errors.errors-forms')

                        @include('includes.alert-payment-disabled')

                        <form method="POST" action="{{ url('settings/page') }}" id="formEditPage" accept-charset="UTF-8"
                            enctype="multipart/form-data">

                            @csrf

                            <input type="hidden" id="featured_content" name="featured_content"
                                value="{{ auth()->user()->featured_content }}">

                            <div class="form-group">
                                <label>{{ trans('auth.full_name') }}</label>
                                <div class="input-group width mb-4 ">
                                    <input class="form-control" name="full_name"
                                        placeholder="{{ trans('auth.full_name') }}" value="{{ auth()->user()->name }}"
                                        type="text">
                                </div>
                            </div><!-- End form-group -->

                            <div class="form-group">
                                <label>{{ trans('auth.username') }}</label>
                                <div class="input-group" style="margin-bottom: 20px;">
                                    <input class="form-control" name="username" maxlength="25"
                                        placeholder="{{ trans('auth.username') }}" value="{{ auth()->user()->username }}"
                                        type="text">
                                </div>
                            </div><!-- End form-group -->

                            <div class="form-group" style="padding-bottom: 1.2rem; ">
                                <label>Email</label>
                                <input class="form-control" placeholder="{{ trans('auth.email') }}" {!! auth()->user()->isSuperAdmin() ? 'name="email"' : 'disabled' !!}
                                    value="{{ auth()->user()->email }}" type="text">
                            </div><!-- End form-group -->

                            <!-- Profile Photo Upload -->
                            <div class="form-group" style="padding-bottom: 1.2rem;">
                                <label>
                                    <label style="width: auto;">Your photo</label>
                                    <p style="color:#6c757d; margin-top:-5px; white-space: nowrap;">This will be displayed
                                        on your profile.</p>
                                </label>

                                <div class="d-flex align-items-start gap-4 upload" style="margin-top: 1rem; gap: 32px;">

                                    <!-- Current Photo -->
                                    <div>
                                        <img src="{{ Helper::getFile(config('path.avatar') . Auth::user()->avatar) }}"
                                            alt="Profile"
                                            style="width:64px; height:64px; border-radius:50%; object-fit:cover;">
                                    </div>

                                    <!-- Upload Area -->
                                    <label class="upload-box"
                                        style="
                                    border: 1.5px solid #D0D5DD;
                                    border-radius: 12px;
                                    padding: 16px 24px;
                                    cursor: pointer;
                                    text-align: center;
                                    display: block;
                                    width: 100%;
                                ">
                                        <input type="file" name="avatar" accept="image/*" style="display:none;">

                                        <div style="margin-bottom:10px;">
                                            <img src="/images/i-icon-2.png" alt="">
                                        </div>

                                        <span style="color:{{ $settings->theme_color_pwa }}; font-weight:600;">Click to
                                            upload</span>
                                        <span style="color:#475467;"> or drag and drop</span>
                                        <p style="margin:6px 0 0; color:#475467;">
                                            SVG, PNG, JPG or GIF (max. 800×400px)
                                        </p>
                                    </label>

                                </div>
                            </div>

                            {{-- <div class="form-group" style="padding-bottom: 1.2rem; ">
                            <label>Email</label>
                            <input class="form-control" placeholder="{{ trans('auth.email') }}"
                            {!! auth()->user()->isSuperAdmin() ? 'name="email"' : 'disabled' !!} value="{{ auth()->user()->email }}"
                            type="text">
                        </div> --}}

                            @if (auth()->user()->password != '')
                                <div class="form-group">
                                    <label>Old Password</label>
                                    <div class="input-group mb-4">
                                        <input class="form-control" name="old_password"
                                            placeholder="{{ __('general.old_password') }}" type="password" required>
                                    </div>
                                </div>
                            @endif

                            <div class="form-group">
                                <label>New Password</label>
                                <div class="input-group mb-4" id="showHidePassword">
                                    <input class="form-control" name="new_password"
                                        placeholder="{{ __('general.new_password') }}" type="password" required>
                                </div>
                            </div>

                            {{-- <div class="row form-group mb-0">
                            <div class="col-md-6">
                                <div class="input-group mb-4">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-user-tie"></i></span>
                                    </div>
                                    <input class="form-control" name="profession"
                                        placeholder="{{ trans('users.profession_ocupation') }}"
                                        value="{{ auth()->user()->profession }}" type="text">
                                </div>
                            </div><!-- ./col-md-6 -->

                            <div class="col-md-6">
                                <div class="input-group mb-4">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-language"></i></span>
                                    </div>
                                    <select name="language" class="form-control custom-select">
                                        <option @if (auth()->user()->language == '') selected="selected" @endif value="">
                                            ({{ trans('general.language') }}) {{ __('general.not_specified') }}</option>
                                        @foreach (Languages::orderBy('name')->get() as $languages)
                                            <option @if (auth()->user()->language == $languages->abbreviation) selected="selected" @endif
                                                value="{{ $languages->abbreviation }}">{{ $languages->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div><!-- ./col-md-6 -->
                        </div><!-- End Row Form Group -->

                        <div class="row form-group mb-0">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-calendar-alt"></i></span>
                                    </div>
                                    <input class="form-control datepicker" @if (auth()->user()->birthdate_changed == 'yes') disabled @endif
                                        name="birthdate" placeholder="{{ trans('general.birthdate') }} "
                                        value="{{ auth()->user()->birthdate ?? date(Helper::formatDatepicker(), strtotime(auth()->user()->birthdate)) }}"
                                        autocomplete="off" type="text">
                                </div>
                                <small class="form-text text-muted mb-4">{{ trans('general.valid_formats') }}
                                    <strong>{{ now()->subYears(18)->format(Helper::formatDatepicker()) }}</strong> --
                                    <strong>({{ trans('general.birthdate_changed_info') }})</strong>
                                </small>
                            </div><!-- ./col-md-6 -->

                            <div class="col-md-6">
                                <div class="input-group mb-4">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-venus-mars"></i></span>
                                    </div>
                                    <select name="gender" class="form-control custom-select">
                                        <option @if (auth()->user()->gender == '') selected="selected" @endif
                                            value="">({{ trans('general.gender') }})
                                            {{ __('general.not_specified') }}</option>
                                        @foreach ($genders as $gender)
                                            <option @if (auth()->user()->gender == $gender) selected="selected" @endif
                                                value="{{ $gender }}">{{ __('general.' . $gender) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div><!-- ./col-md-6 -->
                        </div><!-- End Row Form Group -->

                        <div class="row form-group mb-0">

                            @if (auth()->user()->verified_id == 'yes')
                                <div class="col-md-12">
                                    <div class="input-group mb-4">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-link"></i></span>
                                        </div>
                                        <input class="form-control" name="website"
                                            placeholder="{{ trans('users.website') }}"
                                            value="{{ auth()->user()->website }}" type="text">
                                    </div>
                                </div><!-- ./col-md-12 -->

                                <div class="col-md-12" id="billing">
                                    <div class="input-group mb-4">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="far fa-lightbulb"></i></span>
                                        </div>
                                        <select name="categories_id[]" multiple class="form-control categoriesMultiple">
                                            @foreach (Categories::where('mode', 'on')->orderBy('name')->get() as $category)
                                                <option @if (in_array($category->id, $categories)) selected="selected" @endif
                                                    value="{{ $category->id }}">
                                                    {{ Lang::has('categories.' . $category->slug) ? __('categories.' . $category->slug) : $category->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div><!-- ./col-md-12 -->
                            @endif

                            <div class="col-lg-12 py-2">
                                <h6 class="text-muted">-- {{ trans('general.billing_information') }}</h6>
                            </div>

                            <div class="col-lg-12">
                                <div class="input-group mb-4">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-building"></i></span>
                                    </div>
                                    <input class="form-control" name="company"
                                        placeholder="{{ trans('general.company') }}"
                                        value="{{ auth()->user()->company }}" type="text">
                                </div>
                            </div><!-- ./col-md-6 -->

                            <div class="col-md-6">
                                <div class="input-group mb-4">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-globe"></i></span>
                                    </div>
                                    <select name="countries_id" class="form-control custom-select">
                                        <option value="">{{ trans('general.select_your_country') }} </option>
                                        @foreach (Countries::orderBy('country_name')->get() as $country)
                                            <option @if (auth()->user()->countries_id == $country->id) selected="selected" @endif
                                                value="{{ $country->id }}">{{ $country->country_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div><!-- ./col-md-6 -->

                            <div class="col-md-6">
                                <div class="input-group mb-4">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-map-pin"></i></span>
                                    </div>
                                    <input class="form-control" name="city" placeholder="{{ trans('general.city') }}"
                                        value="{{ auth()->user()->city }}" type="text">
                                </div>
                            </div><!-- ./col-md-6 -->

                            <div class="col-md-6 @if (auth()->user()->verified_id == 'no') scrollError @endif">
                                <div class="input-group mb-4">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-map-marked-alt"></i></span>
                                    </div>
                                    <input class="form-control" name="address"
                                        placeholder="{{ trans('general.address') }}"
                                        value="{{ auth()->user()->address }}" type="text">
                                </div>
                            </div><!-- ./col-md-6 -->

                            <div class="col-md-6">
                                <div class="input-group mb-4">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-map-marker-alt"></i></span>
                                    </div>
                                    <input class="form-control" name="zip" placeholder="{{ trans('general.zip') }}"
                                        value="{{ auth()->user()->zip }}" type="text">
                                </div>
                            </div><!-- ./col-md-6 -->

                        </div><!-- End Row Form Group --> --}}

                            {{-- @if (auth()->user()->verified_id == 'yes')
                            <div class="row form-group mb-0">
                                <div class="col-lg-12 py-2">
                                    <h6 class="text-muted">-- {{ trans('admin.profiles_social') }}</h6>
                                </div>

                                <div class="col-md-6">
                                    <div class="input-group mb-4">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fab fa-facebook-f"></i></span>
                                        </div>
                                        <input class="form-control" name="facebook"
                                            placeholder="https://facebook.com/username"
                                            value="{{ auth()->user()->facebook }}" type="text">
                                    </div>
                                </div><!-- ./col-md-6 -->

                                <div class="col-md-6">
                                    <div class="input-group mb-4">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="bi-twitter-x"></i></span>
                                        </div>
                                        <input class="form-control" name="twitter"
                                            placeholder="https://twitter.com/username"
                                            value="{{ auth()->user()->twitter }}" type="text">
                                    </div>
                                </div><!-- ./col-md-6 -->
                            </div><!-- End Row Form Group -->

                            <div class="row form-group mb-0">
                                <div class="col-md-6">
                                    <div class="input-group mb-4">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fab fa-instagram"></i></span>
                                        </div>
                                        <input class="form-control" name="instagram"
                                            placeholder="https://instagram.com/username"
                                            value="{{ auth()->user()->instagram }}" type="text">
                                    </div>
                                </div><!-- ./col-md-6 -->

                                <div class="col-md-6">
                                    <div class="input-group mb-4">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fab fa-youtube"></i></span>
                                        </div>
                                        <input class="form-control" name="youtube"
                                            placeholder="https://youtube.com/username"
                                            value="{{ auth()->user()->youtube }}" type="text">
                                    </div>
                                </div><!-- ./col-md-6 -->
                            </div><!-- End Row Form Group -->

                            <div class="row form-group mb-0">
                                <div class="col-md-6">
                                    <div class="input-group mb-4">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fab fa-pinterest-p"></i></span>
                                        </div>
                                        <input class="form-control" name="pinterest"
                                            placeholder="https://pinterest.com/username"
                                            value="{{ auth()->user()->pinterest }}" type="text">
                                    </div>
                                </div><!-- ./col-md-6 -->

                                <div class="col-md-6">
                                    <div class="input-group mb-4">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fab fa-github"></i></span>
                                        </div>
                                        <input class="form-control" name="github"
                                            placeholder="https://github.com/username"
                                            value="{{ auth()->user()->github }}" type="text">
                                    </div>
                                </div><!-- ./col-md-6 -->
                            </div><!-- End Row Form Group -->

                            <div class="row form-group mb-0">
                                <div class="col-md-6">
                                    <div class="input-group mb-4">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="bi-snapchat"></i></span>
                                        </div>
                                        <input class="form-control" name="snapchat"
                                            placeholder="https://www.snapchat.com/add/username"
                                            value="{{ auth()->user()->snapchat }}" type="text">
                                    </div>
                                </div><!-- ./col-md-6 -->

                                <div class="col-md-6">
                                    <div class="input-group mb-4">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="bi-tiktok"></i></span>
                                        </div>
                                        <input class="form-control" name="tiktok"
                                            placeholder="https://www.tiktok.com/@username"
                                            value="{{ auth()->user()->tiktok }}" type="text">
                                    </div>
                                </div><!-- ./col-md-6 -->
                            </div><!-- End Row Form Group -->

                            <div class="row form-group mb-0">
                                <div class="col-md-6">
                                    <div class="input-group mb-4">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="bi-telegram"></i></span>
                                        </div>
                                        <input class="form-control" name="telegram" placeholder="https://t.me/username"
                                            value="{{ auth()->user()->telegram }}" type="text">
                                    </div>
                                </div><!-- ./col-md-6 -->

                                <div class="col-md-6">
                                    <div class="input-group mb-4">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="bi-twitch"></i></span>
                                        </div>
                                        <input class="form-control" name="twitch"
                                            placeholder="https://www.twitch.tv/username"
                                            value="{{ auth()->user()->twitch }}" type="text">
                                    </div>
                                </div><!-- ./col-md-6 -->
                            </div><!-- End Row Form Group -->

                            <div class="row form-group mb-0">
                                <div class="col-md-6">
                                    <div class="input-group mb-4">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="bi-discord"></i></span>
                                        </div>
                                        <input class="form-control" name="discord"
                                            placeholder="https://discord.gg/username"
                                            value="{{ auth()->user()->discord }}" type="text">
                                    </div>
                                </div><!-- ./col-md-6 -->

                                <div class="col-md-6">
                                    <div class="input-group mb-4">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fab fa-vk"></i></span>
                                        </div>
                                        <input class="form-control" name="vk" placeholder="https://vk.com/username"
                                            value="{{ auth()->user()->vk }}" type="text">
                                    </div>
                                </div><!-- ./col-md-6 -->
                            </div><!-- End Row Form Group -->

                            <div class="row form-group mb-0">
                                <div class="col-md-6">
                                    <div class="input-group mb-4">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="bi-reddit"></i></span>
                                        </div>
                                        <input class="form-control" name="reddit"
                                            placeholder="https://reddit.com/user/username"
                                            value="{{ auth()->user()->reddit }}" type="text">
                                    </div>
                                </div><!-- ./col-md-6 -->

                                <div class="col-md-6">
                                    <div class="input-group mb-4">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="bi-spotify"></i></span>
                                        </div>
                                        <input class="form-control" name="spotify"
                                            placeholder="https://spotify.com/username"
                                            value="{{ auth()->user()->spotify }}" type="text">
                                    </div>
                                </div><!-- ./col-md-6 -->

                                <div class="col-md-6">
                                    <div class="input-group mb-4">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="bi-threads"></i></span>
                                        </div>
                                        <input class="form-control" name="threads"
                                            placeholder="https://threads.net/username"
                                            value="{{ auth()->user()->threads }}" type="text">
                                    </div>
                                </div><!-- ./col-md-6 -->

                                <div class="col-md-6">
                                    <div class="input-group mb-4">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fab fa-kickstarter"></i></span>
                                        </div>
                                        <input class="form-control" name="kick"
                                            placeholder="https://kick.com/username" value="{{ auth()->user()->kick }}"
                                            type="text">
                                    </div>
                                </div><!-- ./col-md-6 -->
                            </div><!-- End Row Form Group -->



                            <div class="form-group">
                                <label class="w-100"><i class="fa fa-bullhorn text-muted"></i>
                                    {{ trans('users.your_story') }} 
                                    <span id="the-count" class="float-right d-inline">
                                        <span id="current"></span>
                                        <span id="maximum">/ {{ $settings->story_length }}</span>
                                    </span>
                                </label>
                                <textarea name="story" id="story" rows="5" cols="40"
                                    class="form-control textareaAutoSize scrollError">{{ auth()->user()->story ? auth()->user()->story : old('story') }}</textarea>

                            </div><!-- End Form Group -->
                        @endif --}}

                            <!-- Alert -->
                            <div class="alert alert-danger my-3 display-none" id="errorUdpateEditPage">
                                <ul class="list-unstyled m-0" id="showErrorsUdpatePage">
                                    <li></li>
                                </ul>
                            </div><!-- Alert -->

                            <div style="width: 100%; display: flex; justify-content: end; gap: 16px;">
                                <button class="btn btn-1"
                                    style="color: {{ $settings->theme_color_pwa }}; background: transparent; border: 1px solid {{ $settings->theme_color_pwa }}; padding: 5px 35px; font-weight: 600">
                                    Cancel</button>
                                <button class="btn btn-1"
                                    style="color: white; background: {{ $settings->theme_color_pwa }}; padding: 5px 35px; font-weight: 600"
                                    data-msg-success="{{ trans('admin.success_update') }}" id="saveChangesEditPage"
                                    type="submit"><i></i> {{ trans('general.save_changes') }}</button>
                            </div>
                        </form>

                        <div>
                            <h2 style="color: #101828; font-size: 24px; font-weight: 600 !important;">Notification
                                Preferences</h2>
                        </div>
                    </div>
                </div>


                <div class="section">
                    <div class="main-heading">
                        <div class="section-title">Comments</div>
                        <div class="section-desc">These are notifications for comments on your posts and replies to your
                            comments.</div>
                    </div>
                    <div class="options">
                        <label class="toggle-wrapper">
                            <div class="toggle">
                                <input type="checkbox">
                                <span class="slider"></span>
                            </div>
                            Push
                        </label>
                        <label class="toggle-wrapper">
                            <div class="toggle">
                                <input type="checkbox">
                                <span class="slider"></span>
                            </div>
                            Email
                        </label>
                        <label class="toggle-wrapper">
                            <div class="toggle">
                                <input type="checkbox">
                                <span class="slider"></span>
                            </div>
                            SMS
                        </label>
                    </div>
                </div>
                <div class="section">
                    <div class="main-heading">
                        <div class="section-title">Tags</div>
                        <div class="section-desc">These are notifications for when someone tags you in a comment, post or
                            story.</div>
                    </div>
                    <div class="options">
                        <label class="toggle-wrapper">
                            <div class="toggle">
                                <input type="checkbox">
                                <span class="slider"></span>
                            </div>
                            Push
                        </label>
                        <label class="toggle-wrapper">
                            <div class="toggle">
                                <input type="checkbox">
                                <span class="slider"></span>
                            </div>
                            Email
                        </label>
                        <label class="toggle-wrapper">
                            <div class="toggle">
                                <input type="checkbox">
                                <span class="slider"></span>
                            </div>
                            SMS
                        </label>
                    </div>
                </div>
                <div class="section">
                    <div class="main-heading">
                        <div class="section-title">Reminders</div>
                        <div class="section-desc">These are notifications to remind you of updates you might have missed.
                        </div>
                    </div>
                    <div class="options">
                        <label class="toggle-wrapper">
                            <div class="toggle">
                                <input type="checkbox">
                                <span class="slider"></span>
                            </div>
                            Push
                        </label>
                        <label class="toggle-wrapper">
                            <div class="toggle">
                                <input type="checkbox">
                                <span class="slider"></span>
                            </div>
                            Email
                        </label>
                        <label class="toggle-wrapper">
                            <div class="toggle">
                                <input type="checkbox">
                                <span class="slider"></span>
                            </div>
                            SMS
                        </label>
                    </div>
                </div>
                <div class="section">
                    <div class="main-heading">
                        <div class="section-title">More activity about you</div>
                        <div class="section-desc">These are notifications for posts on your profile, likes and other
                            reactions to your posts, and more.</div>
                    </div>
                    <div class="options">
                        <label class="toggle-wrapper">
                            <div class="toggle">
                                <input type="checkbox">
                                <span class="slider"></span>
                            </div>
                            Push
                        </label>
                        <label class="toggle-wrapper">
                            <div class="toggle">
                                <input type="checkbox">
                                <span class="slider"></span>
                            </div>
                            Email
                        </label>
                        <label class="toggle-wrapper">
                            <div class="toggle">
                                <input type="checkbox">
                                <span class="slider"></span>
                            </div>
                            SMS
                        </label>
                    </div>
                </div>
            </div>
            <div class="privacy-sec" style="display: none">
                <section class="privacy-block">
                    <h2>What information do we collect?</h2>
                    <p>
                        Mi tincidunt elit, id quisque ligula ac diam, amet. Vel etiam suspendisse morbi eleifend faucibus
                        eget vestibulum felis. Dictum quis montes, sit sit. Tellus aliquam enim urna, etiam. Mauris posuere
                        vulputate arcu amet, vitae nisi, tellus tincidunt. At feugiat sapien varius id.
                    </p>
                    <p>
                        Eget quis mi enim, leo lacinia pharetra, semper. Eget in volutpat mollis at volutpat lectus velit,
                        sed auctor. Porttitor fames arcu quis fusce augue enim. Quis at habitant diam at. Suscipit tristique
                        risus, at donec. In turpis vel et quam imperdiet. Ipsum molestie aliquet sodales id est ac volutpat.
                    </p>
                </section>

                <section class="privacy-block">
                    <h2>What information do we collect?</h2>
                    <p>
                        Dolor enim eu tortor urna sed duis nulla. Aliquam vestibulum, nulla odio nisl vitae. In aliquet
                        pellentesque aenean hac vestibulum turpis mi bibendum diam. Tempor integer aliquam in vitae
                        malesuada
                        fringilla.
                    </p>
                    <p>
                        Elit nisi in eleifend sed nisi. Pulvinar at orci, proin imperdiet commodo consectetur convallis
                        risus.
                        Sed condimentum enim dignissim adipiscing faucibus consequat, urna. Viverra purus et erat auctor
                        aliquam.
                        Risus, volutpat vulputate posuere purus sit congue convallis aliquet. Arcu id augue ut feugiat donec
                        porttitor neque. Mauris, neque ultricies eu vestibulum, bibendum quam lorem id. Dolor lacus, eget
                        nunc
                        lectus in tellus, pharetra, porttitor.
                    </p>
                    <p>
                        Ipsum sit mattis nulla quam nulla. Gravida id gravida ac enim mauris id. Non pellentesque congue
                        eget
                        consectetur turpis. Sapien, dictum molestie sem tempor. Diam elit, orci, tincidunt aenean tempus.
                        Quis
                        velit eget ut tortor tellus. Sed vel, congue felis elit erat nam nibh orci.
                    </p>
                </section>

                <section class="privacy-block">
                    <h2>How do we use your information?</h2>
                    <p>
                        Dolor enim eu tortor urna sed duis nulla. Aliquam vestibulum, nulla odio nisl vitae. In aliquet
                        pellentesque aenean hac vestibulum turpis mi bibendum diam. Tempor integer aliquam in vitae
                        malesuada
                        fringilla.
                    </p>
                    <p>
                        Elit nisi in eleifend sed nisi. Pulvinar at orci, proin imperdiet commodo consectetur convallis
                        risus.
                        Sed condimentum enim dignissim adipiscing faucibus consequat, urna. Viverra purus et erat auctor
                        aliquam.
                        Risus, volutpat vulputate posuere purus sit congue convallis aliquet. Arcu id augue ut feugiat donec
                        porttitor neque. Mauris, neque ultricies eu vestibulum, bibendum quam lorem id. Dolor lacus, eget
                        nunc
                        lectus in tellus, pharetra, porttitor.
                    </p>
                    <p>
                        Ipsum sit mattis nulla quam nulla. Gravida id gravida ac enim mauris id. Non pellentesque congue
                        eget
                        consectetur turpis. Sapien, dictum molestie sem tempor. Diam elit, orci, tincidunt aenean tempus.
                        Quis
                        velit eget ut tortor tellus. Sed vel, congue felis elit erat nam nibh orci.
                    </p>
                </section>
                <section class="privacy-block">
                    <h2>Do we use cookies and other tracking technologies?</h2>
                    <p>
                        Dolor enim eu tortor urna sed duis nulla. Aliquam vestibulum, nulla odio nisl vitae. In aliquet
                        pellentesque aenean hac vestibulum turpis mi bibendum diam. Tempor integer aliquam in vitae
                        malesuada
                        fringilla.
                    </p>
                </section>
                <section class="privacy-block">
                    <h2>How long do we keep your information?</h2>
                    <p>
                        Dolor enim eu tortor urna sed duis nulla. Aliquam vestibulum, nulla odio nisl vitae. In aliquet
                        pellentesque aenean hac vestibulum turpis mi bibendum diam. Tempor integer aliquam in vitae
                        malesuada
                        fringilla.
                    </p>
                </section>
                <section class="privacy-block">
                    <h2>How do we keep your information safe?</h2>
                    <p>
                        Dolor enim eu tortor urna sed duis nulla. Aliquam vestibulum, nulla odio nisl vitae. In aliquet
                        pellentesque aenean hac vestibulum turpis mi bibendum diam. Tempor integer aliquam in vitae
                        malesuada
                        fringilla.
                    </p>
                </section>
                <section class="privacy-block">
                    <h2>What are your privacy rights?</h2>
                    <p>
                        Dolor enim eu tortor urna sed duis nulla. Aliquam vestibulum, nulla odio nisl vitae. In aliquet
                        pellentesque aenean hac vestibulum turpis mi bibendum diam. Tempor integer aliquam in vitae
                        malesuada
                        fringilla.
                    </p>
                </section>
                <section class="privacy-block">
                    <h2>How can you contact us about this policy?</h2>
                    <p>
                        Dolor enim eu tortor urna sed duis nulla. Aliquam vestibulum, nulla odio nisl vitae.
                        In aliquet pellentesque aenean hac vestibulum turpis mi bibendum diam.
                        Tempor integer aliquam in vitae malesuada fringilla.
                    </p>

                    <p>
                        1. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                        2. Vestibulum posuere nunc eget urna facilisis faucibus.
                        3. Aliquam luctus magna vitae odio ultrices elementum.
                    </p>
                </section>

            </div>

            <div class="subscription-wrapper">

                <!-- PLAN CARDS -->
                <div class="plan-card active">
                    <div class="plan-content-wrapper">
                        <div class="plan-header active">
                            <div class="d-flex align-items-center" style="justify-content: space-between;">
                                <div style="display: flex; align-items: center;">
                                    <img src="/images/subscription-icon.png" alt="">
                                    <span class="plan-title">Basic plan</span>
                                </div>
                                <div>
                                    <img src="/images/check.png" alt="">
                                </div>
                            </div>
                        </div>
                        <div class="plan-content">
                            <div class="d-flex" style="justify-content: space-between;">
                                <div class="price">$10
                                    <span>per month</span>
                                </div>
                                <div>
                                    <button class="limited-btn">
                                        Limited time only
                                    </button>
                                </div>
                            </div>
                            <p class="plan-description">Includes up to 10 users, 20GB individual data and access to all
                                features.</p>
                        </div>
                    </div>
                </div>

                <div class="plan-card">
                    <div class="plan-content-wrapper">
                        <div class="plan-header align-items-center">
                            <div class="d-flex align-items-center" style="justify-content: space-between;">
                                <div style="display: flex; align-items: center; gap: 4px;">
                                    <div>
                                        <img src="/images/subscription-icon.png" alt="">
                                    </div>
                                    <span class="plan-title">Business plan</span>
                                </div>
                                <div>
                                    <img src="/images/radio.png" alt="">
                                </div>
                            </div>
                        </div>
                        <div class="plan-content">
                            <div class="price">$20 <span>per month</span></div>
                            <p class="plan-description">Includes up to 20 users, 40GB individual data and access to all
                                features.</p>
                        </div>
                    </div>
                </div>
                <div class="plan-card">
                    <div class="plan-content-wrapper">
                        <div class="plan-header align-items-center">
                            <div class="d-flex align-items-center" style="justify-content: space-between;">
                                <div style="display: flex; align-items: center; gap: 4px;">
                                    <div>
                                        <img src="/images/enterprise.png" alt="">
                                    </div>
                                    <span class="plan-title">Enterprise plan</span>
                                </div>
                                <div>
                                    <img src="/images/radio.png" alt="">
                                </div>
                            </div>
                        </div>
                        <div class="plan-content">
                            <div class="price">$40 <span>per month</span></div>
                            <p class="plan-description">Unlimited users, unlimited individual data and access to all
                                features</p>
                        </div>
                    </div>
                </div>

                <!-- PAYMENT HISTORY HEADER -->
                <div class="payment-header">
                    <h2 class="payment-title">Payment history</h2>
                    <button class="download-btn">
                        <img src="/images/download.png" alt="">
                        Download all
                    </button>
                </div>

                <!-- PAYMENT TABLE -->
                <div class="payment-table-container">
                    <div class="payment-table">
                        <div class="payment-row header">
                            <div class="checkbox-col">
                                <div class="checkbox"></div>
                                <div class="invoice-col">
                                    Invoice
                                    <img src="/images/arrow-icon.png" alt="">
                                </div>
                            </div>
                            <div>Amount</div>
                            <div>Date</div>
                            <div>Status</div>
                            <div></div>
                        </div>

                        <div class="payment-row">
                            <div class="checkbox-col">
                                <div class="checkbox"></div>
                                <span class="invoice-name">Basic Plan – Dec 2025</span>
                            </div>
                            <div class="amount-col">USD $10.00</div>
                            <div class="date-col">Dec 1, 2022</div>
                            <div class="d-flex align-items-center" style="gap: 4px;">
                                <div class="status declined">
                                    <img src="/images/cross.png" alt="">
                                    <span class="">Declined</span>
                                </div>
                            </div>
                            <div class="download-icon">
                                <img src="/images/download-icon.png" alt="">
                            </div>
                        </div>

                        <div class="payment-row">
                            <div class="checkbox-col">
                                <div class="checkbox"></div>
                                <span class="invoice-name">Basic Plan – Nov 2025</span>
                            </div>
                            <div class="amount-col">USD $10.00</div>
                            <div class="date-col">Nov 1, 2022</div>
                            <div class="d-flex align-items-center" style="gap: 4px;">
                                <div class="status paid">
                                    <img src="/images/paid-check.png" alt="">
                                    <span class="">Paid</span>
                                </div>
                            </div>
                            <div class="download-icon">
                                <img src="/images/download-icon.png" alt="">
                            </div>
                        </div>

                        <div class="payment-row">
                            <div class="checkbox-col">
                                <div class="checkbox"></div>
                                <span class="invoice-name">Basic Plan – Oct 2025</span>
                            </div>
                            <div class="amount-col">USD $10.00</div>
                            <div class="date-col">Oct 1, 2022</div>
                            <div class="d-flex align-items-center" style="gap: 4px;">
                                <div class="status progress">
                                    <img src="/images/dot.png" alt="">
                                    <span class="">In progress</span>
                                </div>
                            </div>
                            <div class="download-icon">
                                <img src="/images/download-icon.png" alt="">
                            </div>
                        </div>
                        <div class="payment-row">
                            <div class="checkbox-col">
                                <div class="checkbox"></div>
                                <span class="invoice-name">Basic Plan – Dec 2025</span>
                            </div>
                            <div class="amount-col">USD $10.00</div>
                            <div class="date-col">Dec 1, 2022</div>
                            <div class="d-flex align-items-center" style="gap: 4px;">
                                <div class="status declined">
                                    <img src="/images/cross.png" alt="">
                                    <span class="">Declined</span>
                                </div>
                            </div>
                            <div class="download-icon">
                                <img src="/images/download-icon.png" alt="">
                            </div>
                        </div>

                        <div class="payment-row">
                            <div class="checkbox-col">
                                <div class="checkbox"></div>
                                <span class="invoice-name">Basic Plan – Nov 2025</span>
                            </div>
                            <div class="amount-col">USD $10.00</div>
                            <div class="date-col">Nov 1, 2022</div>
                            <div class="d-flex align-items-center" style="gap: 4px;">
                                <div class="status paid">
                                    <img src="/images/paid-check.png" alt="">
                                    <span class="">Paid</span>
                                </div>
                            </div>
                            <div class="download-icon">
                                <img src="/images/download-icon.png" alt="">
                            </div>
                        </div>

                        <div class="payment-row">
                            <div class="checkbox-col">
                                <div class="checkbox"></div>
                                <span class="invoice-name">Basic Plan – Oct 2025</span>
                            </div>
                            <div class="amount-col">USD $10.00</div>
                            <div class="date-col">Oct 1, 2022</div>
                            <div class="d-flex align-items-center" style="gap: 4px;">
                                <div class="status progress">
                                    <img src="/images/dot.png" alt="">
                                    <span class="">In progress</span>
                                </div>
                            </div>
                            <div class="download-icon">
                                <img src="/images/download-icon.png" alt="">
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="faq-section">
                <div class="faq-header">
                    <h1>FAQs</h1>
                    <p>Everything you need to know about the product and billing. Can't find the answer you're looking
                        for?<br>Please <a href="#">chat to our friendly team</a>.</p>
                </div>

                <div class="faq-list">
                    <div class="faq-item">
                        <button class="faq-question">
                            <h3>Is there a free trial available?</h3>
                            <div class="faq-icon">
                                <svg class="icon-plus" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2">
                                    <line x1="12" y1="5" x2="12" y2="19"></line>
                                    <line x1="5" y1="12" x2="19" y2="12"></line>
                                </svg>
                                <svg class="icon-minus" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2">
                                    <line x1="5" y1="12" x2="19" y2="12"></line>
                                </svg>
                            </div>
                        </button>
                        <div class="faq-answer">
                            <div class="faq-answer-content">
                                Yes, you can try us for free for 30 days. If you want, we’ll provide you with a free,
                                personalized 30-minute onboarding call to get you up and running as soon as possible.
                            </div>
                        </div>
                    </div>
                    <div class="faq-item">
                        <button class="faq-question">
                            <h3>Can I change my plan later?</h3>
                            <div class="faq-icon">
                                <svg class="icon-plus" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2">
                                    <line x1="12" y1="5" x2="12" y2="19"></line>
                                    <line x1="5" y1="12" x2="19" y2="12"></line>
                                </svg>
                                <svg class="icon-minus" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2">
                                    <line x1="5" y1="12" x2="19" y2="12"></line>
                                </svg>
                            </div>
                        </button>
                        <div class="faq-answer">
                            <div class="faq-answer-content">
                                Yes, you can try us for free for 30 days. If you want, we’ll provide you with a free,
                                personalized 30-minute onboarding call to get you up and running as soon as possible.
                            </div>
                        </div>
                    </div>
                    <div class="faq-item">
                        <button class="faq-question">
                            <h3>What is your cancellation policy?</h3>
                            <div class="faq-icon">
                                <svg class="icon-plus" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2">
                                    <line x1="12" y1="5" x2="12" y2="19"></line>
                                    <line x1="5" y1="12" x2="19" y2="12"></line>
                                </svg>
                                <svg class="icon-minus" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2">
                                    <line x1="5" y1="12" x2="19" y2="12"></line>
                                </svg>
                            </div>
                        </button>
                        <div class="faq-answer">
                            <div class="faq-answer-content">
                                Yes, you can try us for free for 30 days. If you want, we’ll provide you with a free,
                                personalized 30-minute onboarding call to get you up and running as soon as possible.
                            </div>
                        </div>
                    </div>
                    <div class="faq-item">
                        <button class="faq-question">
                            <h3>Can I change my plan later?</h3>
                            <div class="faq-icon">
                                <svg class="icon-plus" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2">
                                    <line x1="12" y1="5" x2="12" y2="19"></line>
                                    <line x1="5" y1="12" x2="19" y2="12"></line>
                                </svg>
                                <svg class="icon-minus" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2">
                                    <line x1="5" y1="12" x2="19" y2="12"></line>
                                </svg>
                            </div>
                        </button>
                        <div class="faq-answer">
                            <div class="faq-answer-content">
                                Yes, you can try us for free for 30 days. If you want, we’ll provide you with a free,
                                personalized 30-minute onboarding call to get you up and running as soon as possible.
                            </div>
                        </div>
                    </div>
                    <div class="faq-item">
                        <button class="faq-question">
                            <h3>Can other info be added to an invoice?</h3>
                            <div class="faq-icon">
                                <svg class="icon-plus" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2">
                                    <line x1="12" y1="5" x2="12" y2="19"></line>
                                    <line x1="5" y1="12" x2="19" y2="12"></line>
                                </svg>
                                <svg class="icon-minus" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2">
                                    <line x1="5" y1="12" x2="19" y2="12"></line>
                                </svg>
                            </div>
                        </button>
                        <div class="faq-answer">
                            <div class="faq-answer-content">
                                Yes, you can try us for free for 30 days. If you want, we’ll provide you with a free,
                                personalized 30-minute onboarding call to get you up and running as soon as possible.
                            </div>
                        </div>
                    </div>
                    <div class="faq-item">
                        <button class="faq-question">
                            <h3>How does billing work?</h3>
                            <div class="faq-icon">
                                <svg class="icon-plus" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2">
                                    <line x1="12" y1="5" x2="12" y2="19"></line>
                                    <line x1="5" y1="12" x2="19" y2="12"></line>
                                </svg>
                                <svg class="icon-minus" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2">
                                    <line x1="5" y1="12" x2="19" y2="12"></line>
                                </svg>
                            </div>
                        </button>
                        <div class="faq-answer">
                            <div class="faq-answer-content">
                                Yes, you can try us for free for 30 days. If you want, we’ll provide you with a free,
                                personalized 30-minute onboarding call to get you up and running as soon as possible.
                            </div>
                        </div>
                    </div>
                    <div class="faq-item">
                        <button class="faq-question">
                            <h3>How do I change my account email?</h3>
                            <div class="faq-icon">
                                <svg class="icon-plus" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2">
                                    <line x1="12" y1="5" x2="12" y2="19"></line>
                                    <line x1="5" y1="12" x2="19" y2="12"></line>
                                </svg>
                                <svg class="icon-minus" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2">
                                    <line x1="5" y1="12" x2="19" y2="12"></line>
                                </svg>
                            </div>
                        </button>
                        <div class="faq-answer">
                            <div class="faq-answer-content">
                                Yes, you can try us for free for 30 days. If you want, we’ll provide you with a free,
                                personalized 30-minute onboarding call to get you up and running as soon as possible.
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        </div><!-- end col-md-6 -->
        </div>
        </div>
    </section>
@endsection

@section('javascript')
    <script src="{{ asset('public/plugins/datepicker/bootstrap-datepicker.js') }}"></script>
    @if (config('app.locale') != 'en')
        <script src="{{ asset('public/plugins/datepicker/locales/bootstrap-datepicker.' . config('app.locale') . '.js') }}">
        </script>
    @endif

    <script src="{{ asset('public/plugins/select2/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/plugins/select2/i18n/' . config('app.locale') . '.js') }}" type="text/javascript">
    </script>

    <script type="text/javascript">
        @if (auth()->user()->verified_id == 'yes')
            $('#current').html($('#story').val().length);
        @endif

        $('.categoriesMultiple').select2({
            tags: false,
            tokenSeparators: [','],
            maximumSelectionLength: {{ $settings->limit_categories }},
            placeholder: '{{ trans('admin.categories') }}',
            language: {
                maximumSelected: function() {
                    return "{{ trans('general.maximum_selected_categories', ['limit' => $settings->limit_categories]) }}";
                },
                searching: function() {
                    return "{{ trans('general.searching') }}";
                },
                noResults: function() {
                    return '{{ trans('general.no_results') }}';
                }
            }
        });

        $('.datepicker').datepicker({
            format: '{{ Helper::formatDatepicker(true) }}',
            startDate: '01/01/1920',
            endDate: '{{ now()->subYears(18)->format(Helper::formatDatepicker()) }}',
            language: '{{ config('app.locale') }}'
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const mainSec = document.querySelector("#main-sec");

            const profileBtn = document.querySelector(".profile");
            const privacyBtn = document.querySelector(".privacy");
            const subscriptionBtn = document.querySelector(".subscription");
            const aboutBtn = document.querySelector(".about");
            const faqBtn = document.querySelector(".faq");

            const profileSec = document.querySelector(".profile-sec");
            const privacySec = document.querySelector(".privacy-sec");
            const subscriptionSec = document.querySelector(".subscription-wrapper"); // Fixed selector
            const faqSec = document.querySelector(".faq-section"); // Fixed selector

            function resetActive() {
                profileBtn.classList.remove("active");
                privacyBtn.classList.remove("active");
                subscriptionBtn.classList.remove("active");
                faqBtn.classList.remove("active");
                aboutBtn.classList.remove("active");
                mainSec.classList.remove("main-sec");
            }

            function hideAll() {
                profileSec.style.display = "none";
                privacySec.style.display = "none";
                subscriptionSec.style.display = "none";
                faqSec.style.display = "none";
            }

            profileBtn.addEventListener("click", function(e) {
                e.preventDefault(); // Prevent default behavior
                resetActive();
                hideAll();
                this.classList.add("active");
                profileSec.style.display = "block";
            });

            privacyBtn.addEventListener("click", function(e) {
                e.preventDefault(); // Prevent default behavior
                resetActive();
                hideAll();
                this.classList.add("active");
                privacySec.style.display = "block";
            });

            subscriptionBtn.addEventListener("click", function(e) {
                e.preventDefault(); // Prevent default behavior
                resetActive();
                hideAll();
                this.classList.add("active");
                mainSec.classList.add("main-sec");
                subscriptionSec.style.display = "block";
            });
            faqBtn.addEventListener("click", function(e) {
                e.preventDefault(); // Prevent default behavior
                resetActive();
                hideAll();
                this.classList.add("active");
                faqSec.style.display = "block";
            });
            aboutBtn.addEventListener("click", function(e) {
                e.preventDefault(); // Prevent default behavior
                resetActive();
                this.classList.add("active");
            });

            // Set initial state - show profile section by default
            hideAll();
            profileSec.style.display = "block";
            const faqQuestions = document.querySelectorAll('.faq-question');

            faqQuestions.forEach(function(question) {
                question.addEventListener('click', function() {
                    const faqItem = this.parentElement;
                    const isActive = faqItem.classList.contains('active');

                    // Close all FAQ items
                    document.querySelectorAll('.faq-item').forEach(function(item) {
                        item.classList.remove('active');
                    });

                    // If the clicked item wasn't active, open it
                    if (!isActive) {
                        faqItem.classList.add('active');
                    }
                });
            });
        });
    </script>
@endsection
