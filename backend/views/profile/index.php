<?php

use app\models\User;
use app\models\UserProfile;
use yii\helpers\Html;
use yii\helpers\Url;

$fullname = Yii::$app->user->isGuest ? 'User' : Yii::$app->user->identity->userProfile->firstname . ' ' . Yii::$app->user->identity->userProfile->lastname;
$designation = Yii::$app->user->identity->userProfile->designation->name;
$personnelId = Yii::$app->user->identity->id


?>

<div class="col-6-md">
    <div class="card card-widget widget-user">
        <div class="widget-user-header bg-info">
            <div class="widget-user-image">
                <img class="img-circle elevation-2" src=<?= "@web/images/Portait_Placeholder.jpg" ?> alt="User Avatar">
            </div>
            <h3 class="widget-user-username"><?= $fullname ?></h3>
            <h5 class="widget-user-desc"><?= $designation ?></h5>
        </div>
        <div class="card-footer p-o">
            <ul class="nav flex-column">
                <li class="nav-item">

                    <?= Html::a('Change Password <span class=" float-right badge bg-primary">31</span>', ['/profile/change-password'], ['class' => 'nav-link']) ?>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        Tasks <span class="float-right badge bg-info">5</span>
                    </a>
                </li>
                <li class="nav-item">

                    Completed Projects <span class="float-right badge bg-success">12</span>

                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        Followers <span class="float-right badge bg-danger">842</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>