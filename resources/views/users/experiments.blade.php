@extends('layouts.app')

@section('title')
    Experiments -
@endsection

@section('content')
    <section class="section section-sm">
        <div class="container-fluid p-0">
            <div class="row g-0">
                <div class="col-lg-2 d-none d-lg-block bg-white" style="min-height: 100vh; border-right: 1px solid #ddd;">
                    <div class="p-3">
                        @include('includes.menu-sidebar-home')
                    </div>
                </div>

                <div class="offcanvas offcanvas-start d-lg-none" tabindex="-1" id="mobileSidebar">
                    <div class="offcanvas-body p-3">
                        @include('includes.menu-sidebar-home')
                    </div>
                </div>

                <div class="col-lg-10 col-12 p-4" style="background: #FBFBFB;">
                    <div class="d-flex d-lg-none justify-content-between align-items-center mb-3">
                        <h4 class="fw-semibold mb-0">Experiments</h4>
                        <button class="btn px-2"
                            style="background: {{ $settings->theme_color_pwa ?? '#469DFA' }}; color: white; font-size: 14px;">
                            <i class="bi bi-plus-lg"></i> Create Experiment
                        </button>
                    </div>

                    <div class="d-none d-lg-flex justify-content-between align-items-center mb-4">
                        <h4 class="fw-semibold mb-0" style="color: black">Experiments</h4>
                        <button class="btn px-3"
                            style="background: {{ $settings->theme_color_pwa ?? '#469DFA' }}; color: white;">
                            <i class="bi bi-plus-lg"></i> Create Experiment
                        </button>
                    </div>

                    <ul class="nav nav-tabs mb-3 border-0 flex-wrap" id="experimentTabs">
                        <li class="nav-item hover-black">
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

                    <div class="card shadow-sm border-0" style="border-radius: 10px">
                        <div class="card-body p-0">
                            <div class="d-flex align-items-center p-3 pb-0 flex-wrap" style="gap: 10px">
                                <h6 class="fw-semibold mb-2 mb-sm-0" style="color: black" id="tableTitle">My Experiments
                                </h6>
                                <span class="badge bg-light border rounded-pill px-3 py-2"
                                    style="font-size: 0.8rem; color: {{ $settings->theme_color_pwa ?? '#469DFA' }}; background: {{ $settings->sidebar_bg_color ?? '#F8F9FA' }}"
                                    id="experimentCount">
                                    Loading...
                                </span>
                            </div>

                            <div class="table-responsive p-3">
                                <table class="table align-middle mb-0" id="experimentsTable">
                                    <thead>
                                        <tr class="text-muted small">
                                            <th>S no</th>
                                            <th>Experiment Name</th>
                                            <th>Type</th>
                                            <th>Status</th>
                                            <th>Created Date</th>
                                            <th>Created By</th>
                                            <th>Category</th>
                                            <th class="text-end">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody id="experimentTableBody">
                                        <tr id="loadingRow">
                                            <td colspan="8" class="text-center py-4">
                                                <div class="spinner-border text-primary" role="status"></div>
                                                <p class="mt-2 mb-0">Loading experiments...</p>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="card-footer bg-white text-center py-3 border-0" id="paginationContainer"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Edit Experiment Modal -->
    <div class="modal fade" id="editExperimentModal" tabindex="-1" aria-labelledby="editExperimentModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editExperimentModalLabel">Edit Experiment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editExperimentForm">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <input type="hidden" id="edit_experiment_id" name="id">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="edit_title" class="form-label">Experiment Name</label>
                                <input type="text" class="form-control" id="edit_title" name="title" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="edit_content_type" class="form-label">Type</label>
                                <select class="form-control" id="edit_content_type" name="content_type" required>
                                    <option value="experiment">Experiment</option>
                                    <option value="documentary">Documentary</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="edit_status" class="form-label">Status</label>
                                <select class="form-control" id="edit_status" name="status" required>
                                    <option value="active">Active</option>
                                    <option value="pending">Pending</option>
                                    <option value="archived">Archived</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="edit_categories" class="form-label">Category</label>
                                <input type="text" class="form-control" id="edit_categories" name="categories"
                                    required>
                            </div>
                            <div class="col-12 mb-3">
                                <label for="edit_description" class="form-label">Description</label>
                                <textarea class="form-control" id="edit_description" name="description" rows="3"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Update Experiment</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('javascript')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ITEMS_PER_PAGE = 10;
            const API_BASE_URL = '/contents/experiments';

            let currentTab = 'my-experiments';
            let currentPage = 1;
            let totalItems = 0;
            let totalPages = 1;
            let experimentsData = [];

            const tableBody = document.getElementById('experimentTableBody');
            const paginationContainer = document.getElementById('paginationContainer');
            const experimentCount = document.getElementById('experimentCount');
            const tableTitle = document.getElementById('tableTitle');
            const tabLinks = document.querySelectorAll('#experimentTabs .nav-link');
            const editExperimentModal = new bootstrap.Modal(document.getElementById('editExperimentModal'));
            const editExperimentForm = document.getElementById('editExperimentForm');

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

            editExperimentForm.addEventListener('submit', function(e) {
                e.preventDefault();
                updateExperiment();
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
                            updateExperimentCount();
                        } else {
                            throw new Error(data.message || 'Failed to load experiments');
                        }
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
                        <td colspan="8" class="text-center py-4 text-muted">
                            <i class="bi bi-inbox" style="font-size: 2rem;"></i>
                            <p class="mt-2 mb-0">No experiments found</p>
                        </td>
                    </tr>
                `;
                    return;
                }

                tableBody.innerHTML = experimentsData.map((experiment, index) => {
                    const serialNumber = ((currentPage - 1) * ITEMS_PER_PAGE) + index + 1;
                    const showActions = currentTab === 'my-experiments';

                    return `
                    <tr>
                        <td>${serialNumber}</td>
                        <td>
                            <div class="d-flex align-items-center">
                                <span class="fw-semibold text-dark">${experiment.title}</span>
                            </div>
                        </td>
                        <td>${getContentBadge(experiment.content_type)}</td>
                        <td>${getStatusBadge(experiment.status)}</td>
                        <td>${formatDate(experiment.created_at)}</td>
                        <td>${experiment.creator?.name || 'N/A'}</td>
                        <td>
                            <span class="badge px-3 py-2 rounded-pill" style="background: #F9F5FF; color: #6941C6;">
                                ${experiment.categories || 'N/A'}
                            </span>
                        </td>
                        <td class="text-end">
                            ${showActions ? `
                                        <button class="btn btn-link text-danger p-0 me-2" onclick="deleteExperiment(${experiment.id})" title="Delete">
                                            <img src="/img/icons/trash-icon.png" alt="Delete"/>
                                        </button>
                                        <button class="btn btn-link text-dark p-0" onclick="editExperiment(${experiment.id})" title="Edit">
                                            <img src="/img/icons/edit-icon.png" alt="Edit"/>
                                        </button>
                                    ` : '<span class="text-muted">View Only</span>'}
                        </td>
                    </tr>
                `;
                }).join('');
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
                const config = statusConfig[status] || statusConfig.experiment;
                return `
                <span class="badge bg-opacity-10 px-3 py-2 rounded-pill"
                      style="background: ${config.bg}; font-weight: 500; color: ${config.color}; font-size: 12px">
                    <span style="color: ${config.dotColor}; margin-right: 3px;">●</span>${config.text}
                </span>
            `;
            }

            function getStatusBadge(status) {
                const statusConfig = {
                    'active': {
                        bg: '#ECFDF3',
                        color: '#027A48',
                        dotColor: '#12B76A',
                        text: 'Active'
                    },
                    'pending': {
                        bg: '#FFFAEB',
                        color: '#B54708',
                        dotColor: '#F79009',
                        text: 'Pending'
                    },
                    'archived': {
                        bg: '#FFF1F3',
                        color: '#C01048',
                        dotColor: '#F63D68',
                        text: 'Archived'
                    }
                };
                const config = statusConfig[status] || statusConfig.pending;
                return `
                <span class="badge bg-opacity-10 px-3 py-2 rounded-pill"
                      style="background: ${config.bg}; font-weight: 500; color: ${config.color}; font-size: 12px">
                    <span style="color: ${config.dotColor}; margin-right: 3px;">●</span>${config.text}
                </span>
            `;
            }

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

            function changePage(page) {
                currentPage = page;
                loadExperiments();
                tableBody.scrollIntoView({
                    behavior: 'smooth'
                });
            }

            function updateExperimentCount() {
                const startItem = ((currentPage - 1) * ITEMS_PER_PAGE) + 1;
                const endItem = Math.min(currentPage * ITEMS_PER_PAGE, totalItems);
                experimentCount.textContent =
                    `Showing ${startItem}-${endItem} of ${totalItems} Experiment${totalItems !== 1 ? 's' : ''}`;
            }

            function showLoading() {
                tableBody.innerHTML = `
                <tr id="loadingRow">
                    <td colspan="8" class="text-center py-4">
                        <div class="spinner-border text-primary" role="status"></div>
                        <p class="mt-2 mb-0">Loading experiments...</p>
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

            window.changePage = changePage;

            window.deleteExperiment = function(id) {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetch(`/contents/${id}`, {
                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector(
                                        'meta[name="csrf-token"]').getAttribute('content'),
                                    'Content-Type': 'application/json'
                                },
                                credentials: 'include'
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    Swal.fire('Deleted!', 'Experiment has been deleted.',
                                        'success');
                                    loadExperiments();
                                } else {
                                    Swal.fire('Error!', data.message ||
                                        'Failed to delete experiment.', 'error');
                                }
                            })
                            .catch(error => {
                                console.error('Error deleting experiment:', error);
                                Swal.fire('Error!', 'Failed to delete experiment.', 'error');
                            });
                    }
                });
            };

            window.editExperiment = function(id) {
                fetch(`/contents/${id}`, {
                        method: 'GET',
                        credentials: 'include'
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            const experiment = data.data;
                            document.getElementById('edit_experiment_id').value = experiment.id;
                            document.getElementById('edit_title').value = experiment.title;
                            document.getElementById('edit_content_type').value = experiment.content_type;
                            document.getElementById('edit_status').value = experiment.status;
                            document.getElementById('edit_categories').value = experiment.categories || '';
                            document.getElementById('edit_description').value = experiment.description ||
                                '';
                            editExperimentModal.show();
                        } else {
                            Swal.fire('Error!', data.message || 'Failed to load experiment details.',
                                'error');
                        }
                    })
                    .catch(error => {
                        console.error('Error loading experiment:', error);
                        Swal.fire('Error!', 'Failed to load experiment details.', 'error');
                    });
            };

            function updateExperiment() {
                const formData = new FormData(editExperimentForm);
                const experimentId = document.getElementById('edit_experiment_id').value;

                fetch(`/contents/${experimentId}`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                'content'),
                            'X-HTTP-Method-Override': 'PUT'
                        },
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            editExperimentModal.hide();
                            Swal.fire('Success!', 'Experiment updated successfully.', 'success');
                            loadExperiments();
                        } else {
                            Swal.fire('Error!', data.message || 'Failed to update experiment.', 'error');
                        }
                    })
                    .catch(error => {
                        console.error('Error updating experiment:', error);
                        Swal.fire('Error!', 'Failed to update experiment.', 'error');
                    });
            }
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

        .nav-tabs .nav-link:hover {
            color: #555 !important;
            background: transparent !important;
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

        .hover-black:hover {
            color: black !important;
        }
    </style>
@endsection
