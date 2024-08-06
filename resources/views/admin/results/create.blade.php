<x-admin-layout>
    <x-slot name="header">
        <div class="page-header mb-0">
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <nav aria-label="breadcrumb" role="navigation">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('admin/common.home') }}</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.results.index') }}">{{ __('admin/result.index.title') }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ __('admin/result.create.create') }}</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-md-6 col-sm-12 text-right">
                    <a href="{{ route('admin.results.index') }}" class="btn btn-primary btn-sm scroll-click">{{ __('admin/result.show.back') }}</a>
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
                        <h4 class="text-blue h4">{{ __('admin/result.create.create2',['name' => $player->name]) }}</h4>
                    </div>
                </div>
                <div class="dropdown-divider"></div>

                <form action="{{ route('admin.results.store') }}" method="post" class="mt-6 space-y-6">
                    @csrf

                    <div class="form-group row">
                        <div class="col-sm-12 col-md-12 mb-30">



                            <div class="player rounded">
                                <div class="user-pic">
                                    <img src="{{ $player->image }}">
                                </div>
                                <div class="contact-box">
                                    <h4 class="user-name">اسم الاعب : {{ $player->name }}</h4>
                                    <ul class="user-contact">
                                        <li><i class="icon-copy bi bi-box-arrow-in-left"></i>رقم الاعب : {{ $player->num }}</li>
                                        <li><i class="icon-copy bi bi-box-arrow-in-left"></i>الدولة : {{ $player_team }}</li>
                                        <li><i class="icon-copy bi bi-box-arrow-in-left"></i>الوزن : {{ $player_wieght }}</li>
                                        <li><i class="icon-copy bi bi-box-arrow-in-left"></i>الفئة : {{ $player_category }}</li>

                                    </ul>
                                </div>
                            </div>

                            {{--<div class="form-group row">--}}
                                {{--<label class="col-sm-12 col-md-12 col-form-label">{{ __('admin/result.fields.name') }}</label>--}}
                                {{--<div class="col-sm-12 col-md-12">--}}
                                    {{--<input name="name" placeholder="{{ __('admin/result.fields.name') }}" value="{{ old('name') }}" class="border-gray-300 rounded-md shadow-sm form-control @error('name') border border-danger @enderror" type="text"/>--}}
                                    {{--@error('name')<span class="text-danger">{{ $message }}</span>@enderror--}}
                                {{--</div>--}}
                            {{--</div>--}}

                            @foreach($games as $key => $game)
                            <div class="card card-box custom mb-10" id="accordion{{ $key }}" role="tablist" aria-multiselectable="true">
                                <div class="card-header" data-toggle="collapse" href="#collapse{{ $key }}">
                                    <a class="card-title">
                                        {{ __('admin/result.fields.add') }} {{ $game->name }}
                                    </a>
                                </div>
                                <div id="collapse{{ $key }}" class="card-body @if($key == 0) show @endif" data-parent="#accordion{{ $key }}" >
                                    @if($game->level == 'standard')
                                        @if($game->type == 'distance')
                                        <div class="form-group row">
                                            <label class="col-sm-12 col-md-12 col-form-label">{{ __('admin/result.fields.distance') }}</label>
                                            <div class="col-sm-12 col-md-12">
                                                <input name="result[{{ $key }}][distance]" placeholder="{{ __('admin/result.fields.distance') }}" value="{{ old('distance') ?? $results[$key]['distance'] ?? '' }}" class="border-gray-300 rounded-md shadow-sm form-control @error('distance') border border-danger @enderror" type="text"/>
                                                @error('distance')<span class="text-danger">{{ $message }}</span>@enderror
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-sm-12 col-md-12 col-form-label">{{ __('admin/result.fields.time') }}</label>
                                            <div class="col-sm-12 col-md-12">
                                                <input name="result[{{ $key }}][time]" placeholder="{{ __('admin/result.fields.time') }}" value="{{ old('time') ?? $results[$key]['time'] ?? '' }}" class="border-gray-300 rounded-md shadow-sm form-control @error('time') border border-danger @enderror" type="text"/>
                                                @error('time')<span class="text-danger">{{ $message }}</span>@enderror
                                            </div>
                                        </div>

                                        {{--<div class="form-group row">--}}
                                            {{--<label class="col-sm-12 col-md-12 col-form-label">{{ __('admin/result.fields.fin_result') }}</label>--}}
                                            {{--<div class="col-sm-12 col-md-12">--}}
                                                {{--<input name="fin_result" placeholder="{{ __('admin/result.fields.fin_result') }}" value="{{ old('fin_result') }}" class="border-gray-300 rounded-md shadow-sm form-control @error('fin_result') border border-danger @enderror" type="text" disabled />--}}
                                                {{--@error('fin_result')<span class="text-danger">{{ $message }}</span>@enderror--}}
                                            {{--</div>--}}
                                        {{--</div>--}}

                                        @elseif($game->type == 'repetition')
                                            <div class="form-group row">
                                                <label class="col-sm-12 col-md-12 col-form-label">{{ __('admin/result.fields.result') }}</label>
                                                <div class="col-sm-12 col-md-12">
                                                    <input name="result[{{ $key }}][result]" placeholder="{{ __('admin/result.fields.result') }}" value="{{ old('result') ?? $results[$key]['result'] ?? '' }}" class="border-gray-300 rounded-md shadow-sm form-control @error('result') border border-danger @enderror" type="text"/>
                                                    @error('result')<span class="text-danger">{{ $message }}</span>@enderror
                                                </div>
                                            </div>
                                        @endif
                                    @elseif($game->level == 'qualifiers')
                                        <div class="form-group row">
                                            <label class="col-sm-12 col-md-12 col-form-label">{{ __('admin/result.fields.result') }}</label>
                                            <div class="col-sm-12 col-md-12">
                                                <input name="result[{{ $key }}][result]" placeholder="{{ __('admin/result.fields.result') }}" value="{{ old('result') ?? $results[$key]['result'] ?? '' }}" class="border-gray-300 rounded-md shadow-sm form-control @error('result') border border-danger @enderror" type="text"/>
                                                @error('result')<span class="text-danger">{{ $message }}</span>@enderror
                                            </div>
                                        </div>
                                    @endif

                                </div>
                            </div>
                                <input type="hidden" name="result[{{ $key }}][game]" value="{{ $game->id }}" />
                                <input type="hidden" name="result[{{ $key }}][category]" value="{{ $player->category }}" />
                                <input type="hidden" name="result[{{ $key }}][player_id]" value="{{ $player->id }}" />
                            @endforeach
                        </div>


                        <div class="col-sm-12 col-md-10">
                            <button class="btn btn-primary bg-gray-800" type="submit">{{ __('admin/result.fields.create') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="user_image_modal_{{$field}}">
        <livewire:admin.media-box :field="$field" />
    </div>
    @push('styles')
    <style type="text/css">

        .player {
            border: 2px solid #795548;
            width: 250px;
            margin: auto;
            box-shadow: 2px 2px 5px 1px gray;
            padding: 25px;
        }

        .user-pic {
        }

        .user-name {
            margin-left: 15px;
            margin-bottom: 0;
            color: #B77425;
        }

        .user-contact {
            list-style-type: none;
            padding: 0;
            margin-top:25px
        }

        .icon-copy {
            margin-right: 10px;
            margin-left: 15px;
            margin-bottom: 5px;
        }

        .fa-globe {
            margin-right: 10px;
            margin-left: 15px;
            margin-bottom: 5px;
        }

        @media only screen
        and (min-width : 600px) {
            .player {
                width: 100%;
                margin-bottom: 25px;
            }
            .user-pic {
                 display: inline-block;
                 width: 300px;
                 height: auto;
             }
            .contact-box {
                display: inline-block;
                position: absolute;
                margin-right: 15px;
                margin-top: 20px;
            }
        }
    </style>
    @endpush

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
    @section('page_title'){{ __('admin/result.create.title_tag') }}@endsection
</x-admin-layout>
