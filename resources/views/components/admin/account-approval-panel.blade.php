@props(['usersPendingApprove'])


<div class="title-section">
    <h2>Account Approval</h2>
</div>
<div class="content-section">
    <table class="content-table">
        <thead>
            <tr>
                <th class="name-column">
                    Name
                </th>
                <th class="email-column">
                    Email
                </th>
                <th class="phone-column">
                    Phone Number
                </th>
                <th class="status-column">
                    Status
                </th>
                <th class="action-column">
                    Action
                </th>
            </tr>
        </thead>
        <tbody>
            @if ($usersPendingApprove->isEmpty())
                <tr>
                    <td colspan="5" style="text-align: center">No Account Need to Approve</td>
                </tr>
            @else
                @foreach ($usersPendingApprove as $user)
                    <tr>
                        <td class="name-column">{{ $user->first_name . ' ' . $user->last_name }}</td>
                        <td class="email-column">{{ $user->email }}</td>
                        <td class="phone-column">{{ $user->phone_num }}</td>
                        <td class="status-column {{ $user->approve_status }}">{{ ucfirst($user->approve_status) }}</td>
                        <td class="action-column" data-uid="{{ $user->id }}">
                            <button class="action-btn approve">Approve</button>
                            <button class="action-btn reject">Reject</button>
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
</div>
<script>
    $(document).ready(function() {
        $('.action-btn.approve').click(function() {
            if (window.confirm("Do you want to approve this account?")) {
                let userID = $(this).parent().data('uid');
                $.ajax({
                    type: "POST",
                    url: "{{ route('users.updateAccStatus') }}",
                    data: {
                        //Important CSRF TOKEN
                        _token: '{{ csrf_token() }}',
                        userID: userID,
                        status: 'approved',
                    },
                    success: function(response) {
                        if (response.success) {
                            showFlashMessage("This account is approved", 'success');
                            renderAccountApprovalPanel();
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(textStatus, errorThrown);
                    }
                });
            }
        });

        $('.action-btn.reject').click(function() {
            if (window.confirm("Do you want to reject this account?")) {
                let userID = $(this).parent().data('uid');
                $.ajax({
                    type: "POST",
                    url: "{{ route('users.updateAccStatus') }}",
                    data: {
                        //Important CSRF TOKEN
                        _token: '{{ csrf_token() }}',
                        userID: userID,
                        status: 'rejected',
                    },
                    success: function(response) {
                        if (response.success) {
                            showFlashMessage("This account is rejected", 'alert');
                            renderAccountApprovalPanel();
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(textStatus, errorThrown);
                    }
                });
            }
        })
    });
</script>
