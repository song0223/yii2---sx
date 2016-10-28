<?php

namespace frontend\modules\post\controllers;

use common\models\PostComment;
use common\models\PostMeta;
use common\models\PostSearch;
use common\models\PostTag;
use frontend\modules\post\models\Topic;
use Yii;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use common\components\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DefaultController implements the CRUD actions for Post model.
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
     * Lists all Post models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PostSearch();
        $params = Yii::$app->request->queryParams;
        empty($params['tag']) ?: $params['PostSearch']['tags'] = $params['tag'];
        if (isset($params['node'])) {
            $postMeta = PostMeta::findOne(['alias' => $params['node']]);
            ($postMeta) ? $params['PostSearch']['post_meta_id'] = $postMeta->id : '';
        }
        if(isset($params['meta_id'])){
            $mid = PostMeta::find()->select('id')->where(['parent'=>$params['meta_id']])->asArray()->all();
            if(!empty($mid)){
                $params['PostSearch']['post_meta_id'] = ArrayHelper::map($mid,'id','id');
            }else{
                $params['PostSearch']['post_meta_id'] = $params['meta_id'];
            }
        }
        $dataProvider = $searchModel->search($params);

        $params1 = Yii::$app->request->queryParams;
        foreach($params1 as $k=>$v){
            $params1['tag'] = $v;
            if($k == 'meta_id'){
                $params1['tag'] = PostMeta::getNameByid($v);
            }
        }
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'tag' => $params1
        ]);
    }

    /**
     * 帖子详情页
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);

        //文章浏览数+1
        $model->updateAllCounters(['view_count' => 1] , ['id' => $id]);

        //帖子回复
        $dataProvider = new ArrayDataProvider([
            'allModels' => PostComment::getCommentByPid($model->id),
        ]);
        return $this->render('view', [
            'model' => $model,
            'dataProvider' => $dataProvider,
            'comment' => new PostComment()
        ]);
    }

    /**
     * Creates a new Post model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Topic();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Post model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->tags = explode(',',$model->tags);
        if ($model->load(Yii::$app->request->post()) && $model->save() ) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Post model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Post model based on its primary key value.
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
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionGetTags(){
       if(Yii::$app->request->isAjax){
            $meta = Yii::$app->request->get('meta');
            return PostTag::getTagsByMeta($meta, null);
        }
    }

    /**
     * @param $q
     * @param $meta
     * @return array
     */
    public function actionTags($q, $meta){
        return PostTag::getAjaxTags($meta);
    }
}
