@php

    $tree_id = "tree" . \Illuminate\Support\Str::slug($getStatePath(), "_");
    $items = $getValue();
@endphp

@include("filament-tree::tree-assets")

<script>
    function {{$tree_id}}treeHandel(config) {
        return {
            value: config.value,
            changed_value: null,
            {{$tree_id}}init: function () {
                $('#{{$tree_id}}').nestable({
                    group: {{$tree_id}},
                    maxDepth: {{ $getMaxDepth()}}
                }).on('change', function () {
                    this.value = $('#{{$tree_id}}').nestable('serialize');
                }.bind(this));


                $('#expand').on('click', function (e) {
                    $('#{{$tree_id}}').nestable('expandAll');
                });

                $('#collapse').on('click', function (e) {
                    $('#{{$tree_id}}').nestable('collapseAll');
                });
            }
        }
    }
</script>
<x-forms::field-wrapper
        :id="$getId()"
        :label="$getLabel()"
        :label-sr-only="$isLabelHidden()"
        :helper-text="$getHelperText()"
        :hint="$getHint()"
        :hint-icon="$getHintIcon()"
        :required="$isRequired()"
        :state-path="$getStatePath()"
>
    <div wire:ignore x-data="{{$tree_id}}treeHandel({
            value: $wire.entangle('{{ $getStatePath() }}').defer
        })" x-init="{{$tree_id}}init()">

        <menu id="nestable-menu">
            <button id="expand" type="button"
                    class="filament-button filament-button-size-md inline-flex items-center justify-center py-1 gap-1 font-medium rounded-lg border transition-colors focus:outline-none focus:ring-offset-2 focus:ring-2 focus:ring-inset dark:focus:ring-offset-0 min-h-[2.25rem] px-4 text-sm text-white shadow focus:ring-white border-transparent bg-primary-600 hover:bg-primary-500 focus:bg-primary-700 focus:ring-offset-primary-700 filament-page-button-action">
                <span class="flex items-center gap-1"> Expand All</span>

            </button>
            <button id="collapse" type="button"
                    class="filament-button filament-button-size-md inline-flex items-center justify-center py-1 gap-1 font-medium rounded-lg border transition-colors focus:outline-none focus:ring-offset-2 focus:ring-2 focus:ring-inset dark:focus:ring-offset-0 min-h-[2.25rem] px-4 text-sm text-white shadow focus:ring-white border-transparent bg-primary-600 hover:bg-primary-500 focus:bg-primary-700 focus:ring-offset-primary-700 filament-page-button-action">
                <span class="flex items-center gap-1">Collapse All</span>

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


    </div>
</x-forms::field-wrapper>
