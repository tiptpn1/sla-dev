<div class="table-responsive">
    <table id="activityTable" class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Activity</th>
                <th>Start Date</th>
                <th>Duration Plan</th>
                <th>Actual Start</th>
                <th>Duration Actual</th>
                <th>Percentage</th>
                <th>Action</th>
            </tr>
        </thead>
    </table>
</div>

<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $('#activityTable').DataTable({
            "autoWidth": false,
            processing: true,
            serverSide: true,
            ajax: "{{ route('activities.data') }}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'nama_activity',
                    name: 'nama_activity'
                },
                {
                    data: 'plan_start',
                    name: 'plan_start'
                },
                {
                    data: 'plan_duration',
                    name: 'plan_duration'
                },
                {
                    data: 'actual_start',
                    name: 'actual_start'
                },
                {
                    data: 'actual_duration',
                    name: 'actual_duration'
                },
                {
                    data: 'percent_complete',
                    name: 'percent_complete'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ]
        });
    });


    function deleteActivity(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "This action cannot be undone!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '{{ route('activities.destroy', ':id') }}'.replace(':id', id),
                    type: 'POST',
                    data: {
                        '_method': 'DELETE',
                        '_token': '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        Swal.fire(
                            'Deleted!',
                            'The activity has been deleted.',
                            'success'
                        ).then(() => {
                            $('#activityTable').DataTable().ajax
                                .reload(); // Reload tabel setelah berhasil delete
                        });
                    },
                    error: function(xhr) {
                        Swal.fire(
                            'Error!',
                            'An error occurred while deleting the activity.',
                            'error'
                        );
                    }
                });
            }
        });
    }
</script>
