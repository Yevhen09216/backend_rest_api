<?php

namespace frontend\controllers;

use Yii;
use common\models\Client;
use frontend\models\search\UserSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UsersController implements the CRUD actions for User model.
 */
class UsersController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {   
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
     * @param integer $id
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
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Client();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {   
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        \Yii::$app
            ->db
            ->createCommand()
            ->delete('images', ['user_id' => $id])
            ->execute();

        \Yii::$app
            ->db
            ->createCommand()
            ->delete('chat', ['user_id' => $id])
            ->execute();

        \Yii::$app
            ->db
            ->createCommand()
            ->delete('friend', ['user_source_id' => $id])
            ->execute();

        \Yii::$app
            ->db
            ->createCommand()
            ->delete('friend', ['user_target_id' => $id])
            ->execute();

        \Yii::$app
            ->db
            ->createCommand()
            ->delete('like', ['user_source_id' => $id])
            ->execute();

        \Yii::$app
            ->db
            ->createCommand()
            ->delete('like', ['user_target_id' => $id])
            ->execute();

        \Yii::$app
            ->db
            ->createCommand()
            ->delete('message', ['user_id' => $id])
            ->execute();

        \Yii::$app
            ->db
            ->createCommand()
            ->delete('party', ['user_id' => $id])
            ->execute();

        \Yii::$app
            ->db
            ->createCommand()
            ->delete('stream', ['user_id' => $id])
            ->execute();

        \Yii::$app
            ->db
            ->createCommand()
            ->delete('stream_user', ['user_id' => $id])
            ->execute();


        return $this->redirect(['index']);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Client::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
