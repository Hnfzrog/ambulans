@extends('layouts.app')

@section('content')
<style>
    body {
        background-color: #f8f9fa; /* Light background for contrast */
    }
    h1 {
        color: #343a40; /* Darker text for better readability */
    }
    .container{
        min-height:70vh /* Light background for contrast */
    }
    .table {
        border-radius: 0.5rem; /* Rounded corners for the table */
        overflow: hidden; /* Prevent overflow of borders */
    }
    .table th, .table td {
        vertical-align: middle; /* Center content vertically */
    }
    .table-striped tbody tr:hover {
        background-color: #e9ecef; /* Highlight row on hover */
    }
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.1/font/bootstrap-icons.min.css">

<div class="container my-5">
    <h1 class="text-center mt-4 mb-4">User Management</h1>

    <form method="GET" action="{{ route('superadmin.userIndex') }}" class="mb-4">
        <div class="input-group">
            <input type="text" name="search" value="{{ request()->get('search') }}" class="form-control" placeholder="Search by user name" aria-label="Search by user name">
            <button class="btn btn-primary" type="submit">Search</button>
        </div>
    </form>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="table-responsive">
        <table class="table table-striped table-hover table-bordered align-middle">
            <thead class="table-dark">
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ ucfirst($user->role) }}</td>
                        <td>
                            @if($user->id != 3) <!-- Exclude user with id 3 -->
                                <div class="d-inline-flex">
                                    @if($user->role === 'admin')
                                        <button type="button" class="btn btn-outline-primary btn-sm me-1" title="Promote to Super Admin" 
                                            onclick="confirmRoleChange('{{ route('superadmin.updateRole', $user) }}', 'superAdmin')">
                                            <i class="bi bi-arrow-up-circle"></i>
                                        </button>
                                    @elseif($user->role === 'superAdmin')
                                        <button type="button" class="btn btn-outline-danger btn-sm me-1" title="Demote to Admin" 
                                            onclick="confirmRoleChange('{{ route('superadmin.updateRole', $user) }}', 'admin')">
                                            <i class="bi bi-arrow-down-circle"></i>
                                        </button>
                                    @endif
                                </div>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Pagination Links -->
    <div class="d-flex justify-content-between mt-4">
        <div>
            Showing {{ $users->firstItem() }} to {{ $users->lastItem() }} of {{ $users->total() }} entries
        </div>
        <div>
            {{ $users->links('vendor.pagination.custom') }} <!-- Use custom pagination if you have it -->
        </div>
    </div>
</div>

<!-- Confirmation Modal -->
<div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content text-center">
            <div class="modal-header">
                <h5 class="modal-title w-100" id="confirmModalLabel">Konfirmasi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Apakah Anda yakin ingin mengubah role pengguna ini?
            </div>
            <div class="modal-footer d-flex justify-content-center">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <form id="roleChangeForm" method="POST" style="display: inline;">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="role" id="roleInput">
                    <button type="submit" class="btn btn-primary">Konfirmasi</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function confirmRoleChange(actionUrl, role) {
        const modal = new bootstrap.Modal(document.getElementById('confirmModal'));
        document.getElementById('roleChangeForm').action = actionUrl;
        document.getElementById('roleInput').value = role;
        modal.show();
    }
</script>
@endsection
