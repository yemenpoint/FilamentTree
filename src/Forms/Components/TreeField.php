<?php

namespace Yemenpoint\FilamentTree\Forms\Components;

use Filament\Forms\Components\Field;

class TreeField extends Field
{
    protected string $view = 'filament-tree::components.tree-field';

    public int $maxDepth = 999;

    public function getMaxDepth(): int
    {
        return $this->maxDepth;
    }


    public function setMaxDepth(int $maxDepth)
    {
        $this->maxDepth = $maxDepth;
        return $this;
    }


    public function getValue()
    {
        $state = parent::getState();

        if (is_array($state)) {
            return $state;
        } else {
            try {
                return json_decode($state, true);
            } catch (\Exception $e) {
                return [];
            }
        }
    }

    public function getState()
    {
        $state = parent::getState();

        if (is_array($state)) {
            return json_encode($state);
        } else {
            try {
                return $state;
            } catch (\Exception $e) {
                return json_encode([]);
            }
        }
    }
}
