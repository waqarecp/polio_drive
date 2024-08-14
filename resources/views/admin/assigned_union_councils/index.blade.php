@extends('layouts.master')

@section('content')
<div class="card">
    <div class="card-header">
        <h3>Assigned Union Councils and Households</h3>
    </div>

    <div class="card-body">
        @if($assignedUnionCouncils->isEmpty())
        <p>No union councils assigned to you.</p>
        @else
        <table class="table table-bordered">
            <thead>
                <tr class="bg-info">
                    <th>Union Council</th>
                    <th>Households</th>
                </tr>
            </thead>
            <tbody>
                @foreach($assignedUnionCouncils as $unionCouncil)
                <tr>
                    <td>{{ $unionCouncil->name }}</td>
                    <td>
                        @if($unionCouncil->households->isEmpty())
                            No households available
                        @else
                            @foreach($unionCouncil->households as $household)
                                <div class="d-flex justify-content-between mb-2">
                                    <span>{{ $household->household_name }}</span>
                                    @if($household->assigned_worker_id)
                                        @if($household->assigned_worker_id == auth()->id())
                                            <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#householdMembersModal" data-id="{{ $household->id }}">Show Members</button>
                                        @else
                                            <span class="badge bg-secondary">Picked by another worker</span>
                                        @endif
                                    @else
                                        <form action="{{ route('admin.pick_household', $household->id) }}" method="POST" style="display: inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-success btn-sm"><span data-feather="check"></span> Pick</button>
                                        </form>
                                    @endif
                                </div>
                            @endforeach
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>
</div>

<!-- Bootstrap Modal -->
<div class="modal fade" id="householdMembersModal" tabindex="-1" role="dialog" aria-labelledby="householdMembersModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Household Members</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <!-- Members will be loaded here via AJAX -->
                <div id="householdMembersList"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('js/jquery-3.3.1.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $('#householdMembersModal').on('show.bs.modal', function (e) {
            var button = $(e.relatedTarget); // Button that triggered the modal
            var householdId = button.data('id'); // Extract info from data-* attributes
            
            $.ajax({
                url: '{{ route("admin.household_members", ":id") }}'.replace(':id', householdId),
                type: 'GET',
                success: function(data) {
                    $('#householdMembersList').html(data);
                },
                error: function(xhr) {
                    $('#householdMembersList').html('<p>An error occurred while fetching household members.</p>');
                }
            });
        });
    });
</script>

@endsection
