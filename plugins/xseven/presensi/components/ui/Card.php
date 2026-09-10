<?php namespace XSeven\Presensi\Components\Ui;

use Cms\Classes\ComponentBase;

class Card extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name'        => 'Card',
            'description' => 'Card container. Variant "card-table" untuk table card.',
        ];
    }

    public function defineProperties()
    {
        return [
            'variant' => [
                'title'   => 'Variant',
                'type'    => 'dropdown',
                'options' => ['' => 'Default', 'card-table' => 'Card Table'],
                'default' => '',
            ],
        ];
    }

    public function onRun()
    {
        $this->page['uiCardVariant'] = $this->property('variant');
    }
}
