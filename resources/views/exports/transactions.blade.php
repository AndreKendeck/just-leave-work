<table>
    <thead>
        <tr>
            <th>Date</th>
            <th>Description</th>
            <th>Amount</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($transactions as $transaction)
            <tr>
                <td>{{ $transaction->created_at->format('d/m/Y') }}</td>
                <td>{{ $transaction->description }}</td>
                <td>{{ $transaction->amount }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
