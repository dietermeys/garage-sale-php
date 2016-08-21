<form class="form-inline" role="form" method="GET">
    <div class="form-group col-xs-4 col-md-4 search1">
        <label class="control-label" for="search">Title or summary: </label>
        <div class="input-group">
            <div class="input-group-addon">
                <i class="fa fa-list" aria-hidden="true"></i>
            </div>
            <input type="text" class="form-control" id="search" placeholder="Search"
                   value="{{ \Request::get('search') }}"
                   name="search"
            >
        </div>
    </div>
    <div class="form-group col-xs-4 col-md-4 search1">
        <label class="control-label" for="price_start">Price start: </label>
        <div class="input-group">
            <div class="input-group-addon">
                <i class="fa fa-money" aria-hidden="true"></i>
            </div>
            <input type="text" class="form-control" id="price_start" placeholder="5.00"
                   value="{{ \Request::get('price_start') }}"
                   name="price_start"
            >
        </div>
    </div>

    <div class="form-group col-xs-4 col-md-4 search1">
        <label class="control-label" for="price_end">Price end: </label>
        <div class="input-group">
            <div class="input-group-addon">
                <i class="fa fa-money" aria-hidden="true"></i>
            </div>
            <input type="text" class="form-control" id="price_end" placeholder="10.00"
                   value="{{ \Request::get('price_end') }}"
                   name="price_end"
            >
        </div>
    </div>

    <div class="form-group col-xs-4 col-md-4 search1">
        <label class="control-label" for="category_id">Category: </label>
        <div class="input-group">
            <div class="input-group-addon">
                <i class="fa fa-folder-open-o" aria-hidden="true"></i>
            </div>

            <select id="category_id" class="form-control" name="category_id"
                    value="{{ \Request::get('category_id') }}">
                <option value="">-- Choose --</option>
                @foreach($categories as $category)
                    <option value="{{$category->id}}"
                            @if ($category->id == old('category_id'))
                            selected
                            @endif
                    >{{$category->name}}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="form-group col-xs-4 col-md-4 search1">
        <label class="control-label" for="distance">Distance: </label>
        <div class="input-group">
            <div class="input-group-addon">
                <i class="fa fa-compass" aria-hidden="true"></i>
            </div>
            <input type="text" class="form-control" id="distance" placeholder="15 (in km)"
                   value="{{ \Request::get('distance') }}"
                   name="distance"
            >
        </div>
    </div>
    <div class="form-group col-xs-4 col-md-4 button1">
        <label class="control-label" for="button">Search: </label>
        <button type="submit" id="button" class="btn btn-success"><i class="fa fa-search" aria-hidden="true"></i></button>
    </div>

</form>