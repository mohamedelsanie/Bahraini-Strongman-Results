<x-admin-layout>
    <x-slot name="header">
        <div class="page-header mb-0">
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <nav aria-label="breadcrumb" role="navigation">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('admin/common.home') }}</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.games.index') }}">{{ __('admin/game.index.title') }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ __('admin/game.create.create') }}</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-md-6 col-sm-12 text-right">
                    <a href="{{ route('admin.games.index') }}" class="btn btn-primary btn-sm scroll-click">{{ __('admin/game.show.back') }}</a>
                </div>
            </div>
        </div>
    </x-slot>
    @php $field = 'media'; @endphp
    <div class="py-12">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <div class="clearfix mb-10">
                    <div class="pull-left">
                        <h4 class="text-blue h4">{{ __('admin/game.create.create') }}</h4>
                    </div>
                </div>
                <div class="dropdown-divider"></div>

                <form action="{{ route('admin.games.store') }}" method="post" class="mt-6 space-y-6">
                    @csrf

                    <div class="form-group row">
                        <div class="col-sm-12 col-md-12 mb-30">

                            <div class="form-group row">
                                <label class="col-sm-12 col-md-12 col-form-label">{{ __('admin/game.fields.name') }}</label>
                                <div class="col-sm-12 col-md-12">
                                    <input name="name" placeholder="{{ __('admin/game.fields.name') }}" value="{{ old('name') }}" class="border-gray-300 rounded-md shadow-sm form-control @error('name') border border-danger @enderror" type="text"/>
                                    @error('name')<span class="text-danger">{{ $message }}</span>@enderror
                                </div>
                            </div>


                            <div class="card card-box custom mb-10" id="accordionWork">
                                <div class="card-header" data-toggle="collapse" href="#collapseWork">
                                    <a class="card-title">
                                        {{ __('admin/game.fields.info') }}
                                    </a>
                                </div>
                                <div id="collapseWork" class="card-body show" data-parent="#accordionWork" >

                                    <div class="form-group row">
                                        <label class="col-sm-12 col-md-12 col-form-label">{{ __('admin/game.fields.level') }}</label>
                                        <div class="col-sm-12 col-md-12">

                                            <div class="custom-control custom-radio mb-5">
                                                <input type="radio" id="qualifiers" name="level" value="qualifiers" class="custom-control-input" @if(old('level') == 'qualifiers') checked @endif />
                                                <label class="custom-control-label" for="qualifiers">{{ __('admin/game.fields.qualifiers') }}</label>
                                            </div>
                                            <div class="custom-control custom-radio mb-5">
                                                <input type="radio" id="standard" name="level" value="standard" class="custom-control-input" @if(old('level') == 'standard') checked @endif />
                                                <label class="custom-control-label" for="standard">{{ __('admin/game.fields.standard') }}</label>
                                            </div>
                                            @error('level')<span class="text-danger">{{ $message }}</span>@enderror
                                        </div>
                                    </div>

                                    <div class="form-group row tries hidden">
                                        <label class="col-sm-12 col-md-12 col-form-label">{{ __('admin/game.fields.tries') }}</label>
                                        <div class="col-sm-12 col-md-12">
                                            <input name="tries" placeholder="{{ __('admin/game.fields.tries') }}" value="{{ old('tries') }}" class="border-gray-300 rounded-md shadow-sm form-control @error('tries') border border-danger @enderror" type="text"/>
                                            @error('tries')<span class="text-danger">{{ $message }}</span>@enderror
                                        </div>
                                    </div>

                                    <div class="form-group row type hidden">
                                        <label class="col-sm-12 col-md-12 col-form-label">{{ __('admin/game.fields.type') }}</label>
                                        <div class="col-sm-12 col-md-12">

                                            <div class="custom-control custom-radio mb-5">
                                                <input type="radio" id="repetition" name="type" value="repetition" class="custom-control-input" @if(old('type') == 'repetition') checked @endif />
                                                <label class="custom-control-label" for="repetition">{{ __('admin/game.fields.repetition') }}</label>
                                            </div>
                                            <div class="custom-control custom-radio mb-5">
                                                <input type="radio" id="distance" name="type" value="distance" class="custom-control-input" @if(old('type') == 'distance') checked @endif />
                                                <label class="custom-control-label" for="distance">{{ __('admin/game.fields.distance') }}</label>
                                            </div>
                                            @error('level')<span class="text-danger">{{ $message }}</span>@enderror
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>


                        <div class="col-sm-12 col-md-10">
                            <button class="btn btn-primary bg-gray-800" type="submit">{{ __('admin/game.fields.create') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="user_image_modal_{{$field}}">
        <livewire:admin.media-box :field="$field" />
    </div>


    @section('scripts')
        <script>
            $('#user_image_modal_{{$field}} #gallery_{{$field}} a.image_ch').click(function(){
                $('#user_image_field_{{$field}} #user_image_{{$field}}').val($(this).data('image'));
                var value = $("#user_image_{{$field}}").val();
                $("#user_image_field_{{$field}} .image_preview").html('<a class="cursor-pointer remove_img"><i class="fa fa-times-circle text-gray-700 text-2x1 float-left"></i><img src="'+value+'" width="100" /></a>');

                $("#user_image_field_{{$field}} .image_preview a.remove_img").click(function(){
                    $('#user_image_field_{{$field}} #user_image_{{$field}}').val('');
                    $("#user_image_field_{{$field}} .image_preview a.remove_img").remove();
                });
                //$('.media_uploader').modal('hide');
            });
            $(function () {
                $('input:radio[name=level]').change(function(){
                    if($(this).attr("value")=="qualifiers"){
                        $('.tries').show();
                    } else {
                        $('.tries').hide();
                    }
                });
                $('input:radio[name=level]').change(function(){
                    if($(this).attr("value")=="standard"){
                        $('.type').show();
                    } else {
                        $('.type').hide();
                    }
                });
            });
        </script>
    @endsection
    @section('page_title'){{ __('admin/game.create.title_tag') }}@endsection
</x-admin-layout>
