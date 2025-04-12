<?php

use app\models\ShortUrl;
use app\models\ShortUrlForm;
use kartik\form\ActiveForm;
use yii\bootstrap5\Html;
use yii\helpers\Url;
use yii\web\View;

/** @var View $this */
/** @var ShortUrlForm $shortUrlForm */
/** @var ShortUrl $shortUrl */
?>
<h3>Версия Ajax</h3>
<div class="row аjax-version-form">
    <div class="col-md-8">
        <?php $form = ActiveForm::begin([
            'id' => 'ajax-generator-short-url-form',
            'type' => ActiveForm::TYPE_FLOATING,
            'enableAjaxValidation' => true,
            'enableClientValidation' => false,
            'validateOnBlur' => false,
            'options' => ['data' => ['pjax' => false]],
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
<?php

$script = <<< JS

$(document).ready(function () {
    var \$form = $("#ajax-generator-short-url-form");
    \$form.on('beforeSubmit', function (event) {
        event.preventDefault();
        console.log('Form Ajax Submit');
        $.ajax({
            "type": "POST",
            "url": \$form.attr('action'),
            "data": \$form.serialize(),
            "beforeSend": function (xhr) {
            },
            "dataType": "json",
            "cache": true,
            success: function (response) {
                if (response.success) {
                    $(".аjax-version-form .short-url-detail").replaceWith(response.htmlShortUrl);
                } else {
                    alert('Возникла ошибка при обработке запроса1');
                }
            },
            error: function (data) {
                alert('Возникла ошибка при обработке запроса2');
            }
        });
        return false
    });
});         

JS;
$this->registerJs($script);
