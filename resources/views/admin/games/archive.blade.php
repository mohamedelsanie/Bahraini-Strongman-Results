<x-admin-layout>
    <x-slot name="header">
        <div class="page-header mb-0">
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <nav aria-label="breadcrumb" role="navigation">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.dashboard') }}">{{ __('admin/common.home') }}</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.games.index') }}">{{ __('admin/game.index.title') }}</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                {{ __('admin/game.archive.title') }}
                            </li>
                        </ol>
                    </nav>
                </div>
                <div class="col-md-6 col-sm-12 text-right">
                    <a href="{{ route('admin.games.index') }}" class="btn btn-primary btn-sm scroll-click">
                        {{ __('admin/game.archive.all') }}</a>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">

                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <div class="clearfix mb-10">
                            <div class="pull-left">
                                <h4 class="text-blue h4">{{ __('admin/game.archive.title') }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
                <table class="table table nowrap table-bordered table-striped no-footer dtr-inline" id="games-table">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">{{ __('admin/common.table.game_name') }}</th>
                        <th scope="col">{{ __('admin/common.table.game_level') }}</th>
                        <th scope="col">{{ __('admin/common.table.game_tries_type') }}</th>
                        <th scope="col">{{ __('admin/common.table.acions') }}</th>
                    </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- delete --}}
    <div class="modal fade" id="deletemodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('admin.games.delete') }}" method="POST">

                <div class="modal-content">

                    <div class="modal-body">
                        @csrf
                        <div class="p-6">
                            <h2 class="text-lg font-medium text-gray-900">
                                {{ __('admin/common.messages.delete_title2') }}
                            </h2>


                        </div>
                        <div class="form-group">
                            <p>{{ __('admin/common.messages.delete_desc') }}</p>
                            @csrf
                            <input type="hidden" name="id" id="id">
                        </div>



                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-info" style="background-color: #17a2b8 !important;" data-dismiss="modal">{{ __('admin/common.messages.cancel') }}</button>
                        <button type="submit" class="btn btn-danger" style="background-color: #dc3545 !important;">{{ __('admin/common.messages.confirm_delete') }} </button>
                    </div>
                </div>
            </form>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    {{-- delete --}}
    @push('styles')
    {{--<link rel="stylesheet" type="text/css" href="{{ asset('assets/admin/vendors/styles/datatables.min.css') }}" />--}}
    <style>
        .dataTables_wrapper .dataTables_processing {position: absolute;top: 44%;left: 50%;width: 30%;height: 40px;margin-left: -10%;text-align: center;font-size: 1.2em;background: #142127;border: 0;line-height: 41px;color: #fff;}
        th.sorting,th.sorting_asc,th.sorting_desc {cursor: pointer;}
        .dataTables_filter input[type="search"],.dataTables_length select {width: auto;display: inline-block;}
        .dataTables_filter input[type="search"]{border-radius: 0.375rem;}
        .dataTables_filter {text-align: left;}
        .pagination {float: left;}
        table td .action_link {font-size: 18px;margin-left: 10px;}
    </style>
    @endpush
    @push('javascript')
    <script type="text/javascript">
        $(function() {
            var table = $('#games-table').DataTable({
                order: [ [1, 'asc'] ],
                language: {
                    'url' : "{{ asset('assets/admin/vendors/scripts/'.app()->getLocale().'/datatables.json') }}",
                },
                processing: true,
                serverSide: true,
                ajax: "{{ Route('admin.games.trashed') }}",
                columns: [{
                    data: 'id',
                    name: 'id',
                    orderable: false,
                    searchable: false
                },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'level',
                        name: 'level',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'tries_type',
                        name: 'tries_type',
                        orderable: false,
                        searchable: false
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
        $('#games-table tbody').on('click', '#deleteBtn', function(argument) {
            var id = $(this).attr("data-id");
            console.log(id);
            $('#deletemodal #id').val(id);
        })
    </script>
    @endpush
    @section('page_title'){{ __('admin/game.archive.title_tag') }}@endsection
</x-admin-layout>
