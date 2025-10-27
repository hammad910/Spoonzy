@extends('layouts.app')

@section('title')
    Experiments -
@endsection

@section('content')
    <section class="section section-sm">
        <div class="container-fluid p-0">
            <div class="row g-0">
                <!-- Sidebar -->
                <div class="col-lg-2 d-none d-lg-block bg-white" style="min-height: 100vh; border-right: 1px solid #ddd;">
                    <div class="p-3">
                        @include('includes.menu-sidebar-home')
                    </div>
                </div>

                <!-- Offcanvas Sidebar for Mobile -->
                <div class="offcanvas offcanvas-start d-lg-none" tabindex="-1" id="mobileSidebar">
                    <div class="offcanvas-header">
                        <h5 class="offcanvas-title">Menu</h5>
                        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"></button>
                    </div>
                    <div class="offcanvas-body p-3">
                        @include('includes.menu-sidebar-home')
                    </div>
                </div>

                <!-- Main Content -->
                <div class="col-lg-10 col-12 p-4" style="background: #FBFBFB;">
                    <!-- Mobile Sidebar Toggle -->
                    <div class="d-flex d-lg-none justify-content-between align-items-center mb-3">
                        <h4 class="fw-semibold mb-0">Experiments</h4>
                        <button class="btn btn-outline-primary" data-bs-toggle="offcanvas" data-bs-target="#mobileSidebar">
                            <i class="bi bi-list"></i>
                        </button>
                    </div>

                    <!-- Header -->
                    <div class="d-none d-lg-flex justify-content-between align-items-center mb-4">
                        <h4 class="fw-semibold mb-0" style="color: black">Experiments</h4>
                        <button class="btn px-3" style="background: {{ $settings->theme_color_pwa ?? '#469DFA' }}; color: white;">
                            <i class="bi bi-plus-lg"></i> Create Experiment
                        </button>
                    </div>

                    <!-- Tabs -->
                    <ul class="nav nav-tabs mb-3 border-0 flex-wrap" id="experimentTabs">
                        <li class="nav-item">
                            <a class="nav-link active" href="#" data-tab="my-experiments">My Experiments</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" data-tab="creators-experiments">Creators Experiments</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" data-tab="archived-experiments">Archived Experiments</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" data-tab="pending-experiments">Pending Experiments</a>
                        </li>
                    </ul>

                    <!-- Table Card -->
                    <div class="card shadow-sm border-0" style="border-radius: 10px">
                        <div class="card-body p-0">
                            <div class="d-flex align-items-center p-3 pb-0 flex-wrap" style="gap: 10px">
                                <h6 class="fw-semibold mb-2 mb-sm-0" style="color: black" id="tableTitle">My Experiments</h6>
                                <span class="badge bg-light border rounded-pill px-3 py-2"
                                    style="font-size: 0.8rem; color: {{ $settings->theme_color_pwa ?? '#469DFA' }}; background: {{ $settings->sidebar_bg_color ?? '#F8F9FA' }}" id="experimentCount">
                                    Loading...
                                </span>
                            </div>

                            <div class="table-responsive p-3">
                                <table class="table align-middle mb-0" id="experimentsTable">
                                    <thead>
                                        <tr class="text-muted small">
                                            <th><input type="checkbox" class="form-check-input" id="selectAll"></th>
                                            <th>Experiment Name</th>
                                            <th>Type</th>
                                            <th>Created Date</th>
                                            <th>Created By</th>
                                            {{-- <th>Participants</th>
                                            <th>Stats</th> --}}
                                            <th>Category</th>
                                            <th class="text-end">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody id="experimentTableBody">
                                        <tr id="loadingRow">
                                            <td colspan="9" class="text-center py-4">
                                                <div class="spinner-border text-primary" role="status">
                                                </div>
                                                <p class="mt-2 mb-0">Loading experiments...</p>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Pagination -->
                        <div class="card-footer bg-white text-center py-3 border-0" id="paginationContainer">
                            <!-- Pagination will be dynamically generated here -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('javascript')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ITEMS_PER_PAGE = 10;
            const API_BASE_URL = '/contents/experiments';
            
            let currentTab = 'my-experiments';
            let currentPage = 1;
            let totalItems = 0;
            let experimentsData = [];

            const tableBody = document.getElementById('experimentTableBody');
            const paginationContainer = document.getElementById('paginationContainer');
            const experimentCount = document.getElementById('experimentCount');
            const tableTitle = document.getElementById('tableTitle');
            const selectAllCheckbox = document.getElementById('selectAll');
            const tabLinks = document.querySelectorAll('#experimentTabs .nav-link');

            loadExperiments();

            tabLinks.forEach(tab => {
                tab.addEventListener('click', function(e) {
                    e.preventDefault();
                    
                    tabLinks.forEach(t => t.classList.remove('active'));
                    this.classList.add('active');
                    
                    currentTab = this.getAttribute('data-tab');
                    currentPage = 1;
                    
                    updateTableTitle();
                    
                    loadExperiments();
                });
            });

            selectAllCheckbox.addEventListener('change', function() {
                const checkboxes = tableBody.querySelectorAll('input[type="checkbox"]');
                checkboxes.forEach(checkbox => {
                    checkbox.checked = this.checked;
                });
            });

            function updateTableTitle() {
                const titles = {
                    'my-experiments': 'My Experiments',
                    'creators-experiments': 'Creators Experiments',
                    'archived-experiments': 'Archived Experiments',
                    'pending-experiments': 'Pending Experiments'
                };
                tableTitle.textContent = titles[currentTab] || 'Experiments';
            }

            function loadExperiments() {
                showLoading();
                
                const url = `${API_BASE_URL}?tab=${currentTab}&page=${currentPage}&limit=${ITEMS_PER_PAGE}`;
                
                fetch(url, {
                    credentials: 'include',
                })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error(`HTTP error! status: ${response.status}`);
                        }
                        return response.json();
                    })
                    .then(data => {
                        console.log('data', data.data.length)
                        experimentsData = data.data || [];
                        totalItems = data.data.length || 0;
                        
                        renderTable();
                        renderPagination();
                        updateExperimentCount();
                    })
                    .catch(error => {
                        console.error('Error fetching experiments:', error);
                        showError('Failed to load experiments. Please try again.');
                    });
            }

            function renderTable() {
                if (experimentsData.length === 0) {
                    tableBody.innerHTML = `
                        <tr>
                            <td colspan="9" class="text-center py-4 text-muted">
                                <i class="bi bi-inbox" style="font-size: 2rem;"></i>
                                <p class="mt-2 mb-0">No experiments found</p>
                            </td>
                        </tr>
                    `;
                    return;
                }

                tableBody.innerHTML = experimentsData.map(experiment => `
                    <tr>
                        <td><input type="checkbox" class="form-check-input row-checkbox" data-id="${experiment.id}"></td>
                        <td>
                            <div class="d-flex align-items-center">
                                <span class="fw-semibold text-dark">${experiment.title}</span>
                            </div>
                        </td>
                        <td>
                            ${getContentBadge(experiment.content_type)}
                        </td>
                        <td>${formatDate(experiment.created_at)}</td>
                        <td>${experiment.creator.name}</td>
                        <td>
                            <span class="badge bg-light text-primary px-3 py-2 rounded-pill">
                                ${experiment.categories}
                            </span>
                        </td>
                        <td class="text-end">
                            <button class="btn btn-link text-danger p-0 me-2" onclick="deleteExperiment(${experiment.id})" title="Delete">
                                <img src="/img/icons/trash-icon.png" alt="Delete"/>
                            </button>
                            <button class="btn btn-link text-dark p-0" onclick="editExperiment(${experiment.id})" title="Edit">
                                <img src="/img/icons/edit-icon.png" alt="Edit"/>
                            </button>
                        </td>
                    </tr>
                `).join('');
            }

            function getContentBadge(status) {
                const statusConfig = {
                    'experiment': { 
                        bg: '#ECFDF3', 
                        color: '#027A48', 
                        dotColor: '#12B76A',
                        text: 'Experiment'
                    },
                    'documentary': { 
                        bg: '#FFF1F3', 
                        color: '#C01048', 
                        dotColor: '#F63D68',
                        text: 'Documentary'
                    }
                };
                
                const config = statusConfig[status] || statusConfig.pending;
                
                return `
                    <span class="badge bg-opacity-10 px-3 py-2 rounded-pill"
                          style="background: ${config.bg}; font-weight: 500; color: ${config.color}; font-size: 12px">
                        <span style="color: ${config.dotColor}">●</span>
                        ${config.text}
                    </span>
                `;
            }

            function renderPagination() {
                if (totalItems <= ITEMS_PER_PAGE) {
                    paginationContainer.innerHTML = '';
                    return;
                }

                const totalPages = Math.ceil(totalItems / ITEMS_PER_PAGE);
                let paginationHTML = '<nav><ul class="pagination justify-content-center mb-0">';
                
                // Previous button
                if (currentPage > 1) {
                    paginationHTML += `
                        <li class="page-item">
                            <a class="page-link" href="#" onclick="changePage(${currentPage - 1}); return false;">Previous</a>
                        </li>
                    `;
                } else {
                    paginationHTML += `
                        <li class="page-item disabled">
                            <a class="page-link" href="#">Previous</a>
                        </li>
                    `;
                }

                // Page numbers
                for (let i = 1; i <= totalPages; i++) {
                    if (i === currentPage) {
                        paginationHTML += `
                            <li class="page-item active">
                                <a class="page-link" href="#">${i}</a>
                            </li>
                        `;
                    } else {
                        paginationHTML += `
                            <li class="page-item">
                                <a class="page-link" href="#" onclick="changePage(${i}); return false;">${i}</a>
                            </li>
                        `;
                    }
                }

                // Next button
                if (currentPage < totalPages) {
                    paginationHTML += `
                        <li class="page-item">
                            <a class="page-link" href="#" onclick="changePage(${currentPage + 1}); return false;">Next</a>
                        </li>
                    `;
                } else {
                    paginationHTML += `
                        <li class="page-item disabled">
                            <a class="page-link" href="#">Next</a>
                        </li>
                    `;
                }

                paginationHTML += '</ul></nav>';
                paginationContainer.innerHTML = paginationHTML;
            }

            function changePage(page) {
                currentPage = page;
                loadExperiments();
                // Scroll to top of table
                tableBody.scrollIntoView({ behavior: 'smooth' });
            }

            function updateExperimentCount() {
                experimentCount.textContent = `${totalItems} Experiment${totalItems !== 1 ? 's' : ''}`;
            }

            function showLoading() {
                tableBody.innerHTML = `
                    <tr id="loadingRow">
                        <td colspan="9" class="text-center py-4">
                            <p class="mt-2 mb-0">Loading experiments...</p>
                        </td>
                    </tr>
                `;
            }

            function showError(message) {
                tableBody.innerHTML = `
                    <tr>
                        <td colspan="9" class="text-center py-4 text-danger">
                            <i class="bi bi-exclamation-triangle" style="font-size: 2rem;"></i>
                            <p class="mt-2 mb-0">${message}</p>
                            <button class="btn btn-sm btn-primary mt-2" onclick="loadExperiments()">Try Again</button>
                        </td>
                    </tr>
                `;
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

            function formatNumber(num) {
                if (num === undefined || num === null) return '0';
                
                if (num >= 1000000) {
                    return (num / 1000000).toFixed(1) + 'M';
                } else if (num >= 1000) {
                    return (num / 1000).toFixed(1) + 'K';
                }
                return num.toString();
            }

            // Make functions available globally for onclick handlers
            window.changePage = changePage;
            window.deleteExperiment = function(id) {
                if (confirm('Are you sure you want to delete this experiment?')) {
                    // Implement delete functionality
                    console.log('Deleting experiment:', id);
                    // After deletion, reload the data
                    loadExperiments();
                }
            };
            window.editExperiment = function(id) {
                // Implement edit functionality
                console.log('Editing experiment:', id);
            };
        });
    </script>

    <style>
        .nav-tabs .nav-link {
            color: #555;
            border: none;
            padding: 0.75rem 1.5rem;
            font-weight: 500;
            cursor: pointer;
        }

        .nav-tabs .nav-link.active {
            border-bottom: 3px solid {{ $settings->theme_color_pwa ?? '#469DFA' }};
            color: {{ $settings->theme_color_pwa ?? '#469DFA' }};
            background: transparent;
        }

        .table th,
        .table td {
            vertical-align: middle !important;
            border-bottom: 1px solid #f0f0f0;
            font-size: 0.92rem;
        }

        .badge {
            font-weight: 500;
        }

        .table tbody tr:hover {
            background-color: #fafafa;
        }

        .pagination .page-link {
            border: none;
            color: #333;
            border-radius: 8px;
            cursor: pointer;
        }

        .pagination .page-item.active .page-link {
            background-color: {{ $settings->theme_color_pwa ?? '#007bff' }};
            color: white;
        }

        .row-checkbox:checked {
            background-color: {{ $settings->theme_color_pwa ?? '#007bff' }};
            border-color: {{ $settings->theme_color_pwa ?? '#007bff' }};
        }

        .container-fluid {
            padding-right: 0 !important;
            padding-left: 0 !important;
        }

        .offcanvas {
            max-width: 80%;
        }

        @media (min-width: 992px) {
            .col-lg-10 {
                padding-right: 2rem !important;
                padding-left: 2rem !important;
            }
        }
    </style>
@endsection