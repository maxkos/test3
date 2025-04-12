<?php

namespace yii\helpers;


use app\traits\EnumTrait;

class Html extends BaseHtml
{

    use EnumTrait;

    const TYPE_LABEL__SECONDARY = 'secondary';
    const TYPE_LABEL__DEFAULT = 'default';
    const TYPE_LABEL__DANGER = 'danger';
    const TYPE_LABEL__INFO = 'info';
    const TYPE_LABEL__PRIMARY = 'primary';
    const TYPE_LABEL__WARNING = 'warning';
    const TYPE_LABEL__KRASGMU = 'krasgmu';
    const TYPE_LABEL__SUCCESS = 'success';

    const TYPE_LABELS = [
        'secondary',
        'default',
        'danger',
        'info',
        'primary',
        'success',
        'warning',
    ];

    /**
     */
    public static function renderLabel($content, $type = 'default', $options = [], $icon = null): string
    {
        $options = array_merge(['class' => 'badge'], $options);

        if (is_array($content)) {
            if (!empty($data['type']))
                $type = $data['type'];
            if (!empty($data['icon']))
                $icon = $data['icon'];
            if (!empty($data['content']))
                $content = $data['content'];
        }
        if (!in_array($type, self::getConstants('TYPE_LABEL__')))
            $type = 'default';
        if ($icon)
            $content = self::icon($icon) . ' ' . self::tag('span', $content, ['class' => 'badge-text']);
        $options['class'] = $options['class'] . ' bg-' . $type;
        return Html::tag('span', $content, $options);
    }

    /**
     * @param $code
     * @param array $options
     * @return string
     */
    public static function icon($code, $options = []): string
    {
        $_fa = 'fas ' . 'fa-' . $code;
        $options['class'] = !empty($options['class']) ? $options['class'] . ' ' . $_fa : $_fa;
        return self::tag('i', '', $options);
    }

}