<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Proxies') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6">
                <a href="{{ route('proxies.create') }}"
                    class="px-4 py-2 border-2 rounded transition-colors duration-300"
                    style="border-color: #5c1ebd; color: #5c1ebd;"
                    onmouseover="this.style.backgroundColor='#5c1ebd'; this.style.color='white';"
                    onmouseout="this.style.backgroundColor='transparent'; this.style.color='#5c1ebd';">
                    Add Proxy
                </a>
                </br>
                <div class="overflow-x-auto pt-7">
                    <table id="proxies-table" class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 table-auto">
                        <thead class="bg-gray-100 dark:bg-gray-700">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 dark:text-gray-300 uppercase tracking-wider">Ip</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 dark:text-gray-300 uppercase tracking-wider">Port</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 dark:text-gray-300 uppercase tracking-wider">Type</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 dark:text-gray-300 uppercase tracking-wider">Username</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-600 dark:text-gray-300 uppercase tracking-wider">Password</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-600 dark:text-gray-300 uppercase tracking-wider">Country</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-600 dark:text-gray-300 uppercase tracking-wider">Active</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-600 dark:text-gray-300 uppercase tracking-wider">Last checked at</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-600 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y text-gray-200 divide-gray-200 dark:divide-gray-700"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<!-- DataTables CSS & JS -->
<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/2.3.2/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.3.2/js/dataTables.bulma.js"></script>

<script>
    $(document).ready(function () {
        var table = $('#proxies-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('proxies.data') }}',
            columns: [
                { data: 'ip', name: 'ip' },
                { data: 'port', name: 'port' },
                { data: 'type', name: 'type' },
                { data: 'username', name: 'username' },
                { data: 'password', name: 'password' },
                { data: 'country', name: 'country' },
                { data: 'active', name: 'active' },
                { data: 'last_checked_at', name: 'last_checked_at' },
                { data: 'created_at', name: 'created_at' },
                {
                    data: null,
                    orderable: false,
                    searchable: false,
                    className: "text-right",
                    render: function (data, type, row) {
                        return `
                        <button data-id="${row.id}" class="delete-user text-red-600 hover:text-red-800" title="Delete User" aria-label="Delete User">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>`;
                    }
                }
            ]
        });
        $.getScript("https://cdn.jsdelivr.net/npm/sweetalert2@11", function() {
        
            $('#proxies-table tbody').on('click', '.delete-user', function () {
                var userId = $(this).data('id');

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#5c1ebd',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!',
                    background: '#1e293b',
                    color: 'white',
                    reverseButtons: true,
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '/proxies/' + userId,
                            type: 'DELETE',
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Deleted!',
                                    text: 'User has been deleted.',
                                    background: '#1e293b',
                                    color: 'white',
                                    timer: 1500,
                                    showConfirmButton: false
                                });
                                table.ajax.reload(null, false);
                            },
                            error: function() {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Something went wrong!',
                                    background: '#1e293b',
                                    color: 'white',
                                });
                            }
                        });
                    }
                });
            });

        });
    });
    $('#proxies-table_length').hide
</script>