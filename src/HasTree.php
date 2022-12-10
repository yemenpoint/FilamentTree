<?php

namespace Yemenpoint\FilamentTree;

trait HasTree
{
    public static function orderColumnName(): string
    {
        return "order";
    }
    public static function parentColumnName(): string
    {
        return "parent_id";
    }

    public static function SaveTree($tree = null)
    {
        $readyItems = [];
        foreach ($tree as $item) {
            self::prepareNode($readyItems, $item);
        }

        foreach ($readyItems as $key => &$item) {
            $item[self::orderColumnName()] = $key;
        }
        foreach ($readyItems as $i) {
            self::where("id",data_get($i,"id"))->update($i);
        }

        return ["success", __("filament-tree::filament-tree.tree_saved_message")];
    }


    public static function prepareNode(&$readyItems, $item, $parent_id = null)
    {
        $readyItems[] = [
            "id" => data_get($item, 'id'),
            self::parentColumnName() => $parent_id,
        ];

        if ($children = data_get($item, "children", [])) {
            foreach ($children as $child) {
                self::prepareNode($readyItems, $child, data_get($item, 'id'));
            }
        }
    }

}