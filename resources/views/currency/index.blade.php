@extends('layouts.main')

@section('breadcrumbs')
    {{ Breadcrumbs::render('basicdata.currency') }}
@endsection

@section('content')
    <div class="grid">
        <div class="card card-grid min-w-full" data-datatable="false" data-datatable-page-size="10" data-datatable-state-save="false" id="currency-table" data-api-url="{{ route('basicdata.currency.datatables') }}">
            <div class="card-header py-5 flex-wrap">
                <h3 class="card-title">
                    Daftar Mata Uang
                </h3>
                <div class="flex flex-wrap gap-2 lg:gap-5">
                    <div class="flex">
                        <label class="input input-sm"> <i class="ki-filled ki-magnifier"> </i>
                            <input placeholder="Search Currency" id="search" type="text" value="">
                        </label>
                    </div>
                    <div class="flex flex-wrap gap-2.5">
                        <div class="h-[24px] border border-r-gray-200"></div>
                        @can('basic-data.export')
                        <a id="export-btn" class="btn btn-sm btn-light" href="{{ route('basicdata.currency.export') }}"> Export to Excel </a>
                        @endcan
                        @can('basic-data.create')
                        <a class="btn btn-sm btn-primary" href="{{ route('basicdata.currency.create') }}"> Tambah Mata Uang </a>
                        @endcan
                        @can('basic-data.delete')
                        <button class="btn btn-sm btn-danger hidden" id="deleteSelected" onclick="deleteSelectedRows()">Delete Selected</button>
                        @endcan
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="scrollable-x-auto">
                    <table class="table table-auto table-border align-middle text-gray-700 font-medium text-sm" data-datatable-table="true">
                        <thead>
                        <tr>
                            <th class="w-14">
                                <input class="checkbox checkbox-sm" data-datatable-check="true" type="checkbox"/>
                            </th>
                            <th class="min-w-[250px]" data-datatable-column="code">
                                <span class="sort"> <span class="sort-label"> Code </span>
                                    <span class="sort-icon"> </span> </span>
                            </th>
                            <th class="min-w-[250px]" data-datatable-column="name">
                                <span class="sort"> <span class="sort-label"> Mata Uang </span>
                                    <span class="sort-icon"> </span> </span>
                            </th>
                            <th class="min-w-[150px]" data-datatable-column="symbol">
                                <span class="sort"> <span class="sort-label"> Symbol </span>
                                    <span class="sort-icon"> </span> </span>
                            </th>
                            <th class="min-w-[50px]" data-datatable-column="decimal_places">
                                <span class="sort"> <span class="sort-label"> Decimal Places </span>
                                    <span class="sort-icon"> </span> </span>
                            </th>
                            <th class="min-w-[50px] text-center" data-datatable-column="actions">Action</th>
                        </tr>
                        </thead>
                    </table>
                </div>
                <div class="card-footer justify-center md:justify-between flex-col md:flex-row gap-3 text-gray-600 text-2sm font-medium">
                    <div class="flex items-center gap-2">
                        Show
                        <select class="select select-sm w-16" data-datatable-size="true" name="perpage"> </select> per page
                    </div>
                    <div class="flex items-center gap-4">
                        <span data-datatable-info="true"> </span>
                        <div class="pagination" data-datatable-pagination="true">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script type="text/javascript">
        function deleteData(data) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token()  }}'
                        }
                    });

                    $.ajax(`basic-data/mata-uang/${data}`, {
                        type: 'DELETE'
                    }).then((response) => {
                        swal.fire('Deleted!', 'User has been deleted.', 'success').then(() => {
                            window.location.reload();
                        });
                    }).catch((error) => {
                        console.error('Error:', error);
                        Swal.fire('Error!', 'An error occurred while deleting the file.', 'error');
                    });
                }
            })
        }

        function deleteSelectedRows() {
            const selectedCheckboxes = document.querySelectorAll('input[data-datatable-row-check="true"]:checked');
            if (selectedCheckboxes.length === 0) {
                Swal.fire('Warning', 'Please select at least one row to delete.', 'warning');
                return;
            }

            Swal.fire({
                title: 'Are you sure?',
                text: `You are about to delete ${selectedCheckboxes.length} selected row(s). This action cannot be undone!`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete them!'
            }).then((result) => {
                if (result.isConfirmed) {
                    const ids = Array.from(selectedCheckboxes).map(checkbox => checkbox.value);

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    });

                    $.ajax('{{ route("basicdata.currency.deleteMultiple") }}', {
                        type: 'POST',
                        data: {ids: ids}
                    }).then((response) => {
                        Swal.fire('Deleted!', 'Selected rows have been deleted.', 'success').then(() => {
                            window.location.reload();
                        });
                    }).catch((error) => {
                        console.error('Error:', error);
                        Swal.fire('Error!', 'An error occurred while deleting the rows.', 'error');
                    });
                }
            })
        }
    </script>
    <script type="module">
        const element = document.querySelector('#currency-table');
        const searchInput = document.getElementById('search');
        const exportBtn = document.getElementById('export-btn');
        const deleteSelectedButton = document.getElementById('deleteSelected');

        const apiUrl = element.getAttribute('data-api-url');
        const dataTableOptions = {
            apiEndpoint: apiUrl,
            pageSize: 5,
            columns: {
                select: {
                    render: (item, data, context) => {
                        const checkbox = document.createElement('input');
                        checkbox.className = 'checkbox checkbox-sm';
                        checkbox.type = 'checkbox';
                        checkbox.value = data.id.toString();
                        checkbox.setAttribute('data-datatable-row-check', 'true');
                        return checkbox.outerHTML.trim();
                    },
                },
                code: {
                    title: 'Code',
                },
                name: {
                    title: 'Mata Uang',
                },
                symbol: {
                    title: 'Symbol',
                },
                decimal_places: {
                    title: 'Decimal Places',
                },
                actions: {
                    title: 'Status',
                    render: (item, data) => {
                        let html = `<div class="flex flex-nowrap justify-center">`;

                        @can('basic-data.update')
                        html += `<a class="btn btn-sm btn-icon btn-clear btn-info" href="basic-data/mata-uang/${data.id}/edit">
                                <i class="ki-outline ki-notepad-edit"></i>
                            </a>`;
                        @endcan

                        @can('basic-data.delete')
                        html += `<a onclick="deleteData(${data.id})" class="delete btn btn-sm btn-icon btn-clear btn-danger">
                                <i class="ki-outline ki-trash"></i>
                            </a>`;
                        @endcan

                        html += `</div>`;
                        return html;
                    },
                }
            },
        };

        let dataTable = new KTDataTable(element, dataTableOptions);

        // Update export URL with filters
        function updateExportUrl() {
            let url = new URL(exportBtn.href);

            if (searchInput.value) {
                url.searchParams.set('search', searchInput.value);
            } else {
                url.searchParams.delete('search');
            }

            exportBtn.href = url.toString();
        }

        // Custom search functionality
        searchInput.addEventListener('input', function () {
            const searchValue = this.value.trim();
            dataTable.goPage(1);
            dataTable.search(searchValue, true);

            // Update export URL with search parameter
            updateExportUrl();
        });

        function updateDeleteButtonVisibility() {
            const selectedCheckboxes = document.querySelectorAll('input[data-datatable-row-check="true"]:checked');
            if (selectedCheckboxes.length > 0) {
                deleteSelectedButton.classList.remove('hidden');
            } else {
                deleteSelectedButton.classList.add('hidden');
            }
        }

        // Initial call to set button visibility
        updateDeleteButtonVisibility();

        // Add event listener to the table for checkbox changes
        element.addEventListener('change', function (event) {
            if (event.target.matches('input[data-datatable-row-check="true"]')) {
                updateDeleteButtonVisibility();
            }
        });

        // Add event listener for the "select all" checkbox
        const selectAllCheckbox = element.querySelector('input[data-datatable-check="true"]');
        if (selectAllCheckbox) {
            selectAllCheckbox.addEventListener('change', updateDeleteButtonVisibility);
        }

        window.dataTable = dataTable;
    </script>
@endpush
