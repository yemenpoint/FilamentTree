<li class="dd-item" data-id="{{data_get($item,"id")}}" data-name="{{data_get($item,"name")}}">
    <div class="dd-handle">{{data_get($item,"name")}}</div>
    <ol class="dd-list">
        @if(count($children = data_get($item,"children",[])))
            @foreach ($children as $child)
                @include("filament-tree::components.tree-item", ["item"=> $child])
            @endforeach
        @endif
    </ol>
</li>
