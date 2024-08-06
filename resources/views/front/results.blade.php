<x-app-layout>
    <div class="container">
        <div class="row">

            <table class="table mt-30">
                <thead>
                <form method="post" action="{{ route('search') }}">
                    @csrf
                <tr class="filters">
                    <th class="col-12 col-lg-4 col-sm-12">
                        <div class="search-label">
                            <select name="category" id="assigned-user-filter" class="form-control" required>
                                <option value="all">جميع الفئات</option>
                                <option value="light" @if(request('category') == 'light') selected @endif>الوزن الخفيف</option>
                                <option value="medium" @if(request('category') == 'medium') selected @endif>الوزن المتوسط</option>
                                <option value="strongest" @if(request('category') == 'strongest') selected @endif>أقوى رجل خليجى</option>
                            </select>
                        </div>
                    </th>
                    <th class="col-12 col-lg-4 col-sm-12">
                        <div class="search-label">
                            <select name="game" id="status-filter" class="form-control" required>
                                <option value="all" @if(request('game') == 'all') selected @endif>جميع الألعاب</option>
                                @foreach($games as $game)
                                    <option value="{{ $game->id }}" @if(request('game') == $game->id) selected @endif>{{ $game->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </th>

                    <th class="col-12 col-lg-4 col-sm-12">
                        <div class="search-label">
                            <button type="submit" class="btn btn-warning"><i class="fa fa-search"></i> البحث</button>
                        </div>
                    </th>
                </form>
                </thead>
            </table>
            <div class="selected_search">
                <div class="row">
                    <div class="col-12 col-lg-4 col-sm-12">
                        <h3> الوزن : {{ $category }}</h3>
                    </div>
                    <div class="col-12 col-lg-4 col-sm-12">
                        <h3> اللعبة : {{ $tgame->name ?? $tgame }}</h3>
                    </div>
                </div>
            </div>


            <div class="results panel panel-primary filterable mt-30">
                <div class="panel-heading mb-30">
                    <h3 class="panel-title">نتائج البحث</h3>
                    <div class="pull-right"></div>
                </div>
                <table id="task-list-tbl" class="table table nowrap table-bordered table-striped no-footer dtr-inline ">
                    <thead>
                    <tr>
                        <th>الترتيب</th>
                        <th>رقم اللاعب</th>
                        <th>اسم اللاعب</th>
                        <th>مجموع النقاط</th>
                    </tr>
                    </thead>

                    <tbody>
                    @if(!empty($results))
                        @if(request('game') == 'all')
                            @php $counter = 1; @endphp
                            @foreach($results as $key => $result)
                                <tr>
                                    <td>{{ $counter }}</td>
                                    <td>{{ $result->num }}</td>
                                    <td>{{ $result->name }}</td>
                                    <td>{{ $result->final_result }}</td>
                                </tr>
                                @php $counter++ @endphp
                            @endforeach
                        @else
                            @php $counter = 1; @endphp
                            @foreach($results as $key => $result)
                                @php $player = \App\Models\Player::where(['id' => $result->player_id])->first(); @endphp
                                <tr>
                                    <td>{{ $counter }}</td>
                                    <td>{{ $player->num }}</td>
                                    <td>{{ $player->name }}</td>
                                    <td>{{ $result->result }}</td>
                                </tr>
                                @php $counter++ @endphp
                            @endforeach
                        @endif
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @section('page_title'){{ __('front/common.title_tag') }}@endsection
</x-app-layout>