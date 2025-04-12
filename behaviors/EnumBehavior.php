<?php

namespace app\behaviors;

use yii\base\Behavior;
use yii\base\InvalidConfigException;
use yii\db\ActiveRecord;

class EnumBehavior extends Behavior
{
    /**
     * @var string|integer
     */
    public string|int $attribute;

    /**
     * @var string
     */
    public string $enumClass;

    /**
     * @return void
     * @throws InvalidConfigException
     */
    public function init()
    {
        parent::init();

        if (empty($this->attribute))
            throw new InvalidConfigException('The "attribute" property must be set.');


        if (empty($this->enumClass))
            throw new InvalidConfigException('The "enumClass" property must be set.');
    }

    public function events()
    {
        return [
            ActiveRecord::EVENT_BEFORE_VALIDATE => 'destroyEnum',
            ActiveRecord::EVENT_AFTER_VALIDATE => 'initEnum',
            ActiveRecord::EVENT_BEFORE_INSERT => 'destroyEnum',
            ActiveRecord::EVENT_BEFORE_UPDATE => 'destroyEnum',
            ActiveRecord::EVENT_AFTER_INSERT => 'initEnum',
            ActiveRecord::EVENT_AFTER_UPDATE => 'initEnum',
            ActiveRecord::EVENT_AFTER_FIND => 'initEnum',
        ];
    }

    /**
     * @return void
     */
    public function initEnum(): void
    {
        $currentValue = $this->owner->getAttribute($this->attribute);
        $this->owner->setOldAttribute($this->attribute, call_user_func_array([$this->enumClass, 'from'], [$currentValue]));
        try {
            if (isset($currentValue) && $currentValue !== '')
                $this->owner->setAttribute($this->attribute, call_user_func_array([$this->enumClass, 'tryFrom'], [(int)$currentValue]));

        } catch (\Throwable $e) {
        }
    }

    /**
     * @return void
     */
    public function destroyEnum(): void
    {
        $currentValue = $this->owner->getAttribute($this->attribute);
        if ($currentValue instanceof $this->enumClass) {
            $this->owner->setAttribute($this->attribute, $currentValue->value);
            $this->owner->setOldAttribute($this->attribute, $currentValue->value);
        }
    }
}
