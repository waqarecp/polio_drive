@extends('layouts.master')

@section('content')
<div class="card">
    <div class="card-header">
        <div class="float-start">
            Assigned Polio Workers
        </div>
        @can('assign_polio_worker_create')
        <div class="float-end">
            <a class="btn btn-success btn-sm text-white" data-bs-toggle="modal" data-bs-target="#addProvinceModal">Assign New Worker</a>
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
                    <form action="{{ route('admin.workers.assign') }}" method="POST">
                        @csrf

                        <!-- Province Dropdown -->
                        <div class="mb-3">
                            <label for="province" class="form-label">Province</label>
                            <select class="form-select" id="province" name="province_id">
                                <option value="">Select Province</option>
                                @foreach($provinces as $province)
                                    <option value="{{ $province->id }}">{{ $province->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Division Dropdown -->
                        <div class="mb-3">
                            <label for="division" class="form-label">Division</label>
                            <select class="form-select" id="division" name="division_id" disabled>
                                <option value="">Select Division</option>
                            </select>
                        </div>

                        <!-- District Dropdown -->
                        <div class="mb-3">
                            <label for="district" class="form-label">District</label>
                            <select class="form-select" id="district" name="district_id" disabled>
                                <option value="">Select District</option>
                            </select>
                        </div>

                        <!-- Tehsil Dropdown -->
                        <div class="mb-3">
                            <label for="tehsil" class="form-label">Tehsil</label>
                            <select class="form-select" id="tehsil" name="tehsil_id" disabled>
                                <option value="">Select Tehsil</option>
                            </select>
                        </div>

                        <!-- Union Council Dropdown -->
                        <div class="mb-3">
                            <label for="unionCouncil" class="form-label">Union Council</label>
                            <select class="form-select" id="unionCouncil" name="union_council_id" disabled>
                                <option value="">Select Union Council</option>
                            </select>
                        </div>

                        <!-- Polio Worker Dropdown -->
                        <div class="mb-3">
                            <label for="workers" class="form-label">Polio Worker</label>
                            <select class="form-select" id="workers" name="workers[]" multiple="multiple">
                                <option value="">Select Polio Workers</option>
                                @foreach($workers as $id => $name)
                                    <option value="{{ $id }}">{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary">Assign Worker</button>
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

        <h3 class="mt-4">Assigned Workers</h3>
        <table class="table">
            <thead>
                <tr>
                    <th>Union Council</th>
                    <th>Assigned Workers</th>
                </tr>
            </thead>
            <tbody>
                @foreach($unionCouncils as $unionCouncil)
                <tr>
                    <td>{{ $unionCouncil->name }}</td>
                    <td>
                        @if($unionCouncil->assignedWorkers->isEmpty())
                        <span class="badge bg-secondary">No polio worker assigned</span>
                        @else
                            @foreach($unionCouncil->assignedWorkers as $worker)
                                <span class="badge bg-primary">{{ $worker->name }}</span>
                            @endforeach
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script src="{{ asset('js/jquery-3.3.1.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.min.js') }}"></script>

<!-- Select2 CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" />

<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.full.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Cache DOM elements
        const provinceSelect = document.getElementById('province');
        const divisionSelect = document.getElementById('division');
        const districtSelect = document.getElementById('district');
        const tehsilSelect = document.getElementById('tehsil');
        const unionCouncilSelect = document.getElementById('unionCouncil');

        // Process hierarchical data
        const provinces = @json($provinces);

        function populateDropdown(dropdown, data, parentId, parentKey) {
            dropdown.innerHTML = '<option value="">Select</option>';
            if (data) {
                data.forEach(item => {
                    if (item[parentKey] == parentId) {
                        dropdown.innerHTML += `<option value="${item.id}">${item.name}</option>`;
                    }
                });
            }
        }

        provinceSelect.addEventListener('change', function() {
            const selectedProvinceId = this.value;
            const divisions = provinces.find(p => p.id == selectedProvinceId).divisions;
            populateDropdown(divisionSelect, divisions, selectedProvinceId, 'province_id');
            divisionSelect.disabled = false;
        });

        divisionSelect.addEventListener('change', function() {
            const selectedDivisionId = this.value;
            const districts = provinces.flatMap(p => p.divisions).find(d => d.id == selectedDivisionId).districts;
            populateDropdown(districtSelect, districts, selectedDivisionId, 'division_id');
            districtSelect.disabled = false;
        });

        districtSelect.addEventListener('change', function() {
            const selectedDistrictId = this.value;
            const tehsils = provinces.flatMap(p => p.divisions.flatMap(d => d.districts)).find(d => d.id == selectedDistrictId).tehsils;
            populateDropdown(tehsilSelect, tehsils, selectedDistrictId, 'district_id');
            tehsilSelect.disabled = false;
        });

        tehsilSelect.addEventListener('change', function() {
            const selectedTehsilId = this.value;
            const unionCouncils = provinces.flatMap(p => p.divisions.flatMap(d => d.districts.flatMap(dt => dt.tehsils))).find(t => t.id == selectedTehsilId).union_councils;
            // console.log(unionCouncils);
            populateDropdown(unionCouncilSelect, unionCouncils, selectedTehsilId, 'tehsil_id');
            unionCouncilSelect.disabled = false;
        });
    });

    $(document).ready(function() {
        $('#workers').select2({
            placeholder: 'Choose Polio Workers',
            allowClear: true,
            tags: true,
            width: '100%'
        });
    });
</script>
@endsection
