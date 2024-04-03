<?php

namespace app\controllers;

use app\models\ContactDetail;
use app\models\SignupForm;
use app\models\UserProfile;
use app\models\UserProfileSearch;
use Exception;
use Yii;
use app\models\Model;
use yii\bootstrap4\ActiveForm;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\Response;

/**
 * UserProfileController implements the CRUD actions for UserProfile model.
 */
class UserProfileController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::class,
                    'actions' => [
                        'delete' => ['POST'],
                        'toggleStatus' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all UserProfile models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserProfileSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single UserProfile model.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new UserProfile model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new UserProfile();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    // /**
    //  * Updates an existing UserProfile model.
    //  * If update is successful, the browser will be redirected to the 'view' page.
    //  * @param int $id ID
    //  * @return mixed
    //  * @throws NotFoundHttpException if the model cannot be found
    //  */
    // public function actionUpdate($id)
    // {
    //     $model = $this->findModel($id);

    //     if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
    //         return $this->redirect(['view', 'id' => $model->id]);
    //     }

    //     return $this->render('update', [
    //         'model' => $model,
    //     ]);
    // }

    /**
     * Updates an existing UserProfile model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing UserProfile model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionSignup()
    {
        $model = new SignupForm();
        $contacts = [new ContactDetail];

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {

                $contacts = Model::createMultiple(ContactDetail::class);
                Model::loadMultiple($contacts, Yii::$app->request->post());

                // ajax validation
                if (Yii::$app->request->isAjax) {
                    Yii::$app->response->format = Response::FORMAT_JSON;
                    return ArrayHelper::merge(
                        ActiveForm::validateMultiple($contacts),
                        ActiveForm::validate($model)
                    );
                }

                // validate all models
                $valid = $model->validate();
                $valid = Model::validateMultiple($contacts) && $valid;

                if ($valid) {
                    $transaction = Yii::$app->db->beginTransaction();
                    try {
                        if ($flag = $model->signup()) {
                            foreach ($contacts as $contact) {
                                $contact->user_profile_id = $model->_id;

                                if ($contact->isNewRecord && !($flag = $contact->save())) {
                                    $transaction->rollBack();
                                    break;
                                }
                            }
                        }

                        if ($flag) {
                            $transaction->commit();
                            return $this->redirect(['index']);
                        }
                    } catch (Exception $e) {
                        $transaction->rollBack();
                    }
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
            'contacts' => (empty($contacts)) ? [new ContactDetail] : $contacts,

        ]);
    }

    public function actionToggleStatus($id)
    {
        $this->findModel($id)->user->toggleStatus();
        //return $this->redirect(['index']);
        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * Finds the UserProfile model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return UserProfile the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = UserProfile::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionUserDetails()
    {
        if (isset($_POST['expandRowKey'])) {
            $model = UserProfile::findOne($_POST['expandRowKey']);
            return $this->renderPartial('_expand-row-details', ['model' => $model]);
        } else {
            return '<div class="alert alert-danger">No data found</div>';
        }
    }
}
