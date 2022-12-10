@php
    $tree_id = "tree_view_id";
@endphp

@include("filament-tree::tree-assets")
<script>
    $(document).ready(function () {

        $('#{{$tree_id}}').nestable({
            group: {{$tree_id}},
            maxDepth: {{ $this->getMaxDepth()}},
            onDragStart: function (l, e) {
                return {{$this->isDisabled() ? "false" : "true"}};
            }
        });


        $('#save').on('click', async function (e) {
            $("#loading").show();
            await @this.updateTree($('#{{$tree_id}}').nestable('serialize'));
            $("#loading").hide();
        });

        $('#expand').on('click', function (e) {
            $('#{{$tree_id}}').nestable('expandAll');
        });

        $('#collapse').on('click', function (e) {
            $('#{{$tree_id}}').nestable('collapseAll');
        });

    });
</script>
<x-filament::page class="col-span-6">

    <menu id="nestable-menu">
        <button id="expand" type="button"
                class="filament-button filament-button-size-md inline-flex items-center justify-center py-1 gap-1 font-medium rounded-lg border transition-colors focus:outline-none focus:ring-offset-2 focus:ring-2 focus:ring-inset dark:focus:ring-offset-0 min-h-[2.25rem] px-4 text-sm text-white shadow focus:ring-white border-transparent bg-primary-600 hover:bg-primary-500 focus:bg-primary-700 focus:ring-offset-primary-700 filament-page-button-action">
            <span class="flex items-center gap-1">{{__("filament-tree::filament-tree.expand_all")}}</span>

        </button>
        <button id="collapse" type="button"
                class="filament-button filament-button-size-md inline-flex items-center justify-center py-1 gap-1 font-medium rounded-lg border transition-colors focus:outline-none focus:ring-offset-2 focus:ring-2 focus:ring-inset dark:focus:ring-offset-0 min-h-[2.25rem] px-4 text-sm text-white shadow focus:ring-white border-transparent bg-primary-600 hover:bg-primary-500 focus:bg-primary-700 focus:ring-offset-primary-700 filament-page-button-action">
            <span class="flex items-center gap-1">{{__("filament-tree::filament-tree.collapse_all")}}</span>

        </button>
    </menu>

    <div class="dd" id="{{$tree_id}}">
        <ol class="dd-list">
            @if($items && is_array($items))
                @foreach ($items as $item)
                    @include("filament-tree::components.tree-item", ["item"=> $item])
                @endforeach
            @endif
        </ol>
    </div>
    @if(!$this->isDisabled())

        <button id="save" wire:loading.attr="disabled"
                wire:loading.class.delay="opacity-70 cursor-wait"
                class="filament-button filament-button-size-md inline-flex items-center justify-center py-1 gap-1 font-medium rounded-lg border transition-colors focus:outline-none focus:ring-offset-2 focus:ring-2 focus:ring-inset dark:focus:ring-offset-0 min-h-[2.25rem] px-4 text-sm text-white shadow focus:ring-white border-transparent bg-primary-600 hover:bg-primary-500 focus:bg-primary-700 focus:ring-offset-primary-700 filament-page-button-action">

            <x-filament-support::loading-indicator id="loading" style="display:none" class="w-4 h-4"/>

            <span class="flex items-center gap-1">{{__("filament-tree::filament-tree.save")}}</span>

        </button>
    @endif

</x-filament::page>
