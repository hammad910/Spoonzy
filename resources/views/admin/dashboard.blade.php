@extends('admin.layout')

@section('css')
    <link href="{{ asset('admin/jvectormap/jquery-jvectormap-1.2.2.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
    <h4 class="mb-4 fw-light">{{ __('admin.dashboard') }} <small class="fs-6">v{{ $settings->version }}</small></h4>

    <div class="content">
        <div class="row">

            <div class="col-lg-3 mb-3">
                <div class="card shadow-custom border-0 overflow-hidden">
                    <div class="card-body">
                        <h3>
                            <i class="bi-arrow-repeat me-2 icon-dashboard"></i>
                            <span>{{ number_format($total_subscriptions) }}</span>
                        </h3>
                        <small>{{ __('admin.subscriptions') }}</small>

                        <span class="icon-wrap icon--admin"><i class="bi-arrow-repeat"></i></span>
                    </div>
                    <div class="card-footer bg-light border-0 p-3">
                        <a href="{{ url('panel/admin/subscriptions') }}"
                            class="text-muted font-weight-medium d-flex align-items-center justify-content-center arrow">
                            {{ __('general.view_all') }}
                        </a>
                    </div>
                </div><!-- card 1 -->
            </div><!-- col-lg-3 -->

            <div class="col-lg-3 mb-3">
                <div class="card shadow-custom border-0 overflow-hidden">
                    <div class="card-body">
                        <h3><i class="bi-cash-stack me-2 icon-dashboard"></i>
                            {{ Helper::amountFormatDecimal($total_raised_funds) }}</h3>
                        <small>{{ __('admin.earnings_net') }} ({{ __('users.admin') }})</small>

                        <span class="icon-wrap icon--admin"><i class="bi-cash-stack"></i></span>
                    </div>
                    <div class="card-footer bg-light border-0 p-3">
                        <a href="{{ url('panel/admin/transactions') }}"
                            class="text-muted font-weight-medium d-flex align-items-center justify-content-center arrow">
                            {{ __('general.see_all_transactions') }}
                        </a>
                    </div>
                </div><!-- card 1 -->
            </div><!-- col-lg-3 -->

            <div class="col-lg-3 mb-3">
                <div class="card shadow-custom border-0 overflow-hidden">
                    <div class="card-body">
                        <h3><i class="bi-people me-2 icon-dashboard"></i> {{ number_format($totalUsers) }}</h3>
                        <small>{{ __('general.members') }}</small>
                        <span class="icon-wrap icon--admin"><i class="bi-people"></i></span>
                    </div>
                    <div class="card-footer bg-light border-0 p-3">
                        <a href="{{ url('panel/admin/members') }}"
                            class="text-muted font-weight-medium d-flex align-items-center justify-content-center arrow">
                            {{ __('general.view_all') }}
                        </a>
                    </div>
                </div><!-- card 1 -->
            </div><!-- col-lg-3 -->

            <div class="col-lg-3 mb-3">
                <div class="card shadow-custom border-0 overflow-hidden">
                    <div class="card-body">
                        <h3><i class="bi-pencil-square me-2 icon-dashboard"></i> {{ number_format($total_posts) }}</h3>
                        <small>{{ __('general.posts') }}</small>
                        <span class="icon-wrap icon--admin"><i class="bi-pencil-square"></i></span>
                    </div>
                    <div class="card-footer bg-light border-0 p-3">
                        <a href="{{ url('panel/admin/posts') }}"
                            class="text-muted font-weight-medium d-flex align-items-center justify-content-center arrow">
                            {{ __('general.view_all') }}
                        </a>
                    </div>
                </div><!-- card 1 -->
            </div><!-- col-lg-3 -->

            <div class="col-lg-4 mb-3">
                <div class="card shadow-custom border-0 overflow-hidden">
                    <div class="card-body">
                        <h6>
                            {{ Helper::amountFormatDecimal($total_funds) }}
                        </h6>
                        <small>{{ __('general.total_revenue') }}</small>
                        <span class="icon-wrap icon--admin"><i class="bi bi-graph-up-arrow"></i></span>
                    </div>
                </div><!-- card 1 -->
            </div><!-- col-lg-4 -->

            <div class="col-lg-4 mb-3">
                <div class="card shadow-custom border-0 overflow-hidden">
                    <div class="card-body">
                        <h6>
                            {{ Helper::amountFormatDecimal($total_paid_funds) }}
                        </h6>
                        <small>{{ __('general.paid_to_creators') }}</small>
                        <span class="icon-wrap icon--admin"><i class="bi bi-graph-up-arrow"></i></span>
                    </div>
                </div><!-- card 1 -->
            </div><!-- col-lg-4 -->

            <div class="col-lg-4 mb-3">
                <div class="card shadow-custom border-0 overflow-hidden">
                    <div class="card-body">
                        <h6>
                            {{ Helper::amountFormatDecimal($totalPaidlastMonth) }}
                        </h6>
                        <small>{{ __('general.paid_last_month') }}</small>
                        <span class="icon-wrap icon--admin"><i class="bi bi-graph-up-arrow"></i></span>
                    </div>
                </div><!-- card 1 -->
            </div><!-- col-lg-4 -->

            <div class="col-lg-4 mb-3">
                <div class="card shadow-custom border-0 overflow-hidden">
                    <div class="card-body">
                        <h6 class="{{ $stat_revenue_today > 0 ? 'text-success' : 'text-danger' }}">
                            {{ Helper::amountFormatDecimal($stat_revenue_today) }}

                            {!! Helper::percentageIncreaseDecreaseAdmin($stat_revenue_today, $stat_revenue_yesterday) !!}
                        </h6>
                        <small>{{ __('general.revenue_today') }}</small>
                        <span class="icon-wrap icon--admin"><i class="bi bi-graph-up-arrow"></i></span>
                    </div>
                    <div class="card-footer bg-light border-0 p-3">
                        <small class="text-capitalize">{{ __('general.yesterday') }}
                            <strong>{{ Helper::amountFormatDecimal($stat_revenue_yesterday) }}</strong></small>
                    </div>
                </div><!-- card 1 -->
            </div><!-- col-lg-4 -->

            <div class="col-lg-4 mb-3">
                <div class="card shadow-custom border-0 overflow-hidden">
                    <div class="card-body">
                        <h6 class="{{ $stat_revenue_week > 0 ? 'text-success' : 'text-danger' }}">
                            {{ Helper::amountFormatDecimal($stat_revenue_week) }}

                            {!! Helper::percentageIncreaseDecreaseAdmin($stat_revenue_week, $stat_revenue_last_week) !!}
                        </h6>
                        <small>{{ __('general.revenue_week') }}</small>
                        <span class="icon-wrap icon--admin"><i class="bi bi-graph-up"></i></span>
                    </div>
                    <div class="card-footer bg-light border-0 p-3">
                        <small class="text-capitalize">{{ __('general.last_week') }}
                            <strong>{{ Helper::amountFormatDecimal($stat_revenue_last_week) }}</strong></small>
                    </div>
                </div><!-- card 1 -->
            </div><!-- col-lg-4 -->

            <div class="col-lg-4 mb-3">
                <div class="card shadow-custom border-0 overflow-hidden">
                    <div class="card-body">
                        <h6 class="{{ $stat_revenue_month > 0 ? 'text-success' : 'text-danger' }}">
                            {{ Helper::amountFormatDecimal($stat_revenue_month) }}

                            {!! Helper::percentageIncreaseDecreaseAdmin($stat_revenue_month, $stat_revenue_last_month) !!}
                        </h6>
                        <small>{{ __('general.revenue_month') }}</small>
                        <span class="icon-wrap icon--admin"><i class="bi bi-graph-up-arrow"></i></span>
                    </div>
                    <div class="card-footer bg-light border-0 p-3">
                        <small class="text-capitalize">{{ __('general.last_month') }}
                            <strong>{{ Helper::amountFormatDecimal($stat_revenue_last_month) }}</strong></small>
                    </div>
                </div><!-- card 1 -->
            </div><!-- col-lg-4 -->

            <div class="col-lg-8 mt-3 py-4">
                <div class="card shadow-custom border-0">
                    <div class="card-body">
                        <div class="d-lg-flex d-block justify-content-between align-items-center mb-4">
                            <h6 class="mb-4 mb-lg-0"><i class="bi-cash-stack me-2"></i> {{ trans('general.earnings') }}
                            </h6>

                            <select class="form-select mb-4 mb-lg-0 w-auto d-block filterEarnings">
                                <option selected="" value="month">{{ __('general.this_month') }}</option>
                                <option value="last-month">{{ __('general.last_month') }}</option>
                                <option value="year">{{ __('general.this_year') }}</option>
                            </select>
                        </div>

                        <div class="d-block position-relative" style="height: 350px">
                            <div class="blocked display-none" id="loadChart">
                                <span class="d-flex justify-content-center align-items-center text-center w-100 h-100">
                                    <i class="spinner-border spinner-border-sm me-2 text-muted"></i>
                                    {{ __('general.loading') }}
                                </span>
                            </div>
                            <canvas id="ChartSales"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 mt-3 pb-4">
                <div class="card border-0 rounded-4 p-3">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="fw-bold mb-0 d-flex align-items-center"
                            style="color: #000; font-size: 18px; gap: 5px;">
                            <img src="/images/experiment-vector.png" alt="" class="me-2 img-fluid"
                                style="width: 24px;">
                            Pending Experiments
                        </h6>
                        <a href="/experiments" class="text-primary fw-semibold small text-decoration-none"
                            style="font-size: 15px;">
                            View all <i class="bi bi-arrow-up-right" style="font-size: 15px;"></i>
                        </a>
                    </div>

                    <!-- Experiment Item -->
                    <div
                        class="experiment-item d-flex justify-content-between align-items-center p-2 rounded-3 mb-2 flex-wrap">
                        <div class="d-flex align-items-center flex-grow-1" style="gap: 10px; min-width: 0;">
                            <span class="me-2 fs-5">
                                <img src="/images/fasting-icon.png" alt="" style="width: 28px; height: 28px;">
                            </span>
                            <div class="text-truncate">
                                <div class="fw-semibold" style="color: #000;">No Experiments Available
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-12 mt-0 mt-lg-3 py-4">
                <div class="card shadow-custom border-0">
                    <div class="card-body">
                        <h6 class="mb-4"><i class="bi-person-check-fill me-2"></i>
                            {{ __('general.subscriptions_the_month') }}</h6>
                        <div style="height: 350px">
                            <canvas id="ChartSubscriptions"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 mt-0 mt-lg-3 py-4">
                {{-- <div class="card shadow-custom border-0">
                    <div class="card-body">
                        <h6 class="mb-4"><i class="bi-people-fill me-2"></i> {{ __('admin.latest_members') }}</h6>

                        @foreach ($users as $user)
                            <div class="d-flex mb-3">
                                <div class="flex-shrink-0">
                                    <img src="{{ Helper::getFile(config('path.avatar') . $user->avatar) }}"
                                        width="50" class="rounded-circle" />
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="m-0 fw-light text-break">
                                        <a href="{{ url($user->username) }}" target="_blank">
                                            {{ $user->name ?: $user->username }}
                                        </a>
                                        <small
                                            class="float-end badge rounded-pill bg-{{ $user->status == 'active' ? 'success' : ($user->status == 'pending' ? 'info' : 'warning') }}">
                                            {{ $user->status == 'active' ? __('general.active') : ($user->status == 'pending' ? __('general.pending') : __('admin.suspended')) }}
                                        </small>
                                    </h6>
                                    <div class="w-100 small">
                                        {{ '@' . $user->username }} / {{ Helper::formatDate($user->date) }}
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        @if ($users->count() == 0)
                            <small>{{ __('admin.no_result') }}</small>
                        @endif
                    </div>

                    @if ($users->count() != 0)
                        <div class="card-footer bg-light border-0 p-3">
                            <a href="{{ url('panel/admin/members') }}"
                                class="text-muted font-weight-medium d-flex align-items-center justify-content-center arrow">
                                {{ __('admin.view_all_members') }}
                            </a>
                        </div>
                    @endif

                </div> --}}
                <div class="table-responsive p-3 shadow-custom">
                    <h6 class="mb-4"><i class="bi-people-fill me-2"></i> {{ __('admin.latest_members') }}</h6>
                    <table class="table align-middle mb-0" id="experimentsTable">
                        <thead>
                            <tr class="text-muted small">
                                <th>S no</th>
                                <th>Name</th>
                                <th>Status</th>
                                <th>Email</th>
                                <th>Created Date</th>
                            </tr>
                        </thead>
                        <tbody id="experimentTableBody">
                            <tr id="loadingRow">
                                <td colspan="8" class="text-center py-4">
                                    <div class="spinner-border text-primary" role="status"></div>
                                    <p class="mt-2 mb-0">Loading users...</p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="card-footer bg-white text-center py-3 border-0" id="paginationContainer"></div>
            </div>

            <div class="col-lg-6 mt-0 mt-lg-3 py-4">
                <div class="card shadow-custom border-0">
                    <div class="card-body">
                        <h6 class="mb-4"><i class="bi-person-check-fill me-2"></i>
                            {{ __('admin.recent_subscriptions') }}</h6>

                        @foreach ($subscriptions as $subscription)
                            <div class="d-flex mb-3">
                                <div class="flex-shrink-0">
                                    <img src="{{ isset($subscription->subscriber->username) ? Helper::getFile(config('path.avatar') . $subscription->subscriber->avatar) : Helper::getFile(config('path.avatar') . $settings->avatar) }}"
                                        width="50" class="rounded-circle" />
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="m-0 fw-light text-break">
                                        @if (!isset($subscription->subscriber->username))
                                            <em class="text-muted">{{ __('general.no_available') }}</em>
                                        @else
                                            <a href="{{ url($subscription->subscriber->username) }}" target="_blank">
                                                {{ $subscription->subscriber->name }}
                                            </a>
                                        @endif

                                        {{ __('general.subscribed_to') }}

                                        @if (!isset($subscription->creator->username))
                                            <em class="text-muted">{{ __('general.no_available') }}</em>
                                        @else
                                            <a href="{{ url($subscription->creator->username) }}"
                                                target="_blank">{{ $subscription->creator->name }}</a>
                                        @endif

                                    </h6>

                                    <div class="w-100 small">
                                        {{ Helper::formatDate($subscription->created_at) }}
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        @if ($subscriptions->count() == 0)
                            <small>{{ __('admin.no_result') }}</small>
                        @endif
                    </div>

                    @if ($subscriptions->count() != 0)
                        <div class="card-footer bg-light border-0 p-3">
                            <a href="{{ url('panel/admin/subscriptions') }}"
                                class="text-muted font-weight-medium d-flex align-items-center justify-content-center arrow">
                                {{ __('general.view_all') }}
                            </a>
                        </div>
                    @endif
                </div>
            </div>

        </div><!-- end row -->
    </div><!-- end content -->
@endsection

@section('javascript')
    <script src="{{ asset('admin/jvectormap/jquery-jvectormap-1.2.2.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('admin/jvectormap/jquery-jvectormap-world-mill-en.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/Chart.min.js') }}"></script>
    @include('admin.charts')
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function() {
        function loadTrendingExperiments() {
            fetch('/contents/experiments')
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success && data.data && data.data.length > 0) {
                        const pendingExperiments = data.data.filter(exp => exp.status === 'pending');

                        if (pendingExperiments.length > 0) {
                            updateTrendingExperiments(pendingExperiments);
                        } else {
                            showNoPendingExperiments();
                        }
                    } else {
                        showNoPendingExperiments();
                    }
                })
                .catch(error => {
                    showNoPendingExperiments();
                });
        }

        function updateTrendingExperiments(experiments) {
            const container = document.querySelector('.card.border-0.rounded-4.p-3');

            const trendingExperiments = experiments.slice(0, 3);

            let experimentsHTML = `
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="fw-bold mb-0 d-flex align-items-center" style="color: #000; font-size: 18px; gap: 5px;">
                    <img src="/images/experiment-vector.png" alt="" class="me-2 img-fluid" style="width: 24px;">
                    Pending Experiments
                </h6>
                <a href="/experiments" class="text-primary fw-semibold small text-decoration-none" style="font-size: 15px;">
                    View all <i class="bi bi-arrow-up-right" style="font-size: 15px;"></i>
                </a>
            </div>
        `;

            trendingExperiments.forEach(experiment => {
                experimentsHTML += `
                <div class="experiment-item d-flex justify-content-between align-items-center p-2 rounded-3 mb-2">
                    <div class="d-flex align-items-center flex-grow-1" style="gap: 10px; min-width: 0;">
                        <span class="me-2 fs-5">
                            <img src="/images/fasting-icon.png" alt="${experiment.title}" style="width: 28px; height: 28px;">
                        </span>
                        <div class="text-truncate">
                            <div class="fw-semibold" style="color: #000;">${experiment.title}</div>
                        </div>
                    </div>
                </div>
            `;
            });

            container.innerHTML = experimentsHTML;
        }

        const ITEMS_PER_PAGE = 10;
        const API_BASE_URL = '/panel/admin/users-fetch';

        let currentTab = 'my-experiments';
        let currentPage = 1;
        let totalItems = 0;
        let totalPages = 1;
        let experimentsData = [];

        const tableBody = document.getElementById('experimentTableBody');
        const paginationContainer = document.getElementById('paginationContainer');
        const experimentCount = document.getElementById('experimentCount');

        loadExperiments();

        function renderPagination() {
            if (totalItems <= ITEMS_PER_PAGE || totalPages <= 1) {
                paginationContainer.innerHTML = '';
                return;
            }

            let paginationHTML = '<nav><ul class="pagination justify-content-center mb-0">';

            if (currentPage > 1) {
                paginationHTML +=
                    `<li class="page-item"><a class="page-link" href="#" onclick="changePage(${currentPage - 1}); return false;"><i class="bi bi-chevron-left"></i> Previous</a></li>`;
            } else {
                paginationHTML +=
                    `<li class="page-item disabled"><span class="page-link"><i class="bi bi-chevron-left"></i> Previous</span></li>`;
            }

            const startPage = Math.max(1, currentPage - 2);
            const endPage = Math.min(totalPages, currentPage + 2);

            for (let i = startPage; i <= endPage; i++) {
                if (i === currentPage) {
                    paginationHTML += `<li class="page-item active"><span class="page-link">${i}</span></li>`;
                } else {
                    paginationHTML +=
                        `<li class="page-item"><a class="page-link" href="#" onclick="changePage(${i}); return false;">${i}</a></li>`;
                }
            }

            if (currentPage < totalPages) {
                paginationHTML +=
                    `<li class="page-item"><a class="page-link" href="#" onclick="changePage(${currentPage + 1}); return false;">Next <i class="bi bi-chevron-right"></i></a></li>`;
            } else {
                paginationHTML +=
                    `<li class="page-item disabled"><span class="page-link">Next <i class="bi bi-chevron-right"></i></span></li>`;
            }

            paginationHTML += '</ul></nav>';
            paginationContainer.innerHTML = paginationHTML;
        }

        function loadExperiments() {
            showLoading();
            const url = `${API_BASE_URL}?limit=${ITEMS_PER_PAGE}`;

            fetch(url, {
                    credentials: 'include'
                })
                .then(response => {
                    if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        experimentsData = data.data || [];
                        totalItems = data.pagination?.total_items || 0;
                        totalPages = data.pagination?.total_pages || 1;
                        currentPage = data.pagination?.current_page || 1;
                        renderTable();
                        renderPagination();
                    } else {
                        throw new Error(data.message || 'Failed to load experiments');
                    }
                })
                .catch(error => {
                    showError('Failed to load experiments. Please try again.');
                });
        }

        function formatDate(dateString) {
            if (!dateString) return 'N/A';
            try {
                const date = new Date(dateString);
                return date.toLocaleDateString('en-US', {
                    year: 'numeric',
                    month: '2-digit',
                    day: '2-digit'
                });
            } catch (e) {
                return dateString;
            }
        }

        function renderTable() {
            if (experimentsData.length === 0) {
                tableBody.innerHTML = `
                        <tr>
                            <td colspan="8" class="text-center py-4 text-muted">
                                <i class="bi bi-inbox" style="font-size: 2rem;"></i>
                                <p class="mt-2 mb-0">No experiments found</p>
                            </td>
                        </tr>
                    `;
                return;
            }

            tableBody.innerHTML = experimentsData.map((user, index) => {
                const serialNumber = ((currentPage - 1) * ITEMS_PER_PAGE) + index + 1;

                return `
                        <tr>
                            <td>${serialNumber}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <span class="fw-semibold text-dark">${user.name}</span>
                                </div>
                            </td>
                            <td>${user.status}</td>
                            <td>${user.email}</td>
                            <td>${formatDate(user.created_at)}</td>
                        </tr>
                    `;
            }).join('');
        }

        function showLoading() {
            tableBody.innerHTML = `
                    <tr id="loadingRow">
                        <td colspan="8" class="text-center py-4">
                            <div class="spinner-border text-primary" role="status"></div>
                            <p class="mt-2 mb-0">Loading users...</p>
                        </td>
                    </tr>
                `;
        }

        function showError(message) {
            tableBody.innerHTML = `
                    <tr>
                        <td colspan="8" class="text-center py-4 text-danger">
                            <i class="bi bi-exclamation-triangle" style="font-size: 2rem;"></i>
                            <p class="mt-2 mb-0">${message}</p>
                            <button class="btn btn-sm btn-primary mt-2" onclick="loadExperiments()">Try Again</button>
                        </td>
                    </tr>
                `;
        }

        loadTrendingExperiments();
    });
</script>
