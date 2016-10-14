<?php

namespace backend\modules\post\controllers;

use common\models\PostTag;
use common\widgets\MessagePrompt;
use Yii;
use backend\modules\post\models\Topic;
use backend\modules\post\models\search\TopicSearch;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * DefaultController implements the CRUD actions for Topic model.
 */
class DefaultController extends Controller
{
    /**
     * @inheritdoc
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
     * Lists all Topic models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TopicSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Topic model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Topic model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Topic();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            MessagePrompt::setSucMsg(Yii::t('app','Successful operation！'));
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Topic model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->tags = explode(',',$model->tags);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            MessagePrompt::setSucMsg(Yii::t('app','Successful operation！'));
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Topic model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        if($model->updateAll(['status'=>Topic::STATUS_DELETED], ['id'=> $id])){
            MessagePrompt::setSucMsg(Yii::t('app','Successful operation！'));
            return $this->redirect(['index']);
        }
    }

    /**
     * Finds the Topic model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Topic the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Topic::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('文章不存在!');
        }
    }


    public function actionTags($q, $meta){
        return PostTag::getAjaxTags($meta);
    }

    /**
     * 回收站
     * @return string
     */
    public function actionRecycle(){
        $query = Topic::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $query->andWhere(['status'=>Topic::STATUS_DELETED]);

        return $this->render('recycle',[
            'dataProvider' => $dataProvider
        ]);
    }

    /**
     * 还原文章
     * @return Response
     * @throws NotFoundHttpException
     */
    public function actionRecovery(){
        Yii::$app->response->format = Response::FORMAT_JSON;
        $id = Yii::$app->request->post('id');

        $model = $this->findModel($id);
        if($model->updateAll(['status'=>Topic::STATUS_ACTIVE], ['id'=> $id])){
            MessagePrompt::setSucMsg(Yii::t('app','Successful operation！'));
            return $this->redirect(['recycle']);
        }
    }

    public function actionClear($id){
        $this->findModel($id)->delete();
        MessagePrompt::setSucMsg(Yii::t('app','Successful operation！'));
        return $this->redirect(['recycle']);
    }
}
