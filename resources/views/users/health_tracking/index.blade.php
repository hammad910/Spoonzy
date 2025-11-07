@extends('layouts.app')

@section('title')
    Health Tracking -
@endsection

@section('css')
    <style>
        .health-container {
            padding: 32px;
        }

        .card-ht {
            background: var(--card);
            border-radius: 14px;
            padding: 18px;
            box-shadow: var(--soft-shadow);
            border: 0;
            height: 100%;
        }

        .mood-widget {
            height: 240px;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            border-radius: 14px;
            background: radial-gradient(circle at 40% 30%, rgba(151, 139, 255, 0.12), transparent 20%),
                radial-gradient(circle at 70% 70%, rgba(99, 232, 255, 0.06), transparent 30%),
                var(--card);
            box-shadow: var(--shadow);
        }

        .mood-inner {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            background: linear-gradient(180deg, #fff, #f8fbff);
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 8px 24px rgba(99, 102, 241, 0.08), inset 0 -6px 10px rgba(0, 0, 0, 0.03);
            flex-direction: column;
        }

        .mood-score {
            font-size: 36px;
            font-weight: 800;
            color: #2b6cb0;
        }

        .top-right-btn {
            border-radius: 999px;
            padding: 8px 14px;
            background: {{ $settings->theme_color_pwa ?? '#7f67ff' }};
            color: #fff;
            box-shadow: 0 8px 20px rgba(127, 103, 255, 0.12);
            font-weight: 600;
            border: none;
        }

        .med-card {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 2px 20px rgba(0, 0, 0, 0.05);
            padding: 24px;
        }

        .med-header {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 20px;
        }

        .med-header h5 {
            font-weight: 600;
            margin: 0;
            color: #222;
        }

        .med-days {
            display: flex;
            justify-content: space-between;
            border-bottom: 1px dashed #e6e6e6;
            padding-bottom: 12px;
            color: #666;
            font-size: 14px;
            font-weight: 500;
        }

        .med-list {
            margin-top: 20px;
            display: flex;
            flex-direction: column;
            gap: 14px;
        }

        .med-item {
            background: #f7f9fb;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 16px;
            font-size: 14px;
            color: #222;
            font-weight: 500;
        }

        .med-item small {
            color: #888;
            font-weight: 400;
        }

        .med-time {
            color: #666;
            font-size: 13px;
        }

        @media (max-width: 1199px) {
            .health-container {
                padding: 20px;
            }
        }

        @media (max-width: 767px) {
            .health-container {
                padding: 12px;
            }
            .kpi-cards {
                gap: 12px;
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
    </style>
@endsection

@section('content')
    <div class="d-flex" style="min-height: 100vh; background: #FBFBFB;">
        <!-- Sidebar -->
        <div class="menu-sidebar d-none d-lg-block"
            style="width: 20%; border-right: 1px solid #ddd; padding: 20px;">
            @include('includes.menu-sidebar-home')
        </div>

        <!-- Main Content -->
        <div class="flex-grow-1 health-container main-content">
            <div class="d-flex justify-content-between align-items-start mb-4 flex-wrap gap-3">
                <div>
                    <h1 class="h3 mb-0" style="color: #101828;">Health Tracking</h1>
                    <p class="text-muted mb-0">Overview of your latest health metrics</p>
                </div>
                {{-- <button class="top-right-btn">+ Make new Entry</button> --}}
            </div>

            <!-- KPI Cards -->
            <div class="row g-4 mb-4 kpi-cards">
                <div class="col-xl-4 col-lg-6 col-md-6">
                    <div class="card shadow border-0 p-3 h-100" style="border-radius: 20px">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 class="fw-semibold text-dark mb-3">Heart rate</h6>
                                <img src="/images/chart.png" alt="" style="height: 40px;">
                            </div>
                            <div class="text-end">
                                <h1 class="fw-bold text-dark mb-0" style="font-size: 42px;">89<span class="text-muted"
                                        style="font-size: 20px;"> bpm</span></h1>
                                <small class="text-muted d-block">Reduce caffeine</small>
                                <small class="text-muted">60 - 100 beats/min</small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-4 col-lg-6 col-md-6">
                    <div class="card shadow border-0 p-3 h-100" style="border-radius: 20px">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 class="fw-semibold text-dark mb-3">Hydration level</h6>
                                <img src="/images/hydration.png" alt="" style="height: 40px;">
                            </div>
                            <div class="text-end">
                                <h1 class="fw-bold text-dark mb-0" style="font-size: 42px;">80<span class="text-muted"
                                        style="font-size: 20px;">%</span></h1>
                                <small class="text-muted d-block">130 ml mineral water</small>
                                <small class="text-muted">Goal: 2L/day</small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-4 col-lg-6 col-md-6">
                    <div class="card shadow border-0 p-3 h-100" style="border-radius: 20px">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 class="fw-semibold text-dark mb-3">Blood cells</h6>
                                <img src="/images/blood-cell.png" alt="" style="height: 40px;">
                            </div>
                            <div class="text-end">
                                <h1 class="fw-bold text-dark mb-0" style="font-size: 42px;">1100<span class="text-muted"
                                        style="font-size: 20px;">ul</span></h1>
                                <small class="text-muted d-block">Need more sleep</small>
                                <small class="text-muted">4k - 11k normal</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Second Row -->
            <div class="row g-4 mb-4" style="padding-bottom: 20px; padding-top: 20px;">
                <div class="col-xl-4 col-lg-6 col-md-6">
                    <div class="card-ht bg-white">
                        <div class="d-flex align-items-center mb-2">
                            <img src="/images/bristol-scale-icon.png" alt="">
                            <h6 class="ms-2 mb-0 text-dark fw-bold">Bristol Scale</h6>
                        </div>
                        <p class="text-muted small mb-3">Lorem ipsum dolor sit amet consectetur.</p>
                        <div class="d-flex align-items-center justify-content-center">
                            <img src="/images/today-score.png" alt="">
                        </div>
                    </div>
                </div>

                <div class="col-xl-4 col-lg-6 col-md-6">
                    <div class="mood-widget">
                        <div class="mood-inner">
                            <img src="/images/health-widget-2.png" style="width: 170%" alt="Health Widget">
                        </div>
                    </div>
                </div>

                <div class="col-xl-4 col-lg-6 col-md-6">
                    <div class="card-ht bg-white">
                        <div class="d-flex align-items-center mb-2">
                            <img src="/images/bristol-scale-icon.png" alt="">
                            <h6 class="ms-2 mb-0 text-dark fw-bold">Sleep Overview</h6>
                        </div>
                        <p class="text-muted small mb-3">Lorem ipsum dolor sit amet consectetur.</p>
                        <div class="d-flex align-items-center justify-content-center">
                            <img src="/images/sleep-chart.png" alt="">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Medicament -->
            <div class="row mt-5">
                <div class="col-12">
                    <div class="med-card">
                        <div class="med-header">
                            <img src="/images/madicament-icon.png" alt="">
                            <h5>Medicament</h5>
                        </div>

                        <div class="med-days">
                            <span>Mon 04</span>
                            <span>Tue 05</span>
                            <span>Wed 06</span>
                            <span>Thu 07</span>
                            <span>Fri 08</span>
                            <span>Sat 09</span>
                            <span>Sun 10</span>
                        </div>

                        <div class="med-list">
                            <div class="med-item" style="width: 40%"><span>Vitamin D <small>100 mg</small></span><span
                                    class="med-time">06:00 AM <img src="/images/sun-icon.png" alt=""></span></div>
                            <div class="med-item" style="width: 55%"><span>Loratadine <small>100 mg</small></span><span
                                    class="med-time">09:00 AM <img src="/images/sun-icon.png" alt=""></span>
                            </div>
                            <div class="med-item" style="width: 70%"><span>Vitamine B12 <small>100 mg</small></span><span
                                    class="med-time">07:00 PM <img src="/images/moon-icon.png" alt=""></span>
                            </div>
                            <div class="med-item" style="width: 95%"><span>Magnesium <small>250 mg</small></span><span
                                    class="med-time">09:00 PM <img src="/images/moon-icon.png" alt=""></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection