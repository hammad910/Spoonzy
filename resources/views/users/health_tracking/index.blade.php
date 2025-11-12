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
            width: 100%;
            aspect-ratio: 1/1;
            max-width: 320px;
            /* adjust based on design */
            margin: auto;
        }

        .center-text {
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .score {
            font-size: 65px;
            font-weight: 500;
            color: #469DFA;
            line-height: 39.87px;
            margin-top: 22px;
        }

        .mood-text {
            font-size: 18px;
            font-weight: 500;
            color: #8E99AA;
            /* subtle gray */
            line-height: 100%;
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
            /*box-shadow: 0 2px 20px rgba(0, 0, 0, 0.05);*/
            padding: 24px;
        }

        .med-header {
            display: flex;
            align-items: center;
            gap: 12px;
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

        .graph-container {
            display: flex;
            align-items: flex-end;
            gap: 4px;
            height: 50px;
            padding: 5px;
        }

        .bar {
            width: 8px;
            background: #4F80E8;
            border-radius: 4px;
            transition: all 0.3s ease;
        }

        .bar:hover {
            opacity: 0.8;
            transform: translateY(-2px);
        }

        /* Individual bar heights */
        .bar1 {
            height: 28.8px;
        }

        .bar2 {
            height: 43.19px;
        }

        .bar3 {
            height: 21.59px;
        }

        .bar4 {
            height: 36px;
        }

        .bar5 {
            height: 28.8px;
        }

        .bar6 {
            height: 14.30px;
        }

        .bar7 {
            height: 33.59px;
        }

        .bar8 {
            height: 40.8px;
        }

        .bar9 {
            height: 24px;
        }

        .bar10 {
            height: 31.18px;
        }

        .bar11 {
            height: 19.19px;
        }

        .bar12 {
            height: 36px;
        }

        .arc-container {
            position: relative;
            width: 80px;
            height: 50px;
        }

        svg {
            width: 100%;
            height: 100%;
        }

        .arc-background {
            fill: none;
            stroke: #e8f4f0;
            stroke-width: 12;
            stroke-linecap: round;
        }

        .arc-progress {
            fill: none;
            stroke: #47CA8B;
            stroke-width: 12;
            stroke-linecap: round;
            stroke-dasharray: 78.5;
            stroke-dashoffset: 19.625;
            transition: stroke-dashoffset 0.3s ease;
        }

        @keyframes draw {
            from {
                stroke-dashoffset: 78.5;
            }

            to {
                stroke-dashoffset: 19.625;
            }
        }

        .arc-progress {
            animation: draw 1.5s ease-out forwards;
        }

        .connection-container {
            position: relative;
            width: 123px;
            height: 50px;
        }

        .connection-group {
            position: absolute;
        }

        .dot {
            position: absolute;
            width: 10px;
            height: 10px;
            background: linear-gradient(135deg, #ff7b7b 0%, #ff9292 100%);
            border-radius: 50%;
            box-shadow: 0 1px 4px rgba(255, 123, 123, 0.3);
        }

        .line {
            position: absolute;
            background: linear-gradient(180deg, #ff8585 0%, #ff9999 100%);
            transform-origin: center;
            width: 1.5px;
        }

        /* Group 1 - Left vertical connection */
        .group1 {
            left: 11px;
            top: 5px;
        }

        .group1 .dot1 {
            top: 0;
            left: 0;
        }

        .group1 .line1 {
            top: 10px;
            left: 4.5px;
            height: 18px;
        }

        .group1 .dot2 {
            top: 28px;
            left: 0;
        }

        /* Group 2 - Second vertical connection */
        .group2 {
            left: 30px;
            top: 10px;
        }

        .group2 .dot1 {
            top: 0;
            left: 0;
        }

        .group2 .line1 {
            top: 10px;
            left: 4.5px;
            height: 18px;
        }

        .group2 .dot2 {
            top: 28px;
            left: 0;
        }

        /* Group 3 - Third vertical connection */
        .group3 {
            left: 48px;
            top: 5px;
        }

        .group3 .dot1 {
            top: 0;
            left: 0;
        }

        .group3 .line1 {
            top: 10px;
            left: 4.5px;
            height: 18px;
        }

        .group3 .dot2 {
            top: 28px;
            left: 0;
        }

        /* Group 4 - Fourth vertical connection with middle dot */
        .group4 {
            left: 63px;
            top: 5px;
        }

        .group4 .dot1 {
            top: 0;
            left: 0;
        }

        .group4 .line1 {
            top: 10px;
            left: 4.5px;
            height: 9px;
        }

        .group4 .dot2 {
            top: 19px;
            left: 0;
            width: 8px;
            height: 8px;
        }

        .group4 .line2 {
            top: 27px;
            left: 4.5px;
            height: 9px;
        }

        .group4 .dot3 {
            top: 36px;
            left: 0;
        }

        /* Group 5 - Fifth vertical connection */
        .group5 {
            left: 81px;
            top: 8px;
        }

        .group5 .dot1 {
            top: 0;
            left: 0;
        }

        .group5 .line1 {
            top: 10px;
            left: 4.5px;
            height: 13px;
        }

        .group5 .dot2 {
            top: 23px;
            left: 0;
            width: 8.5px;
            height: 8.5px;
        }

        /* Group 6 - Sixth vertical connection */
        .group6 {
            left: 96px;
            top: 13px;
        }

        .group6 .dot1 {
            top: 0;
            left: 0;
            width: 9px;
            height: 9px;
        }

        .group6 .line1 {
            top: 9px;
            left: 4px;
            height: 9px;
        }

        .group6 .dot2 {
            top: 18px;
            left: 0;
            width: 9px;
            height: 9px;
        }

        /* Group 7 - Seventh vertical connection */
        .group7 {
            left: 109px;
            top: 5px;
        }

        .group7 .dot1 {
            top: 0;
            left: 0;
        }

        .group7 .line1 {
            top: 10px;
            left: 4.5px;
            height: 13px;
        }

        .group7 .dot2 {
            top: 23px;
            left: 0;
            width: 9px;
            height: 9px;
        }

        /* Hover effects */
        .dot {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .dot:hover {
            transform: scale(1.1);
            box-shadow: 0 4px 12px rgba(255, 123, 123, 0.5);
        }

        .gauge-container {
            position: relative;
            width: 500px;
            height: 300px;
            display: flex;
            justify-content: center;
            align-items: flex-end;
        }

        svg {
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
        }

        .gauge-outer-ring {
            fill: none;
            stroke: #CEFF83;
            stroke-width: 5;
            stroke-linecap: round;
            opacity: 0.8;
        }

        .gauge-bg {
            fill: none;
            stroke: #e8e8e8;
            stroke-width: 55;
            stroke-linecap: round;
        }

        .gauge-progress {
            fill: none;
            stroke: url(#gaugeGradient);
            stroke-width: 55;
            stroke-linecap: round;
            stroke-dasharray: 471;
            stroke-dashoffset: 117.75;
            transition: stroke-dashoffset 1s ease;
        }

        @keyframes drawGauge {
            from {
                stroke-dashoffset: 471;
            }

            to {
                stroke-dashoffset: 117.75;
            }
        }

        .gauge-progress {
            animation: drawGauge 1.5s ease-out forwards;
        }

        .checkpoint {
            position: absolute;
            z-index: 10;
        }

        .checkpoint-circle {
            width: 52px;
            height: 52px;
            background: white;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
            position: relative;
        }

        .checkpoint-circle.completed {
            background: white;
        }

        .checkpoint-circle.pending {
            background: white;
        }

        .checkmark {
            color: #34CB9D;
            font-size: 26px;
            font-weight: bold;
        }

        .checkpoint-number {
            color: #4caf50;
            font-size: 22px;
            font-weight: 600;
        }

        /* Checkpoint positions - on the progress bar */
        .checkpoint1 {
            bottom: 35px;
            left: 25px;
        }

        .checkpoint2 {
            bottom: 145px;
            left: 70px;
        }

        .checkpoint3 {
            top: 50px;
            left: 50%;
            transform: translateX(-50%);
        }

        .checkpoint4 {
            bottom: 125px;
            right: 53px;
        }

        .checkpoint5 {
            bottom: 35px;
            right: 25px;
        }

        .center-content {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, 10%);
            text-align: center;
            z-index: 5;
        }

        .score-label {
            font-size: 22px;
            color: #637FA6;
            font-weight: 500;
            margin-bottom: 8px;
            letter-spacing: 0.5px;
        }

        .score-value {
            font-size: 90px;
            color: #34CB9D;
            font-weight: 700;
            line-height: 1;
        }

        /* White center background */
        .center-bg {
            position: absolute;
            width: 280px;
            height: 280px;
            background: white;
            border-radius: 50%;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 1;
            box-shadow: 0 2px 20px rgba(0, 0, 0, 0.05);
        }

        @media (max-width: 1850px) and (min-width: 1501px) {
            .gauge-container {
                width: 460px;
                height: 276px;
            }

            .checkpoint-circle {
                width: 48px;
                height: 48px;
            }

            .checkmark {
                font-size: 24px;
            }

            .checkpoint-number {
                font-size: 20px;
            }

            .center-bg {
                width: 260px;
                height: 260px;
            }

            .score-value {
                font-size: 82px;
            }

            .score-label {
                font-size: 20px;
            }

            .checkpoint1 {
                bottom: 30px;
                left: 23px;
            }

            .checkpoint2 {
                bottom: 135px;
                left: 65px;
            }

            .checkpoint3 {
                top: 45px;
            }

            .checkpoint4 {
                bottom: 115px;
                right: 55px;
            }

            .checkpoint5 {
                bottom: 25px;
                right: 27px;
            }
        }

        /* Medium Desktop: 1500px to 1200px */
        @media (max-width: 1500px) and (min-width: 1025px) {
            .gauge-container {
                width: 430px;
                height: 258px;
            }

            .checkpoint-circle {
                width: 45px;
                height: 45px;
            }

            .checkmark {
                font-size: 23px;
            }

            .checkpoint-number {
                font-size: 19px;
            }

            .center-bg {
                width: 240px;
                height: 240px;
            }

            .score-value {
                font-size: 75px;
            }

            .score-label {
                font-size: 19px;
            }

            .checkpoint1 {
                bottom: 28px;
                left: 22px;
            }

            .checkpoint2 {
                bottom: 125px;
                left: 60px;
            }

            .checkpoint3 {
                top: 42px;
            }

            .checkpoint4 {
                bottom: 110px;
                right: 45px;
            }

            .checkpoint5 {
                bottom: 28px;
                right: 22px;
            }
        }

        @media (max-width: 1024px) {
            .gauge-container {
                width: 400px;
                height: 240px;
            }

            .checkpoint-circle {
                width: 42px;
                height: 42px;
            }

            .checkmark {
                font-size: 22px;
            }

            .checkpoint-number {
                font-size: 18px;
            }

            .center-bg {
                width: 220px;
                height: 220px;
            }

            .score-value {
                font-size: 70px;
            }

            .score-label {
                font-size: 18px;
            }

            /* adjust positions */
            .checkpoint1 {
                bottom: 25px;
                left: 20px;
            }

            .checkpoint2 {
                bottom: 110px;
                left: 55px;
            }

            .checkpoint3 {
                top: 40px;
            }

            .checkpoint4 {
                bottom: 100px;
                right: 40px;
            }

            .checkpoint5 {
                bottom: 25px;
                right: 20px;
            }
        }

        /* Mobile Landscape: ~60% scale */
        @media (max-width: 768px) {
            .gauge-container {
                width: 300px;
                height: 180px;
            }

            .checkpoint-circle {
                width: 35px;
                height: 35px;
            }

            .checkmark {
                font-size: 18px;
            }

            .checkpoint-number {
                font-size: 16px;
            }

            .center-bg {
                width: 170px;
                height: 170px;
            }

            .score-value {
                font-size: 55px;
            }

            .score-label {
                font-size: 16px;
            }

            .checkpoint1 {
                bottom: 20px;
                left: 15px;
            }

            .checkpoint2 {
                bottom: 85px;
                left: 40px;
            }

            .checkpoint3 {
                top: 30px;
            }

            .checkpoint4 {
                bottom: 75px;
                right: 35px;
            }

            .checkpoint5 {
                bottom: 20px;
                right: 15px;
            }
        }

        /* Extra Small Devices: 480px to 400px */
        @media (max-width: 480px) and (min-width: 401px) {
            .gauge-container {
                width: 100%;
            }

            .checkpoint-circle {
                width: 32px;
                height: 32px;
            }

            .checkmark {
                font-size: 12px;
            }

            .checkpoint-number {
                font-size: 12px;
            }

            .center-bg {
                width: 110px;
                height: 110px;
            }

            .score-value {
                font-size: 34px;
            }

            .score-label {
                font-size: 12px;
            }

            .checkpoint1 {
                bottom: 0px;
                left: 35px;
            }

            .checkpoint2 {
                bottom: 90px;
                left: 69px;
            }

            .checkpoint3 {
                top: 15px;
            }

            .checkpoint4 {
                bottom: 75px;
                right: 55px;
            }

            .checkpoint5 {
                bottom: 0px;
                right: 35px;
            }
        }


        /* Mobile Portrait: ~45% scale */
        @media (max-width: 400px) {
            .gauge-container {
                width: 100%;
            }

            .checkpoint-circle {
                width: 30px;
                height: 30px;
            }

            .checkmark {
                font-size: 14px;
            }

            .checkpoint-number {
                font-size: 14px;
            }

            .center-bg {
                width: 130px;
                height: 130px;
            }

            .score-value {
                font-size: 40px;
            }

            .score-label {
                font-size: 14px;
            }

            .checkpoint1 {
                bottom: 5px;
                left: 23px;
            }

            .checkpoint2 {
                bottom: 90px;
                left: 54px;
            }

            .checkpoint3 {
                top: 20px;
            }

            .checkpoint4 {
                bottom: 85px;
                right: 49px;
            }

            .checkpoint5 {
                bottom: 6px;
                right: 20px;
            }
        }

        .chart {
            display: flex;
            align-items: flex-end;
            justify-content: center;
            gap: 16px;
            padding: 40px 20px 0;
            border-radius: 12px;
            height: 280px;
            width: 100%;
            max-width: 100%;
            overflow-x: auto;
            /* Prevent overflow */
            overflow-y: hidden;
            box-sizing: border-box;
        }

        /* Prevent horizontal scrollbar from breaking layout */
        .chart::-webkit-scrollbar {
            height: 6px;
        }

        .chart::-webkit-scrollbar-thumb {
            background: rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }

        /* Each group adapts inside */
        .bar-group {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 12px;
            flex: 0 0 auto;
            /* Prevent shrinking */
        }

        /* Bars inside adapt smoothly */
        .bars {
            display: flex;
            align-items: flex-end;
            gap: 16px;
            height: 180px;
            flex: 0 0 auto;
        }

        .bar {
            width: 12px;
            border-radius: 10px;
            background: linear-gradient(to top, #4a90e2, #72b3ff);
            opacity: 0.95;
        }

        /* Your existing color sets remain exactly the same */
        .bar.blue {
            background: linear-gradient(to top, #fff, #469DFA);
        }

        .bar.green {
            background: linear-gradient(to top, #fff, #46FABB);
        }

        .bar.orange {
            background: linear-gradient(to top, #fff, #FF874B);
        }

        /* Bar heights remain identical */
        .mon .blue {
            height: 160px;
        }

        .mon .orange {
            height: 80px;
        }

        .tue .green {
            height: 130px;
        }

        .tue .orange {
            height: 80px;
        }

        .wed .blue {
            height: 180px;
        }

        .wed .orange {
            height: 80px;
        }

        .thu .green {
            height: 160px;
        }

        .thu .orange {
            height: 100px;
        }

        .fri .blue {
            height: 160px;
        }

        .fri .orange {
            height: 90px;
        }

        .sat .blue {
            height: 140px;
        }

        .sat .orange {
            height: 80px;
        }

        .sun .blue {
            height: 100px;
        }

        .sun .orange {
            height: 70px;
        }

        .day {
            font-size: 16px;
            color: #6c757d;
            font-weight: 500;
            white-space: nowrap;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .chart {
                gap: 12px;
                padding: 30px 10px 0;
                height: auto;
                overflow-x: auto;
            }

            .bars {
                gap: 10px;
                height: 150px;
            }

            .bar {
                width: 10px;
            }

            .day {
                font-size: 14px;
            }

            .row.mt-5 {
                gap: 10px;
            }
        }

        .row.mt-5 {
            display: flex;
            flex-wrap: wrap;
        }

        .row.mt-5>[class*="col-"] {
            display: flex;
        }

        .med-card,
        .ai-card {
            flex: 1;
            display: flex;
            flex-direction: column;
            height: 100%;
        }


        .ai-card {
            background: #fff;
            border-radius: 16px;
            /*box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);*/
            padding: 24px;
            max-width: 100%;
            height: 100%
        }

        .ai-header {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 16px;
        }

        .ai-header i {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 20px;
            height: 20px;
            color: #4a90e2;
            font-size: 18px;
        }

        .ai-header h5 {
            font-weight: 700;
            font-size: 18px;
            color: #000;
            margin: 0;
        }

        .advice-box {
            background: linear-gradient(135deg, #eef7ff, #f7f0ff, #e8f5ff);
            border-radius: 12px;
            padding: 16px 20px;
        }

        .advice-box h6 {
            font-size: 16px;
            font-weight: 700;
            color: #469DFA;
            margin-bottom: 8px;
        }

        .advice-box p {
            color: #475569;
            font-size: 14px;
            line-height: 1.6;
            margin: 0;
        }
    </style>
@endsection

@section('content')
    <div class="d-flex" style="min-height: 100vh; background: #FBFBFB;">
        <!-- Sidebar -->
        <div class="menu-sidebar d-none d-lg-block" style="width: 60%; border-right: 1px solid #ddd; padding: 20px 20px 20px 0px; background: #fff;">
            @include('includes.menu-sidebar-home')
        </div>

        <!-- Main Content -->
        <div class="flex-grow-1 health-container main-content">
            <div class="d-flex justify-content-between align-items-start mb-4 flex-wrap gap-3">
                <div>
                    <h1 class="h3 mb-0" style="color: #101828;">Health Tracking</h1>
                    <p class="text-muted mb-0">Overview of your latest health metrics</p>
                </div>
                <button class="top-right-btn">+ Make new Entry</button>
            </div>

            <!-- KPI Cards -->
            <div class="row g-4 mb-4 kpi-cards">
                <div class="col-xl-4 col-lg-6 col-md-6">
                    <div class="card border-0 p-3 h-100"
                        style="border-radius: 20px; box-shadow: 0 2px 2px rgba(0,0,0,0.1);">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 class="fw-semibold text-dark" style="margin-bottom: 24px">Heart rate</h6>
                                <div class="graph-container">
                                    <div class="bar bar1"></div>
                                    <div class="bar bar2"></div>
                                    <div class="bar bar3"></div>
                                    <div class="bar bar4"></div>
                                    <div class="bar bar5"></div>
                                    <div class="bar bar6"></div>
                                    <div class="bar bar7"></div>
                                    <div class="bar bar8"></div>
                                    <div class="bar bar9"></div>
                                    <div class="bar bar10"></div>
                                    <div class="bar bar11"></div>
                                    <div class="bar bar12"></div>
                                </div>
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
                    <div class="card border-0 p-3 h-100"
                        style="border-radius: 20px; box-shadow: 0 2px 2px rgba(0,0,0,0.1);">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 class="fw-semibold text-dark" style="margin-bottom: 24px">Hydration level</h6>
                                <div class="arc-container">
                                    <svg viewBox="0 0 80 50">
                                        <defs>
                                            <linearGradient id="gradient" x1="0%" y1="0%" x2="100%"
                                                y2="0%">
                                                <stop offset="0%" style="stop-color:#3dd5a3;stop-opacity:1" />
                                                <stop offset="100%" style="stop-color:#5fe6ba;stop-opacity:1" />
                                            </linearGradient>
                                        </defs>

                                        <path class="arc-background" d="M 10 40 A 30 30 0 0 1 70 40" pathLength="78.5" />

                                        <path class="arc-progress" d="M 10 40 A 30 30 0 0 1 70 40" pathLength="78.5" />
                                    </svg>
                                </div>
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
                    <div class="card border-0 p-3 h-100"
                        style="border-radius: 20px; box-shadow: 0 2px 2px rgba(0,0,0,0.1);">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 class="fw-semibold text-dark mb-3" style="margin-bottom: 24px">Blood cells</h6>
                                <div class="connection-container">
                                    <!-- Group 1 -->
                                    <div class="connection-group group1">
                                        <div class="dot dot1"></div>
                                        <div class="line line1"></div>
                                        <div class="dot dot2"></div>
                                    </div>

                                    <!-- Group 2 -->
                                    <div class="connection-group group2">
                                        <div class="dot dot1"></div>
                                        <div class="line line1"></div>
                                        <div class="dot dot2"></div>
                                    </div>

                                    <!-- Group 3 -->
                                    <div class="connection-group group3">
                                        <div class="dot dot1"></div>
                                        <div class="line line1"></div>
                                        <div class="dot dot2"></div>
                                    </div>

                                    <!-- Group 4 -->
                                    <div class="connection-group group4">
                                        <div class="dot dot1"></div>
                                        <div class="line line1"></div>
                                        <div class="dot dot2"></div>
                                        <div class="line line2"></div>
                                        <div class="dot dot3"></div>
                                    </div>

                                    <!-- Group 5 -->
                                    <div class="connection-group group5">
                                        <div class="dot dot1"></div>
                                        <div class="line line1"></div>
                                        <div class="dot dot2"></div>
                                    </div>

                                    <!-- Group 6 -->
                                    <div class="connection-group group6">
                                        <div class="dot dot1"></div>
                                        <div class="line line1"></div>
                                        <div class="dot dot2"></div>
                                    </div>

                                    <!-- Group 7 -->
                                    <div class="connection-group group7">
                                        <div class="dot dot1"></div>
                                        <div class="line line1"></div>
                                        <div class="dot dot2"></div>
                                    </div>
                                </div>
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
                    <div class="card-ht bg-white" style="box-shadow: 0 2px 2px rgba(0,0,0,0.1);">
                        <div class="d-flex align-items-center mb-2" style="gap: 12px;">
                            <img src="/images/bristol-scale-icon.png" alt="">
                            <h6 class="ms-2 mb-0 text-dark fw-bold">Bristol Scale</h6>
                        </div>
                        <p class="text-muted small mb-3">Lorem ipsum dolor sit amet consectetur.</p>
                        <div class="d-flex align-items-center justify-content-center">
                            {{-- <img src="/images/today-score.png" alt=""> --}}
                            <div class="gauge-container">
                                <svg width="500" height="260" viewBox="0 0 500 260">
                                    <defs>
                                        <linearGradient id="gaugeGradient" x1="0%" y1="0%" x2="100%"
                                            y2="0%">
                                            <stop offset="0%" style="stop-color:#50E9BB; stop-opacity:1" />
                                            <stop offset="100%" style="stop-color:#24B78B; stop-opacity:1" />
                                        </linearGradient>
                                    </defs>
                                    <!-- Background arc (gray remaining) -->
                                    <path class="gauge-bg" d="M 60 235 A 190 190 0 0 1 440 235" pathLength="471" />
                                    <!-- Progress arc (75% complete - 3 out of 4) -->
                                    <path class="gauge-progress" d="M 60 235 A 190 190 0 0 1 440 235" pathLength="450" />
                                    <!-- Outer decorative ring - MOVED TO END -->
                                    <path class="gauge-outer-ring" d="M 30 240 A 220 220 0 0 1 470 240" pathLength="471"
                                        transform="translate(0, -10)" />
                                </svg>
                                <!-- Checkpoints on progress bar -->
                                <div class="checkpoint checkpoint1">
                                    <div class="checkpoint-circle completed">
                                        <span class="checkmark">✓</span>
                                    </div>
                                </div>
                                <div class="checkpoint checkpoint2">
                                    <div class="checkpoint-circle completed">
                                        <span class="checkmark">✓</span>
                                    </div>
                                </div>
                                <div class="checkpoint checkpoint3">
                                    <div class="checkpoint-circle completed">
                                        <span class="checkmark">✓</span>
                                    </div>
                                </div>
                                <div class="checkpoint checkpoint4">
                                    <div class="checkpoint-circle completed">
                                        <span class="checkmark">4</span>
                                    </div>
                                </div>
                                <div class="checkpoint checkpoint5">
                                    <div class="checkpoint-circle pending">
                                    </div>
                                </div>
                                <!-- Center score display -->
                                <div class="center-content">
                                    <div class="score-label">Today Score</div>
                                    <div class="score-value">4</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-4 col-lg-6 col-md-6">
                    <div class="mood-widget position-relative d-flex justify-content-center align-items-center"
                        style="overflow:hidden;">
                        <img src="/svg/AIsphere.svg" class="img-fluid w-100" alt="Health Widget"
                            style="object-fit:cover;">

                        <!-- Centered content -->
                        <div class="center-text position-absolute text-center">
                            <div class="score">99</div>
                            <div class="mood-text">Excellent<br>Mood</div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-4 col-lg-6 col-md-6">
                    <div class="card-ht bg-white" style="box-shadow: 0 2px 2px rgba(0,0,0,0.1);">
                        <div class="d-flex align-items-center mb-2" style="gap: 12px;">
                            <img src="/images/bristol-scale-icon.png" alt="">
                            <h6 class="ms-2 mb-0 text-dark fw-bold">Sleep Overview</h6>
                        </div>
                        <p class="text-muted small mb-3">Lorem ipsum dolor sit amet consectetur.</p>
                        <div class="d-flex align-items-center justify-content-center">
                            {{-- <img src="/images/sleep-chart.png" alt=""> --}}
                            <div class="chart">
                                <div class="bar-group mon">
                                    <div class="bars">
                                        <div class="bar blue"></div>
                                        <div class="bar orange"></div>
                                    </div>
                                    <div class="day">Mon</div>
                                </div>

                                <div class="bar-group tue">
                                    <div class="bars">
                                        <div class="bar green"></div>
                                        <div class="bar orange"></div>
                                    </div>
                                    <div class="day">Tue</div>
                                </div>

                                <div class="bar-group wed">
                                    <div class="bars">
                                        <div class="bar blue"></div>
                                        <div class="bar orange"></div>
                                    </div>
                                    <div class="day">Wed</div>
                                </div>

                                <div class="bar-group thu">
                                    <div class="bars">
                                        <div class="bar green"></div>
                                        <div class="bar orange"></div>
                                    </div>
                                    <div class="day">Thu</div>
                                </div>

                                <div class="bar-group fri">
                                    <div class="bars">
                                        <div class="bar blue"></div>
                                        <div class="bar orange"></div>
                                    </div>
                                    <div class="day">Fri</div>
                                </div>

                                <div class="bar-group sat">
                                    <div class="bars">
                                        <div class="bar blue"></div>
                                        <div class="bar orange"></div>
                                    </div>
                                    <div class="day">Sat</div>
                                </div>

                                <div class="bar-group sun">
                                    <div class="bars">
                                        <div class="bar blue"></div>
                                        <div class="bar orange"></div>
                                    </div>
                                    <div class="day">Sun</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Medicament -->
            <div class="row mt-5 gap-md-4">
                <div class="col-md-8">
                    <div class="med-card" style="box-shadow: 0 2px 2px rgba(0,0,0,0.1);">
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
                                    class="med-time">06:00 AM <img src="/images/sun-icon.png" alt=""></span>
                            </div>
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
                <div class="col-xl-4 col-lg-6 col-md-6">
                    <div class="ai-card" style="box-shadow: 0 2px 2px rgba(0,0,0,0.1);">
                        <div class="ai-header">
                            <img src="/images/ai_advice.png" alt="">
                            <h5>AI Advice</h5>
                        </div>

                        <div class="advice-box">
                            <h6>Advice Title</h6>
                            <p>
                                Lorem ipsum dolor sit amet consectetur. Tincidunt scelerisque tincidunt ipsum scelerisquese
                                ac.
                                Phasellus aliquam gravida quis sed parturient vulputate vulputate. Ultrices faucibus quam ut
                                volutpat pharetra. Ultrices faucibus quam ut volutpat pharetra.
                                Lorem ipsum dolor sit amet consectetur. Tincidunt scelerisque tincidunt ipsum scelerisque
                                ac.
                                Phasellus aliquam gravida quis sed parturient vulputate vulputate. Ultrices faucibus quam ut
                                volutpat pharetra. Ultrices faucibus quam ut volutpat pharetra.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
