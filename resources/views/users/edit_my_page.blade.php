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
        padding: 8px 15px;
        font-weight: 600;
    }

    .nav-tabs .nav-link:hover {
        border-radius: 11px;
        color: {{ $settings->theme_color_pwa ?? '#469DFA' }} !important;
        background: #E5F3F9 !important;
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
        justify-content: space-between;
        align-items: flex-start;
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
</style>

@section('content')
    <section style="padding: 40px 30px;">
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
                    <ul class="nav nav-tabs border-0 flex-wrap" id="experimentTabs" style="padding: 20px 0;">
                        <li class="nav-item">
                            <a class="nav-link active" href="#">Profile & Notifications</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Privacy & Security</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Subscription & Billing</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Help & FAQ</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">About & Terms</a>
                        </li>
                    </ul>
                </div>
            </div>
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
                                <input class="form-control" name="full_name" placeholder="{{ trans('auth.full_name') }}"
                                    value="{{ auth()->user()->name }}" type="text">
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
                            <input class="form-control" placeholder="{{ trans('auth.email') }}"
                                {!! auth()->user()->isSuperAdmin() ? 'name="email"' : 'disabled' !!} value="{{ auth()->user()->email }}"
                                type="text">
                        </div><!-- End form-group -->

                        <!-- Profile Photo Upload -->
                        <div class="form-group" style="padding-bottom: 1.2rem;">
                            <label>
                                <label style="width: auto;">Your photo</label>
                                <p style="color:#6c757d; margin-top:-5px; white-space: nowrap;">This will be displayed on your profile.</p>
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
                        <h2 style="color: #101828; font-size: 24px; font-weight: 600 !important;">Notification Preferences</h2>
                    </div>
                </div>
            </div>


            <div class="section">
                <div>
                    <div class="section-title">Comments</div>
                    <div class="section-desc">These are notifications for comments on your posts and replies to your comments.</div>
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
                <div>
                    <div class="section-title">Tags</div>
                    <div class="section-desc">These are notifications for when someone tags you in a comment, post or story.</div>
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
                <div>
                    <div class="section-title">Reminders</div>
                    <div class="section-desc">These are notifications to remind you of updates you might have missed.</div>
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
                <div>
                    <div class="section-title">More activity about you</div>
                    <div class="section-desc">These are notifications for posts on your profile, likes and other reactions to your posts, and more.</div>
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
@endsection
