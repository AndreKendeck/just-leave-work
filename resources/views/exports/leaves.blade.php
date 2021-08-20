<table>
    <thead>
        <tr>
            <th>Email</th>
            <th>Name</th>
            <th>Type</th>
            <th>On</th>
            <th>Until</th>
            <th>Days Off</th>
            <th> Closing Balance </th>
        </tr>
    </thead>
    <tbody>
        @foreach ($leaves as $leave)
            <tr>
                <td>{{ $leave->user->email }}</td>
                <td>{{ $leave->user->name }}</td>
                <td>{{ $leave->reason->name }}</td>
                <td>{{ $leave->from->toFormattedDateString() }}</td>
                <td>{{ $leave->half_day ? '-' : $leave->until->toFormattedDateString() }}</td>
                <td>{{ $leave->number_of_days_off }}</td>
                <td></td>
            </tr>
        @endforeach
    </tbody>
</table>
