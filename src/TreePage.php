<?php

namespace Yemenpoint\FilamentTree;

use Filament\Resources\Pages\Page;

abstract class TreePage extends Page
{
    protected static string $resource;

    protected static string $view = 'filament-tree::tree-page';

    public int $maxDepth = 999;

    public function getMaxDepth(): int
    {
        return $this->maxDepth;
    }


    public abstract function getItems(): array;

    protected function getViewData(): array
    {
        return [
            "items" => $this->getItems()
        ];
    }

    public function updateTree($tree)
    {
        try {
            $model = static::getModel();

            list($status, $message) = $model::SaveTree($tree);

            if ($status && $message) {
                $this->notify($status, $message);
            }

        } catch (\Exception $e) {
            $this->notify("error", "something went wrong");
        }
    }

}
