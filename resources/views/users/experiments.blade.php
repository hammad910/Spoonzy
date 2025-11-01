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
                        <button class="btn px-2" data-bs-toggle="modal" data-bs-target="#createExperimentModal"
                            style="background: {{ $settings->theme_color_pwa ?? '#469DFA' }}; color: white; font-size: 14px;">
                            <i class="bi bi-plus-lg"></i> Create Experiment
                        </button>
                    </div>

                    <div class="d-none d-lg-flex justify-content-between align-items-center mb-4">
                        <h4 class="fw-semibold mb-0" style="color: black">Experiments</h4>
                        <button class="btn px-3" id="create-btn" data-bs-toggle="modal" data-bs-target="#createExperimentModal"
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

    <!-- Create Experiment Modal -->
    <div class="modal fade" id="createExperimentModal" tabindex="-1" aria-labelledby="createExperimentModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 style="color: black" id="createExperimentModalLabel">Create New Experiment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="createExperimentForm" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-6 mb-3">
                                <label for="create_title" class="form-label" style="color: #344054">Title <span class="text-danger">*</span></label>
                                <input type="text" placeholder="Experiement Title" class="form-control" id="create_title" name="title" required>
                            </div>
                            <div class="col-6 mb-3">
                                <label for="create_categories" class="form-label" style="color: #344054">Category <span class="text-danger">*</span></label>
                                <select class="form-control" id="create_categories" name="categories" required>
                                    <option value="">Category Name</option>
                                    <option value="Biology">Biology</option>
                                    <option value="Chemistry">Chemistry</option>
                                    <option value="Physics">Physics</option>
                                    <option value="Engineering">Engineering</option>
                                    <option value="Computer Science">Computer Science</option>
                                    <option value="Psychology">Psychology</option>
                                    <option value="Environmental Science">Environmental Science</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                            <div class="col-12 mb-3">
                                <label for="create_description" class="form-label" style="color: #344054">Description</label>
                                <textarea class="form-control" id="create_description" name="description" rows="3" placeholder="Enter experiment description"></textarea>
                            </div>
                            <div class="col-12 mb-3" style="cursor: pointer">
                                <label for="create_image" class="form-label" style="color: #344054">Experiment Image</label>
                                <input type="file" class="form-control" id="create_image" name="media_url" accept="image/*">
                                <div class="form-control d-flex flex-column align-items-center justify-content-center py-5 border-dashed rounded-4"  id="create_supplements" style="border: 2px dashed #d0d7de; background-color: #fafbfc; cursor: pointer;">
                                    <div class="rounded-circle d-flex align-items-center justify-content-center mb-2" 
                                        style="width: 48px; height: 48px; background-color: #f2f6ff;">
                                        <i class="bi bi-exclamation-circle text-primary fs-4"></i>
                                    </div>

                                    <div>
                                        <span class="text-primary fw-semibold" style="cursor: pointer;">Click to upload</span>
                                        <span class="text-muted"> or drag and drop</span>
                                    </div>

                                    <small class="text-muted mt-1">
                                        SVG, PNG, JPG or GIF (max. 800×400px)
                                    </small>    
                                </div>
                                <div id="uploadPreview" class="mt-3 d-none">
                                    <div class="border p-3 d-flex align-items-center justify-content-between" style="border-color: #469DFA; background-color: #f9fcff; border-radius: 6px;">
                                      <div class="d-flex align-items-center">
                                        <div 
                                          class="rounded-circle d-flex align-items-center justify-content-center me-3"
                                          style="width: 40px; height: 40px; background-color: #e9f3ff;"
                                        >
                                          <i class="bi bi-image text-primary fs-5"></i>
                                        </div>
                                        <div>
                                          <div class="fw-semibold text-dark" id="fileName"></div>
                                          <small class="text-muted" id="fileSize"></small>
                                        </div>
                                      </div>
                                      <div class="text-success fw-bold" id="uploadPercent">100%</div>
                                    </div>
                                
                                    <div class="progress mt-2" style="height: 6px;">
                                      <div 
                                        class="progress-bar bg-primary" 
                                        id="progressBar"
                                        role="progressbar" 
                                        style="width: 0%;" 
                                        aria-valuenow="0" 
                                        aria-valuemin="0" 
                                        aria-valuemax="100"
                                      ></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mb-4">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                  <label class="fw-semibold mb-0" style="color: #344054;">Supplements</label>
                                  <button class="text-primary fw-semibold text-decoration-none d-flex align-items-center gap-1 add-supplement-btn bg-white">
                                    <i class="bi bi-plus-lg"></i> Add Supplement
                                  </button>
                                </div>
                              
                                <div id="supplementsContainer" class="flex-wrap justify-content-start" style="gap: 5px;"></div>

                              </div>
                            
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary" id="createExperimentBtn">
                            <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                            Create Experiment
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Experiment Modal -->
    <div class="modal fade" id="editExperimentModal" tabindex="-1" aria-labelledby="editExperimentModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 style="color: black" id="editExperimentModalLabel">Edit Experiment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editExperimentForm" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <input type="hidden" id="edit_experiment_id" name="id">
                    <div class="row">
                        <div class="col-6 mb-3">
                            <label for="edit_title" class="form-label" style="color: #344054">Title <span class="text-danger">*</span></label>
                            <input type="text" placeholder="Experiement Title" class="form-control" id="edit_title" name="title" required>
                        </div>
                        <div class="col-6 mb-3">
                            <label for="edit_categories" class="form-label" style="color: #344054">Category <span class="text-danger">*</span></label>
                            <select class="form-control" id="edit_categories" name="categories" required>
                                <option value="">Category Name</option>
                                <option value="Biology">Biology</option>
                                <option value="Chemistry">Chemistry</option>
                                <option value="Physics">Physics</option>
                                <option value="Engineering">Engineering</option>
                                <option value="Computer Science">Computer Science</option>
                                <option value="Psychology">Psychology</option>
                                <option value="Environmental Science">Environmental Science</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                        <div class="col-12 mb-3">
                            <label for="edit_description" class="form-label" style="color: #344054">Description</label>
                            <textarea class="form-control" id="edit_description" name="description" rows="3" placeholder="Enter experiment description"></textarea>
                        </div>
                        <div class="col-12 mb-3" style="cursor: pointer">
                            <label for="edit_image" class="form-label" style="color: #344054">Experiment Image</label>
                            <input type="file" class="form-control" id="edit_image" name="media_url" accept="image/*">
                            <div class="form-control d-flex flex-column align-items-center justify-content-center py-5 border-dashed rounded-4"  id="edit_supplements" style="border: 2px dashed #d0d7de; background-color: #fafbfc; cursor: pointer;">
                                <div class="rounded-circle d-flex align-items-center justify-content-center mb-2" 
                                    style="width: 48px; height: 48px; background-color: #f2f6ff;">
                                    <i class="bi bi-exclamation-circle text-primary fs-4"></i>
                                </div>

                                <div>
                                    <span class="text-primary fw-semibold" style="cursor: pointer;">Click to upload</span>
                                    <span class="text-muted"> or drag and drop</span>
                                </div>

                                <small class="text-muted mt-1">
                                    SVG, PNG, JPG or GIF (max. 800×400px)
                                </small>    
                            </div>
                            <div id="editUploadPreview" class="mt-3 d-none">
                                <div class="border p-3 d-flex align-items-center justify-content-between" style="border-color: #469DFA; background-color: #f9fcff; border-radius: 6px;">
                                  <div class="d-flex align-items-center">
                                    <div 
                                      class="rounded-circle d-flex align-items-center justify-content-center me-3"
                                      style="width: 40px; height: 40px; background-color: #e9f3ff;"
                                    >
                                      <i class="bi bi-image text-primary fs-5"></i>
                                    </div>
                                    <div>
                                      <div class="fw-semibold text-dark" id="editFileName"></div>
                                      <small class="text-muted" id="editFileSize"></small>
                                    </div>
                                  </div>
                                  <div class="text-success fw-bold" id="editUploadPercent">100%</div>
                                </div>
                            
                                <div class="progress mt-2" style="height: 6px;">
                                  <div 
                                    class="progress-bar bg-primary" 
                                    id="editProgressBar"
                                    role="progressbar" 
                                    style="width: 0%;" 
                                    aria-valuenow="0" 
                                    aria-valuemin="0" 
                                    aria-valuemax="100"
                                  ></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                              <label class="fw-semibold mb-0" style="color: #344054;">Supplements</label>
                              <button class="text-primary fw-semibold text-decoration-none d-flex align-items-center gap-1 add-supplement-btn bg-white">
                                <i class="bi bi-plus-lg"></i> Add Supplement
                              </button>
                            </div>
                          
                            <div id="editSupplementsContainer" class="flex-wrap justify-content-start" style="gap: 5px;"></div>

                          </div>
                        
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="updateExperimentBtn">
                        <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                        Update Experiment
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

    <!-- Add Supplement Modal -->
    <div class="modal fade" id="addSupplementModal" tabindex="-1" aria-labelledby="addSupplementModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addSupplementModalLabel" style="color: #000">Add Supplement</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="addSupplementForm">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="supplement_name" class=" form-label fw-semibold" style="color: #344054;">Supplement Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="supplement_name" name="supplement_name" placeholder="Enter Title" required>
                        </div>
                        <div class="mb-3">
                            <label for="supplement_dosage" class="form-label fw-semibold" style="color: #344054;">Supplement Dosage <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="supplement_dosage" name="dosage" placeholder="200 mg" required>
                        </div>
                        <div class="mb-3">
                            <label for="supplement_warning" class="form-label fw-semibold" style="color: #344054;">Warning/Caution Note</label>
                            <textarea class="form-control" id="supplement_warning" name="notes" rows="3" placeholder="Enter description here"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary" id="addSupplementBtn">
                            <span class="spinner-border spinner-border-sm d-none" role="status"></span>
                            Add Supplement
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Supplement Modal -->
    <div class="modal fade" id="editSupplementModal" tabindex="-1" aria-labelledby="editSupplementModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editSupplementModalLabel" style="color: #000">Edit Supplement</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editSupplementForm">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="edit_supplement_id" name="id">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="edit_supplement_name" class=" form-label fw-semibold" style="color: #344054;">Supplement Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="edit_supplement_name" name="supplement_name" placeholder="Enter Title" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_supplement_dosage" class="form-label fw-semibold" style="color: #344054;">Supplement Dosage <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="edit_supplement_dosage" name="dosage" placeholder="200 mg" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_supplement_warning" class="form-label fw-semibold" style="color: #344054;">Warning/Caution Note</label>
                            <textarea class="form-control" id="edit_supplement_warning" name="notes" rows="3" placeholder="Enter description here"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary" id="editSupplementBtn">
                            <span class="spinner-border spinner-border-sm d-none" role="status"></span>
                            Update Supplement
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('javascript')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function () {
            fetchSupplements();
        });

        function fetchSupplements() {
            $.ajax({
                url: '/api/get-supplements',
                method: 'GET',
                dataType: 'json',
                success: function (response) {
                    console.log('response', response);
                    const container = $('#supplementsContainer');
                    container.empty();

                    if (response.data.length === 0) {
                        $('#supplementsContainer').css('display', 'block');
                        const emptyHTML = `
                        <div class="border rounded-4 bg-white d-flex flex-column align-items-center justify-content-center text-center py-5 px-3" style="border-color: #EAECF0; min-height: 200px; border-radius: 6px;"> 
                            <img src="/images/supplement-icon.png" alt="Supplements illustration" class="mb-3" style="width: 180px; height: auto;"> 
                            <p class="mb-0" style="color: #98A2B3; font-size: 15px;"> 
                                Currently you don't have any supplements. 
                                <br> 
                                Click <span class="text-primary fw-semibold">Add Supplements</span> to create new ones 
                            </p> 
                        </div>`;
                        container.append(emptyHTML);
                    } else {
                        response.data.forEach(supp => {
                            $('#supplementsContainer').css('display', 'flex');
                            const cardHTML = `
                            <div class="supplement-card shadow-sm p-3 rounded-4 border" data-supplement-id="${supp.id}">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div class="d-flex flex-column">
                                        <div class="d-flex align-items-center mb-1" style="gap: 7px;">
                                            <div class="supplement-icon d-flex align-items-center justify-content-center me-2">
                                                <img src="/images/supplement-card-img.png" alt="icon">
                                            </div>
                                            <h6 class="supplement-title mb-0 fw-semibold">${supp.supplement_name}</h6>
                                        </div>
                                        <p class="supplement-desc my-2">
                                            ${supp.notes}
                                        </p>
                                    </div>
                                    <div class="d-flex" style="gap: 3px;">
                                        <button class="icon-btn border-0 bg-transparent p-0 edit-supplement-btn" data-supplement-id="${supp.id}">
                                            <img src="/images/edit-icon.png" alt="icon">
                                        </button>
                                        <button class="icon-btn border-0 bg-transparent p-0 delete-supplement-btn" data-supplement-id="${supp.id}">
                                            <img src="/images/delete-icon.png" alt="icon">
                                        </button>
                                    </div>
                                </div>
                                <ul class="list-unstyled mt-2 mb-0">
                                    <li class="supplement-detail">– ${supp.dosage}</li>
                                </ul>
                            </div>
                        `;
                        container.append(cardHTML);
                        });

                        // Add event listeners for edit and delete buttons
                        $('.edit-supplement-btn').on('click', function() {
                            const supplementId = $(this).data('supplement-id');
                            editSupplement(supplementId);
                        });

                        $('.delete-supplement-btn').on('click', function() {
                            const supplementId = $(this).data('supplement-id');
                            deleteSupplement(supplementId);
                        });
                    }
                },
                error: function () {
                    alert('Error fetching supplements');
                }
            });
        }

        function editSupplement(supplementId) {
            // Fetch supplement data
            $.ajax({
                url: `/supplements/${supplementId}`,
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        const supplement = response.data;
                        
                        // Populate the edit form
                        $('#edit_supplement_id').val(supplement.id);
                        $('#edit_supplement_name').val(supplement.supplement_name);
                        $('#edit_supplement_dosage').val(supplement.dosage);
                        $('#edit_supplement_warning').val(supplement.notes);
                        
                        // Show the edit modal
                        const editSupplementModal = new bootstrap.Modal(document.getElementById('editSupplementModal'));
                        editSupplementModal.show();
                    } else {
                        Swal.fire('Error!', 'Failed to load supplement data.', 'error');
                    }
                },
                error: function() {
                    Swal.fire('Error!', 'Failed to load supplement data.', 'error');
                }
            });
        }

        function deleteSupplement(supplementId) {
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
                    $.ajax({
                        url: `/supplements/${supplementId}`,
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        success: function(response) {
                            if (response.success) {
                                Swal.fire('Deleted!', 'Supplement has been deleted.', 'success');
                                fetchSupplements(); // Refresh the supplements list
                            } else {
                                Swal.fire('Error!', response.message || 'Failed to delete supplement.', 'error');
                            }
                        },
                        error: function() {
                            Swal.fire('Error!', 'Failed to delete supplement.', 'error');
                        }
                    });
                }
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            const fileInput = document.getElementById('create_image');
            const uploadBox = document.getElementById('create_supplements');
            const preview = document.getElementById('uploadPreview');
            const fileName = document.getElementById('fileName');
            const fileSize = document.getElementById('fileSize');
            const progressBar = document.getElementById('progressBar');
            const uploadPercent = document.getElementById('uploadPercent');

            if (!fileInput) return; // Safety check

            fileInput.addEventListener('change', function (e) {
                const file = e.target.files[0];
                if (!file) return;

                // Hide upload box, show preview
                uploadBox.classList.add('d-none');
                preview.classList.remove('d-none');

                // Fill file info
                fileName.textContent = file.name;
                fileSize.textContent = (file.size / (1024 * 1024)).toFixed(2) + ' MB';

                // Simulated progress animation
                let progress = 0;
                const interval = setInterval(() => {
                    progress += 10;
                    progressBar.style.width = progress + '%';
                    uploadPercent.textContent = progress + '%';
                    if (progress >= 100) {
                        clearInterval(interval);
                        uploadPercent.innerHTML = '<i class="bi bi-check-circle-fill text-primary"></i>';
                    }
                }, 100);
            });

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
            const createExperimentModal = new bootstrap.Modal(document.getElementById('createExperimentModal'));
            const editExperimentModal = new bootstrap.Modal(document.getElementById('editExperimentModal'));
            const createExperimentForm = document.getElementById('createExperimentForm');
            const editExperimentForm = document.getElementById('editExperimentForm');
            const createExperimentBtn = document.getElementById('createExperimentBtn');
            const updateExperimentBtn = document.getElementById('updateExperimentBtn');

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

            createExperimentForm.addEventListener('submit', function(e) {
                e.preventDefault();
                createExperiment();
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
                                ${experiment.image ? 
                                    `<img src="/storage/${experiment.image}" alt="${experiment.title}" class="rounded me-2" style="width: 40px; height: 40px; object-fit: cover;">` : 
                                    ``
                                }
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

            function createExperiment() {
                const formData = new FormData(createExperimentForm);
                
                // Simple loading state
                createExperimentBtn.disabled = true;
                createExperimentBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status"></span> Creating...';

                fetch('/contents', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        createExperimentModal.hide();
                        createExperimentForm.reset();
                        Swal.fire('Success!', 'Experiment created successfully.', 'success');
                        loadExperiments();
                    } else {
                        Swal.fire('Error!', data.message || 'Failed to create experiment.', 'error');
                    }
                })
                .catch(error => {
                    console.error('Error creating experiment:', error);
                    Swal.fire('Error!', 'Failed to create experiment.', 'error');
                })
                .finally(() => {
                    // Reset button
                    createExperimentBtn.disabled = false;
                    createExperimentBtn.innerHTML = 'Create Experiment';
                });
            }

            function updateExperiment() {
                const formData = new FormData(editExperimentForm);
                const experimentId = document.getElementById('edit_experiment_id').value;

                // Show loading state
                const spinner = updateExperimentBtn.querySelector('.spinner-border');
                const buttonText = updateExperimentBtn.querySelector('span:not(.spinner-border)');
                spinner.classList.remove('d-none');
                buttonText.textContent = 'Updating...';
                updateExperimentBtn.disabled = true;

                fetch(`/contents/${experimentId}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
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
                })
                .finally(() => {
                    // Reset button state
                    spinner.classList.add('d-none');
                    buttonText.textContent = 'Update Experiment';
                    updateExperimentBtn.disabled = false;
                });
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
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                    'Content-Type': 'application/json'
                                },
                                credentials: 'include'
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    Swal.fire('Deleted!', 'Experiment has been deleted.', 'success');
                                    loadExperiments();
                                } else {
                                    Swal.fire('Error!', data.message || 'Failed to delete experiment.', 'error');
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
                        document.getElementById('edit_categories').value = experiment.categories || '';
                        document.getElementById('edit_description').value = experiment.description || '';
                        
                        editExperimentModal.show();
                    } else {
                        Swal.fire('Error!', data.message || 'Failed to load experiment details.', 'error');
                    }
                })
                .catch(error => {
                    console.error('Error loading experiment:', error);
                    Swal.fire('Error!', 'Failed to load experiment details.', 'error');
                });
            };
        });

        // Create Experiment button click event
        document.querySelectorAll('[data-bs-target="#createExperimentModal"]').forEach(button => {
            button.addEventListener('click', function() {
                const createModal = new bootstrap.Modal(document.getElementById('createExperimentModal'));
                createModal.show();
            });
        });

        document.querySelectorAll('.add-supplement-btn').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const supplementModal = new bootstrap.Modal(document.getElementById('addSupplementModal'));
                supplementModal.show();
            });
        });

        document.getElementById('addSupplementForm').addEventListener('submit', function(e) {
            e.preventDefault();
            addSupplement();
        });

        document.getElementById('editSupplementForm').addEventListener('submit', function(e) {
            e.preventDefault();
            updateSupplement();
        });

        function addSupplement() {
            const formData = new FormData(document.getElementById('addSupplementForm'));
            const addSupplementBtn = document.getElementById('addSupplementBtn');
            
            // Loading state
            addSupplementBtn.disabled = true;
            addSupplementBtn.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Adding...';

            fetch('/supplements', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    $('#addSupplementModal').modal('hide');
                    document.getElementById('addSupplementForm').reset();
                    fetchSupplements(); // Refresh the supplements list
                    Swal.fire('Success!', 'Supplement added successfully.', 'success');
                } else {
                    Swal.fire('Error!', data.message || 'Failed to add supplement.', 'error');
                }
            })
            .catch(error => {
                console.error('Error adding supplement:', error);
                Swal.fire('Error!', 'Failed to add supplement.', 'error');
            })
            .finally(() => {
                addSupplementBtn.disabled = false;
                addSupplementBtn.innerHTML = 'Add Supplement';
            });
        }

        function updateSupplement() {
            const supplementId = $('#edit_supplement_id').val();
            const formData = new FormData(document.getElementById('editSupplementForm'));
            const editSupplementBtn = document.getElementById('editSupplementBtn');
            
            // Loading state
            editSupplementBtn.disabled = true;
            editSupplementBtn.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Updating...';

            fetch(`/supplements/${supplementId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'X-HTTP-Method-Override': 'PUT'
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('editSupplementForm').reset();
                    fetchSupplements();
                    Swal.fire('Success!', 'Supplement updated successfully.', 'success');
                    $('#editSupplementModal').modal('hide');
                } else {
                    Swal.fire('Error!', data.message || 'Failed to update supplement.', 'error');
                }
            })
            .catch(error => {
                console.error('Error updating supplement:', error);
                Swal.fire('Error!', 'Failed to update supplement.', 'error');
            })
            .finally(() => {
                editSupplementBtn.disabled = false;
                editSupplementBtn.innerHTML = 'Update Supplement';
            });
        }
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
        
        .supplement-card {
            background-color: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 16px;
            padding: 20px;
            width: 100%;
            max-width: 380px;
            transition: box-shadow 0.2s ease-in-out;
        }

        .supplement-card:hover {
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }

        .supplement-icon {
            background-color: #f0f7ff;
            border-radius: 50%;
            height: 40px;
            width: 40px;
        }

        .supplement-title {
            color: #0f172a;
            font-size: 1.1rem;
        }

        .supplement-desc {
            font-size: 0.88rem;
            color: #94a3b8;
            max-width: 270px;
            line-height: 1.4;
        }

        .icon-btn i:hover {
            color: #0f172a;
        }

        .supplement-detail {
            font-size: 0.95rem;
            color: #0f172a;
            margin-bottom: 4px;
            font-weight: 500;
        }
    </style>
@endsection