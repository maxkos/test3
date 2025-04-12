<?php


namespace app\assets;


use yii\web\AssetBundle;
use yii\web\YiiAsset;

/**
 * Class FontAwesomeAsset
 */
class FontAwesomeAsset extends AssetBundle
{
    /**
     * @var string
     */
    public $sourcePath = '@bower/fontawesome';

    /**
     * @var string[]
     */
    public $css = [
        'css/all.min.css'
    ];

    /**
     * @var array
     */
    public $depends = [
        YiiAsset::class,
    ];

}
