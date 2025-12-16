@extends('layouts.CarProvider')

@section('content')

{{-- ================= HERO IMAGE ================= --}}
<div class="container-fluid p-0 mb-2">
    <img src="{{ asset('21.jpg') }}"
         class="w-100 img-fluid object-fit-cover"
         style="max-height: 550px; object-position: center;">
</div>

{{-- ================= CONTENT ================= --}}
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold m-0" style="color:#163155;">My Parts</h2>

        <a href="{{ route('spareparts.create') }}"
           class="btn btn-primary d-flex align-items-center"
           style="background-color:#163155;border-color:#163155;">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                 class="bi bi-plus-lg" viewBox="0 0 16 16">
                <path fill-rule="evenodd"
                      d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2"/>
            </svg>
            <span class="ms-1">Add New Part</span>
        </a>
    </div>

    <div class="row g-4 text-center">
        @forelse($spareParts as $part)
<div class="col-12 col-sm-6 col-md-4 col-lg-3">
                <div class="part-card shadow-sm h-100">

                    <h5 class="part-title">{{ $part->title }}</h5>

                    <p class="part-sub">
                        @if($part->car_model)
                            {{ implode(', ', json_decode($part->car_model)) }}
                        @endif
                    </p>

                    <div class="d-flex gap-2 mt-auto">
                    <a href="{{ route('spareparts.edit', $part->id) }}"
   class="btn w-50 edit-btn">
   <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17"
        fill="currentColor" class="bi bi-pencil-square me-1" viewBox="0 0 16 16">
        <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
        <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
   </svg>
   Edit
</a>
<style>
    .edit-btn {
    border: 1px solid #163155;
    border-radius: 18px;
    color: #163155;
    background-color: transparent;
    transition: all 0.3s ease;
}

.edit-btn:hover {
    background-color: #163155;
    color: #fff;
    transform: translateY(-2px);
    box-shadow: 0 6px 15px rgba(22, 49, 85, 0.25);
    text-decoration: none;
}

.edit-btn:hover svg {
    color: #fff;
}

</style>
                        <button type="button"
                                class="btn btn-outline-danger rounded-4 flex-fill"
                                data-bs-toggle="modal"
                                data-bs-target="#confirmDeleteModal"
                                data-part-id="{{ $part->id }}"
                                data-part-title="{{ $part->title }}">
                            <i class="fas fa-trash-alt me-1"></i> Delete
                        </button>
                    </div>

                </div>
            </div>
        @empty
            <p class="text-muted">No spare parts found.</p>
        @endforelse
    </div>
 <div class="d-flex justify-content-center mt-5 spareparts-pagination">
    {{ $spareParts->links('pagination::bootstrap-5') }}
</div>


</div>

{{-- ================= DELETE MODAL ================= --}}
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4 shadow">

            <div class="modal-header border-0">
                <h5 class="modal-title text-danger">
                    <i class="fas fa-exclamation-triangle me-2"></i> Confirm Deletion
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                Are you sure you want to delete
                <strong id="modal-part-title"></strong>?
            </div>

            <div class="modal-footer border-0">
                <button type="button"
                        class="btn btn-secondary rounded-4"
                        data-bs-dismiss="modal">
                    Cancel
                </button>

                <form id="delete-part-form" method="POST">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger rounded-4">
                        <i class="fas fa-trash-alt me-1"></i> Delete
                    </button>
                </form>
            </div>

        </div>
    </div>
</div>
<style>
/* ===== SPARE PARTS PAGINATION OVERRIDE ===== */
.spareparts-pagination .pagination .page-item .page-link {
    color: #163155 !important;
    border-color: #163155 !important;
}

.spareparts-pagination .pagination .page-item.active .page-link {
    background-color: #163155 !important;
    border-color: #163155 !important;
    color: #fff !important;
}

.spareparts-pagination .pagination .page-item:hover .page-link {
    background-color: #163155 !important;
    color: #fff !important;
}

.spareparts-pagination .pagination .page-link:focus {
    box-shadow: 0 0 0 0.25rem rgba(22, 49, 85, 0.25) !important;
}
</style>

{{-- ================= STYLES ================= --}}
<style>
.part-card {
    background:#fff;
    border-radius:14px;
    padding:12px;
    display:flex;
    flex-direction:column;
    border:1px solid #e8e8e8;
    transition:.25s;
}
.part-card:hover {
    transform:translateY(-4px);
    box-shadow:0 6px 15px rgba(0,0,0,.08);
}
.part-title {
    font-size:.95rem;
    font-weight:700;
    color:#163155;
    margin:10px 0 5px;
}
.part-sub {
    font-size:.75rem;
    color:#444;
    min-height:40px;
}

/* 🔥 FIX MODAL LAYER ISSUE */
.modal { z-index: 1055 !important; }
.modal-backdrop { z-index: 1050 !important; }
</style>

{{-- ================= SCRIPT ================= --}}
<script>
document.addEventListener('show.bs.modal', function (event) {
    if (event.target.id !== 'confirmDeleteModal') return;

    const button = event.relatedTarget;
    const partId = button.dataset.partId;
    const partTitle = button.dataset.partTitle;

    document.getElementById('modal-part-title').textContent = partTitle;

    const form = document.getElementById('delete-part-form');
    form.action = "{{ route('spareparts.delete', ':id') }}".replace(':id', partId);
});
</script>


@endsection
