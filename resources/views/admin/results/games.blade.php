<x-admin-layout>
    <x-slot name="header">
        <div class="page-header mb-0">
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <nav aria-label="breadcrumb" role="navigation">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.dashboard') }}">{{ __('admin/common.home')}}</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                {{ __('admin/result.index.title') }}
                            </li>
                        </ol>
                    </nav>
                </div>
                <div class="col-md-6 col-sm-12 text-right">
                    @if(AdminCan('user-create'))
                        <a href="{{ route('admin.results.index') }}" class="btn btn-primary btn-sm scroll-click">{{ __('admin/result.index.all') }}</a>
                    @endif
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
                                <h4 class="text-blue h4">{{ __('admin/result.index.title_game') }}</h4>
                            </div>
                        </div>
                        <div class="dropdown-divider"></div>
                    </div>

                </div>
                <div class="row">
                    @foreach($games as $game)
                        <div class="col-sm-12 col-md-4 mb-30 mt-30">
                            <div class="card card-box text-center">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $game->name }}</h5>
                                    <a href="{{ route('admin.cat.results',['slug' => $slug]).'/game/'.$game->id }}" class="btn btn-primary">{{ __('admin/result.index.view_game') }}</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    @push('styles')
    @endpush
    @push('javascript')
    @endpush

    @section('page_title'){{ __('admin/result.index.title_tag') }}@endsection
</x-admin-layout>
