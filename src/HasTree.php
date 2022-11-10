<?php

namespace Yemenpoint\FilamentTree;

trait HasTree
{
    public static function orderColumnName(): string
    {
        return "order";
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

        self::upsert($readyItems, ['id']);

        return ["success", "tree updated"];
    }


    public static function prepareNode(&$readyItems, $item, $parent_id = null)
    {
        $readyItems[] = [
            "id" => data_get($item, 'id'),
            "parent_id" => $parent_id,
        ];

        if ($children = data_get($item, "children", [])) {
            foreach ($children as $child) {
                self::prepareNode($readyItems, $child, data_get($item, 'id'));
            }
        }
    }

}