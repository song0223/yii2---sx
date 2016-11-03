<?php

namespace frontend\modules\post\controllers;

use common\models\PostComment;
use common\models\PostMeta;
use common\models\PostSearch;
use common\models\PostTag;
use common\models\User;
use common\models\UserInfo;
use common\widgets\MessagePrompt;
use frontend\modules\post\models\Topic;
use Yii;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use common\components\Controller;
use yii\web\ForbiddenHttpException;
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
            'access' => [
                'class' => AccessControl::className(),//过滤器
                'only' => ['create','delete','update'],
                'rules' => [
                    [
                        'actions' => ['create','delete','update'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
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
            UserInfo::updateAllCounters(['view_count' => 1],['user_id' => $this->_user_id]);
            MessagePrompt::setSucMsg('发布成功！');
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * @param $id
     * @return string|\yii\web\Response
     * @throws ForbiddenHttpException
     * @throws NotFoundHttpException
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if (!$model->isOneself() && !User::isSuperAdmin()){
            throw new ForbiddenHttpException('你没有权限执行此操作！');
        }
        $model->tags = explode(',',$model->tags);
        if ($model->load(Yii::$app->request->post()) && $model->save() ) {
            MessagePrompt::setSucMsg('修改成功！');
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * @param $id
     * @return \yii\web\Response
     * @throws ForbiddenHttpException
     * @throws NotFoundHttpException
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        if (!$model->isOneself() && !User::isSuperAdmin()){
            throw new ForbiddenHttpException('你没有权限执行此操作！');
        }
        if($model->updateAll(['status'=>Topic::STATUS_DELETED], ['id'=> $id])){
            MessagePrompt::setSucMsg('删除成功！');
            return $this->redirect(['index']);
        }
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
