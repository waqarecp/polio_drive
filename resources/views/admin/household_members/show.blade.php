@if($household->members->isEmpty())
<p>No members found in this household.</p>
@else
<table class="table table-bordered">
    <thead>
        <tr class="bg-info">
            <th>Member Name</th>
            <th>Age</th>
            <th>Gender</th>
            <th>Vaccinated</th>
        </tr>
    </thead>
    <tbody>
        @foreach($household->members as $member)
        <tr>
            <td>{{ ucwords($member->member_name) }}</td>
            <td>{{ $member->age }}</td>
            <td>{{ $member->gender }}</td>
            <td><?= $member->vaccinated == 1 ? "<span class='badge bg-success'>Yes</span>" : "<span class='badge bg-danger'>No</span>" ?></td>
        </tr>
        @endforeach
    </tbody>
</table>
</ul>
@endif