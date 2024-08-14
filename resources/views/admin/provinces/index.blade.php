@extends('layouts.master')
@section('content')
<div class="card">
    <div class="card-header">
        <div class="float-start">
            Province List
        </div>
        @can('province_create')
        <div class="float-end">
            <a class="btn btn-success btn-sm text-white" data-bs-toggle="modal" data-bs-target="#addProvinceModal">Add Province</a>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="addProvinceModal" tabindex="-1" aria-labelledby="addProvinceModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addProvinceModalLabel">Add New Province</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('admin.provinces.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="provinceName" class="form-label">Province Name</label>
                                <input type="text" class="form-control" id="provinceName" name="name" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Add Province</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal -->
        @endcan
    </div>

    <div class="card-body">
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
        @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr class="bg-info">
                        <th width="10"></th>
                        <th>System ID</th>
                        <th>Province Name</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($provinces as $key => $province)
                    <tr data-entry-id="{{ $province->id }}">
                        <td></td>
                        <td>{{ $province->id ?? '' }}</td>
                        <td>{{ ucwords($province->name) ?? '' }}</td>
                        <td>
                            @can('province_edit')
                                <a href="javascript:void(0)" class="badge bg-info editAction" onclick="editRow(this)" data-id="{{ $province->id }}" data-name="{{ $province->name }}">Edit</a>
                            @endcan
                            @can('province_delete')
                            <form id="delete-form-{{ $province->id }}" style="display:inline" method="POST" action="{{ route('admin.provinces.destroy', $province->id) }}">
                                @csrf
                                @method('DELETE')
                            </form>

                            <a href="javascript:void(0)" class="badge bg-danger text-white" onclick="
                                if(confirm('Are you sure you want to delete this province?')) {
                                    document.getElementById('delete-form-{{ $province->id }}').submit();
                                }
                            ">Delete</a>
                            @endcan
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer clearfix">
        {{ $provinces->links() }}
    </div>
</div>
@can('province_edit')
<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Province</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editRowForm">
                <div class="modal-body">
                    <input type="hidden" id="rowId" name="rowId">
                    <div class="mb-3">
                        <label for="fieldName" class="form-label">Province Name</label>
                        <input type="text" class="form-control" id="fieldName" name="fieldName" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="saveRow()">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endcan
@endsection
<script src="{{ asset('js/jquery-3.3.1.min.js') }}"></script>

<script>
    function saveRow() {
        var id = $('#rowId').val();
        var name = $('#fieldName').val();

        $.ajax({
            url: '/admin/provinces/' + id,
            type: 'PUT',
            dataType: 'json',
            headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
            data: {
                name: name
            },
            success: function(data) {
                alert(data['message']);

                if (data['status'] == 'success') {
                    // Update the table row with the new name
                    $('tr[data-entry-id="' + id + '"]').find('td:nth-child(3)').text(name);
                    $('tr[data-entry-id="' + id + '"]').find('.editAction').attr("data-name", name);
                    $('#editModal').modal('hide');
                }
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
            }
        });
    }

    function editRow(element) {
        $('#rowId').val($(element).data("id"));
        $('#fieldName').val($(element).attr("data-name"));
        $('#editModal').modal('show');
    }
    function deleteRow() {
        var id = $('#rowId').val();
        var name = $('#fieldName').val();

        if(confirm('Are you sure you want to delete this province ' + name + '?')) {
            $.ajax({
                url: '/admin/provinces/' + id,
                type: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}',
                },
                success: function(data) {
                    alert(data['message']);

                    if (data['status'] == 'success') {
                        $('tr[data-entry-id="' + id + '"]').remove();
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                }
            });
        }
    }
</script>