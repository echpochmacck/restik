<?php

use yii\bootstrap5\Html;

?>

<?php if (!Yii::$app->user->isGuest):?>
   <?= Html::a('пассировка', 'site/check-pass', ['class' => 'btn btn-primary']);?>
   <div class="my-2"><?=  Html::a('Каллории', 'site/callor', ['class' => 'btn btn-primary my-2']);?></div>
   <div class="my-2"><?=  Html::a('макс категория', 'site/max', ['class' => 'btn btn-primary my-2']);?></div>
   <div class="my-2"><?=  Html::a('супы ', 'site/check', ['class' => 'btn btn-primary my-2']);?></div>


<?php else:?>
<h3>Ввойдите в систему</h3>;
<?php endif ?>
