<?php

namespace Yemenpoint\FilamentTree;

use Filament\Resources\Pages\Page;

abstract class TreePage extends Page
{
    protected static string $resource;

    protected static string $view = 'filament-tree::tree-page';

    public function getMaxDepth(): int
    {
        return 999;
    }

    public function isDisabled(): bool
    {
        return false;
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
        if ($this->isDisabled()) {
            return;
        }
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
