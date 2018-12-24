<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">{{ $title }}</h3>
  </div>
  <div class="panel-body">
    <table class="table table-bordered table-striped">
        <tr>
            @foreach ($headers as $header)
                <th>{{ $header }}</th>
            @endforeach
            <th>操作</th>
        </tr>
        @foreach ($data as $items)
            <tr>
                @foreach ($items as $key => $item)
                    @if ($key === 'ip')
                    <td><b>@join($item)</b></td>
                    @else
                    <td>{{ $item }}</td>
                    @endif
                @endforeach
                <td class="text-center">@includeIf('show.widgets.action',['id' => $items['id']])</td>
            </tr>
        @endforeach
    </table>
  </div>
</div>

