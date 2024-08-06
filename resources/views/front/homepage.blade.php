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
                                <option value="light">الوزن الخفيف</option>
                                <option value="medium">الوزن المتوسط</option>
                                <option value="strongest">أقوى رجل خليجى</option>
                            </select>
                        </div>
                    </th>
                    <th class="col-12 col-lg-4 col-sm-12">
                        <div class="search-label">
                            <select name="game" id="status-filter" class="form-control" required>
                                <option value="all">جميع الألعاب</option>
                                @foreach($games as $game)
                                    <option value="{{ $game->id }}">{{ $game->name }}</option>
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


            <div class="results panel panel-primary filterable mt-30">
                <div class="panel-heading mb-30">
                    <h3 class="panel-title">نتائج جميع اللاعبين فى كل الألعاب </h3>
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
                    @if(!empty($players))
                        @php $counter = 1; @endphp
                    @foreach($players as $key => $player)
                        <tr>
                            <td>{{ $counter }}</td>
                            <td>{{ $player->num }}</td>
                            <td>{{ $player->name }}</td>
                            <td>{{ $player->final_result }}</td>
                        </tr>
                        @php $counter++ @endphp
                    @endforeach
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @section('page_title'){{ __('front/common.title_tag') }}@endsection
</x-app-layout>