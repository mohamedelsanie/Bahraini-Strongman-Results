<x-admin-layout>
    <x-slot name="header">
        <div class="page-header mb-0">
            <div class="row">
                <div class="col-md-12 col-sm-12">
                    <nav aria-label="breadcrumb" role="navigation">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('admin/common.home')}}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ __('admin/setting.title') }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </x-slot>
    @php
        $field1 = 'site_logo';
        $field2 = 'site_favicon';
    @endphp
    <div class="py-12">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <div class="clearfix mb-10">
                    <div class="pull-left">
                        <h4 class="text-blue h4">{{ __('admin/setting.title') }}</h4>
                    </div>
                </div>
                <div class="dropdown-divider"></div>

                <form action="{{ route('admin.settings.store') }}" method="post" class="mt-6 space-y-6">
                    @csrf

                    <div class="form-group row">
                        <label class="col-sm-12 col-md-2 col-form-label">{{ __('admin/setting.site_name') }}</label>
                        <div class="col-sm-12 col-md-10">
                            <div class="tab-content">

                                <input name="site_name" placeholder="{{ __('admin/setting.site_name') }}" value="{{ $setting->site_name }}" class="border-gray-300 rounded-md shadow-sm form-control @error('site_name') border border-danger @endif" type="text"/>
                                @error('site_name')<span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-12 col-md-2 col-form-label">{{ __('admin/setting.site_url') }}</label>
                        <div class="col-sm-12 col-md-10">
                            <input name="site_url" placeholder="{{ __('admin/setting.site_url') }}" value="{{ $setting->site_url }}" class="border-gray-300 rounded-md shadow-sm form-control @error('site_url') border border-danger @enderror" type="text"/>
                            @error('site_url')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>



                    <div class="form-group row">
                        <label class="col-sm-12 col-md-2 col-form-label">{{ __('admin/setting.site_slogan') }}</label>
                        <div class="col-sm-12 col-md-10">

                            <div class="tab-content">
                                <input name="site_slogan" placeholder="{{ __('admin/setting.site_slogan') }}" value="{{ $setting->site_slogan }}" class="border-gray-300 rounded-md shadow-sm form-control @error('site_slogan') border border-danger @endif" type="text"/>
                                @error('site_slogan')<span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                        </div>
                    </div>


                    <div class="form-group row">
                        <label class="col-sm-12 col-md-2 col-form-label">{{ __('admin/setting.site_perpage') }}</label>
                        <div class="col-sm-12 col-md-10">
                            <input name="posts_per_page" placeholder="{{ __('admin/setting.site_perpage') }}" value="{{ $setting->posts_per_page }}" class="border-gray-300 rounded-md shadow-sm form-control @error('posts_per_page') border border-danger @enderror" type="text"/>
                            @error('posts_per_page')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>


                    <div class="form-group row">
                        <label class="col-sm-12 col-md-2 col-form-label">{{ __('admin/setting.site_meta_desc') }}</label>
                        <div class="col-sm-12 col-md-10">

                            <div class="tab-content">
                                <input name="site_meta_description" placeholder="{{ __('admin/setting.site_meta_desc') }}" value="{{ $setting->site_meta_description }}" class="border-gray-300 rounded-md shadow-sm form-control @error('site_meta_description') border border-danger @endif" type="text"/>
                                @error('site_meta_description')<span class="text-danger">{{ $message }}</span>@enderror

                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-12 col-md-2 col-form-label">{{ __('admin/setting.site_meta_tags') }}</label>
                        <div class="col-sm-12 col-md-10">

                            <div class="tab-content">
                                <input name="site_meta_keywords" placeholder="{{ __('admin/setting.site_meta_tags') }}" value="{{ $setting->site_meta_keywords }}" class="border-gray-300 rounded-md shadow-sm form-control @error('site_meta_keywords') border border-danger @endif" type="text"/>
                                @error('site_meta_keywords')<span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                        </div>
                    </div>


                    <div class="form-group row" id="user_image_field_{{$field1}}">
                        <label class="col-sm-12 col-md-2 col-form-label">{{ __('admin/setting.site_logo') }}</label>
                        <div class="col-sm-6 col-md-6 hidden">
                            <input name="site_logo" id="user_image_{{$field1}}" placeholder="{{ __('admin/setting.site_logo') }}" value="{{ $setting->site_logo }}" class="hidden form-control @error('site_logo') border border-danger @enderror" type="text"/>
                            @error('site_logo')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                        <div class="col-sm-12 col-md-10">
                            {{--@livewire('admin.media-upload')--}}
                            <div class="image_preview" style="float: left; margin-right: 20px;">
                                @if($setting->site_logo)
                                    <img src="{{ $setting->site_logo }}" width="100" />
                                @endif
                            </div>
                            <a href="#" class="btn-block" data-toggle="modal" data-target=".media_uploader_{{ $field1 }}" type="button">{{ __('admin/setting.media') }}</a>
                        </div>
                    </div>


                    <div class="form-group row" id="user_image_field_{{$field2}}">
                        <label class="col-sm-12 col-md-2 col-form-label">{{ __('admin/setting.site_favicon') }}</label>
                        <div class="col-sm-6 col-md-6 hidden">
                            <input name="site_favicon" id="user_image_{{$field2}}" placeholder="{{ __('admin/setting.site_favicon') }}" value="{{ $setting->site_favicon }}" class="hidden form-control @error('site_favicon') border border-danger @enderror" type="text"/>
                            @error('site_favicon')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                        <div class="col-sm-12 col-md-10">
                            {{--@livewire('admin.media-upload')--}}
                            <div class="image_preview" style="float: left; margin-right: 20px;">
                                @if($setting->site_favicon)
                                    <img src="{{ $setting->site_favicon }}" width="100" />
                                @endif
                            </div>
                            <a href="#" class="btn-block" data-toggle="modal" data-target=".media_uploader_{{$field2}}" type="button">{{ __('admin/setting.media') }}</a>
                        </div>
                    </div>


                    <div class="form-group row">
                        <label class="col-sm-12 col-md-2 col-form-label">{{ __('admin/setting.site_status') }}</label>
                        <div class="col-sm-12 col-md-10">
                            <select name="site_status" id="site_status" class="border-gray-300 rounded-md shadow-sm custom-select col-12 @error('site_status') border border-danger @enderror">
                                <option value="" @if($setting->site_status == '') selected @endif>{{ __('admin/setting.choose') }}</option>
                                <option value="publish" @if($setting->site_status == 'publish') selected @endif>{{ __('admin/setting.publish') }}</option>
                                <option value="closed" @if($setting->site_status == 'closed') selected @endif>{{ __('admin/setting.closed') }}</option>
                            </select>
                            @error('site_status')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    <div class="form-group row close_msg" @if($setting->site_status != 'closed') style="display: none" @endif>
                        <label class="col-sm-12 col-md-2 col-form-label">{{ __('admin/setting.site_close_msg') }}</label>
                        <div class="col-sm-12 col-md-10">
                            <div class="tab-content">
                                <textarea name="close_msg" placeholder="{{ __('admin/setting.site_close_msg') }}" class="border-gray-300 rounded-md shadow-sm form-control @error('close_msg') border border-danger @endif" >{{ $setting->close_msg }}</textarea>
                                @error('close_msg')<span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                        </div>
                    </div>


                    <div class="form-group row">
                        <label class="col-sm-12 col-md-2 col-form-label">{{ __('admin/setting.dashboard_perpage') }}</label>
                        <div class="col-sm-12 col-md-10">
                            <input name="admin_paginate" placeholder="{{ __('admin/setting.dashboard_perpage') }}" value="{{ $setting->admin_paginate }}" class="border-gray-300 rounded-md shadow-sm form-control @error('admin_paginate') border border-danger @enderror" type="text"/>
                            @error('admin_paginate')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    <button class="btn btn-primary bg-gray-800" type="submit">{{ __('admin/setting.update') }}</button>

                </form>


            </div>
        </div>
    </div>

    <div id="user_image_modal_{{$field1}}">
        <livewire:admin.media-box :field="$field1"  />
    </div>

    <div id="user_image_modal_{{$field2}}">
        <livewire:admin.media-box :field="$field2"  />
    </div>


    @section('scripts')
        <script>
            $('#user_image_modal_{{$field1}} #gallery_{{$field1}} a.image_ch').click(function(){
                $('#user_image_field_{{$field1}} #user_image_{{$field1}}').val($(this).data('image'));
                var value = $("#user_image_{{$field1}}").val();
                $("#user_image_field_{{$field1}} .image_preview").html('<a class="cursor-pointer remove_img"><i class="fa fa-times-circle text-gray-700 text-2x1 float-left"></i><img src="'+value+'" width="100" /></a>');

                $("#user_image_field_{{$field1}} .image_preview a.remove_img").click(function(){
                    $('#user_image_field_{{$field1}} #user_image_{{$field1}}').val('');
                    $("#user_image_field_{{$field1}} .image_preview a.remove_img").remove();
                });
                //$('.media_uploader').modal('hide');
            });

            $('#user_image_modal_{{$field2}} #gallery_{{$field2}} a.image_ch').click(function(){
                $('#user_image_field_{{$field2}} #user_image_{{$field2}}').val($(this).data('image'));
                var value = $("#user_image_{{$field2}}").val();
                $("#user_image_field_{{$field2}} .image_preview").html('<a class="cursor-pointer remove_img"><i class="fa fa-times-circle text-gray-700 text-2x1 float-left"></i><img src="'+value+'" width="100" /></a>');

                $("#user_image_field_{{$field2}} .image_preview a.remove_img").click(function(){
                    $('#user_image_field_{{$field2}} #user_image_{{$field2}}').val('');
                    $("#user_image_field_{{$field2}} .image_preview a.remove_img").remove();
                });
            });


            $("#site_status").change(function() {
                if ($(this).val() === 'closed'){
                    $('.close_msg').show();
                } else {
                    $('.close_msg').hide();
                }
            });


        </script>
    @endsection
    @section('page_title'){{ __('admin/setting.title_tag') }}@endsection
</x-admin-layout>
