<x-admin-layout>
    <x-slot name="header">
        <div class="page-header mb-0">
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <nav aria-label="breadcrumb" role="navigation">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('admin/common.home') }}</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.players.index') }}">{{ __('admin/player.index.title') }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ __('admin/player.edit.edit') }}<code>{{ $data->title }}</code></li>
                        </ol>
                    </nav>
                </div>
                <div class="col-md-6 col-sm-12 text-right">
                    <a href="{{ route('admin.players.index') }}" class="btn btn-primary btn-sm scroll-click">{{ __('admin/player.show.back') }}</a>
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
                        <h4 class="text-blue h4">{{ __('admin/player.edit.edit') }} </h4>
                    </div>
                </div>
                <div class="dropdown-divider"></div>

                <form action="{{ route('admin.players.update', $data->id) }}" method="post">
                    @csrf
                    @method('PUT')

                    <div class="form-group row">
                        <div class="col-sm-12 col-md-8 mb-30">

                            <div class="form-group row">
                                <label class="col-sm-12 col-md-12 col-form-label">{{ __('admin/player.fields.name') }}</label>
                                <div class="col-sm-12 col-md-12">
                                    <input name="name" placeholder="{{ __('admin/player.fields.name') }}" value="{{ $data->name }}" class="border-gray-300 rounded-md shadow-sm date-picker2 form-control @error('name') border border-danger @enderror" type="text"/>
                                    @error('name')<span class="text-danger">{{ $message }}</span>@enderror
                                </div>
                            </div>


                            <div class="card card-box custom mb-10" id="accordionWork">
                                <div class="card-header" data-toggle="collapse" href="#collapseWork">
                                    <a class="card-title">
                                        {{ __('admin/player.fields.info') }}
                                    </a>
                                </div>
                                <div id="collapseWork" class="card-body show" data-parent="#accordionWork" >


                                    <div class="form-group row">
                                        <label class="col-sm-12 col-md-12 col-form-label">{{ __('admin/player.fields.num') }}</label>
                                        <div class="col-sm-12 col-md-12">
                                            <input name="num" placeholder="{{ __('admin/player.fields.num') }}" value="{{ $data->num }}" class="border-gray-300 rounded-md shadow-sm form-control @error('num') border border-danger @enderror" type="text"/>
                                            @error('num')<span class="text-danger">{{ $message }}</span>@enderror
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-12 col-md-12 col-form-label">{{ __('admin/player.fields.wieght') }}</label>
                                        <div class="col-sm-12 col-md-12">
                                            <input name="wieght" placeholder="{{ __('admin/player.fields.wieght') }}" value="{{ $data->wieght }}" class="border-gray-300 rounded-md shadow-sm form-control @error('wieght') border border-danger @enderror" type="text"/>
                                            @error('wieght')<span class="text-danger">{{ $message }}</span>@enderror
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="col-sm-12 col-md-4 mb-30">
                            <div class="card card-box custom mb-10" id="accordionImage">
                                <div class="card-header" data-toggle="collapse" href="#collapseImage">
                                    <a class="card-title">
                                        {{ __('admin/player.fields.image') }}
                                    </a>
                                </div>
                                <div id="collapseImage" class="card-body show pb-0" data-parent="#accordionImage" aria-expanded="true">
                                    <div class="form-group row" id="user_image_field_{{$field}}">
                                        <div class="col-sm-6 col-md-6 hidden">
                                            <input name="image" id="user_image_{{$field}}" placeholder="image" value="{{ $data->image }}" class="hidden form-control @error('image') border border-danger @enderror" type="text"/>
                                            @error('image')<span class="text-danger">{{ $message }}</span>@enderror
                                        </div>
                                        <div class="col-sm-12 col-md-12">
                                            {{--@livewire('admin.media-upload')--}}
                                            <div class="image_preview" style="float: left; margin-right: 20px;">
                                                @if($data->image)
                                                    <img src="{{ $data->image }}" width="100" />
                                                @endif
                                            </div>
                                            <div class="clearfix"></div>
                                            <div class="block">
                                                <a href="#" class="btn-block" data-toggle="modal" data-target=".media_uploader_{{$field}}" type="button">{{ __('admin/player.fields.media') }}</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card card-box custom mb-10" id="accordionMode">
                                <div class="card-header" data-toggle="collapse" href="#collapseMode">
                                    <a class="card-title">
                                        {{ __('admin/player.fields.team') }}
                                    </a>
                                </div>
                                <div id="collapseMode" class="card-body show" data-parent="#accordionMode" >

                                    <div class="form-group row">
                                        <div class="col-sm-12 col-md-12">
                                            <select name="team" id="team" class="border-gray-300 rounded-md shadow-sm custom-select col-12 @error('team') border border-danger @enderror">
                                                <option  @if($data->team == '') selected @endif>{{ __('admin/player.fields.choose') }}</option>
                                                <option value="bh" @if($data->team == 'bh') selected @endif>{{ __('admin/player.fields.bh') }}</option>
                                                <option value="kw" @if($data->team == 'kw') selected @endif>{{ __('admin/player.fields.kw') }}</option>
                                                <option value="ae" @if($data->team == 'ae') selected @endif>{{ __('admin/player.fields.ae') }}</option>
                                                <option value="qa" @if($data->team == 'qa') selected @endif>{{ __('admin/player.fields.qa') }}</option>
                                                <option value="om" @if($data->team == 'om') selected @endif>{{ __('admin/player.fields.om') }}</option>
                                                <option value="ks" @if($data->team == 'ks') selected @endif>{{ __('admin/player.fields.ks') }}</option>
                                            </select>
                                            @error('team')<span class="text-danger">{{ $message }}</span>@enderror
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="card card-box custom mb-10" id="accordionStatus">
                                <div class="card-header" data-toggle="collapse" href="#collapseStatus">
                                    <a class="card-title">{{ __('admin/player.fields.category') }}
                                    </a>
                                </div>
                                <div id="collapseStatus" class="card-body show" data-parent="#accordionStatus" >

                                    <div class="form-group row">
                                        <div class="col-sm-12 col-md-12">
                                            <select name="category" id="category" class="border-gray-300 rounded-md shadow-sm custom-select col-12 @error('category') border border-danger @enderror">
                                                <option  @if($data->category == '') selected @endif>{{ __('admin/player.fields.choose') }}</option>
                                                <option value="light" @if($data->category == 'light') selected @endif>{{ __('admin/player.fields.light') }}</option>
                                                <option value="medium" @if($data->category == 'medium') selected @endif>{{ __('admin/player.fields.medium') }}</option>
                                                <option value="strongest" @if($data->category == 'strongest') selected @endif>{{ __('admin/player.fields.strongest') }}</option>
                                            </select>
                                            @error('category')<span class="text-danger">{{ $message }}</span>@enderror
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>

                        <div class="col-sm-12 col-md-10">
                            <button class="btn btn-primary bg-gray-800" type="submit">{{ __('admin/player.fields.update') }}</button>
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

            $("#mode_type").change(function() {
                if ($(this).val() === 'super'){
                    $('.exp_date').show();
                } else {
                    $('.exp_date').hide();
                }
            });
        </script>
    @endsection
    @section('page_title'){{  __('admin/player.edit.title_tag',['name' => $data->name]) }}@endsection
</x-admin-layout>
