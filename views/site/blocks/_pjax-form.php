<?php

use app\models\ShortUrl;
use app\models\ShortUrlForm;
use kartik\form\ActiveForm;
use yii\bootstrap5\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\Pjax;

/** @var View $this */
/** @var ShortUrlForm $shortUrlForm */
/** @var ShortUrl $shortUrl */

?>
    <h3>Версия PJAX</h3>
<?php Pjax::begin(['id' => 'generate_url']); ?>
    <div class="row pjax-version-form">
        <div class="col-md-8">
            <?php $form = ActiveForm::begin([
                'id' => 'pjax-generator-short-url-form',
                'type' => ActiveForm::TYPE_FLOATING,
                'enableAjaxValidation' => true,
                'enableClientValidation' => false,
                'validateOnBlur' => false,
                'options' => ['data' => ['pjax' => true]],
                'validationUrl' => Url::toRoute(['/site/short-url-validate'])
            ]); ?>
            <?php echo $form->field($shortUrlForm, 'url')->textInput(['autofocus' => true, 'placeholder' => 'Укажите ссылку для генерации']) ?>
            <div class="form-group text-center">
                <?php echo Html::submitButton('Сгенерировать', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
        <div class="col-md-4">
            <?php echo $this->render('_short-url', ['shortUrl' => $shortUrl]); ?>
        </div>
    </div>
<?php Pjax::end();