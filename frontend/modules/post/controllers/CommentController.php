<?php

namespace frontend\modules\post\controllers;

use common\models\User;
use common\widgets\MessagePrompt;
use frontend\modules\post\models\Topic;
use Yii;
use common\models\PostComment;
use yii\data\ActiveDataProvider;
use common\components\Controller;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CommentController implements the CRUD actions for postComment model.
 */
class CommentController extends Controller
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
     * Lists all postComment models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => postComment::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single postComment model.
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
     * @param $id
     * @return string|\yii\web\Response
     * @throws ForbiddenHttpException
     */
    public function actionCreate($id)
    {
        $model = new postComment();
        if (!$model->isOneself() && !User::isSuperAdmin()){
            throw new ForbiddenHttpException('你没有权限执行此操作！');
        }
        if ($model->load(Yii::$app->request->post())) {
            $model->user_id = Yii::$app->user->id;
            $model->post_id = $id;
            $model->ip = Yii::$app->request->getUserIP();
            if((new Topic())->finalReplyUpdate($id,$this->_user_name)&&$model->save()){
                MessagePrompt::setSucMsg('回复成功！');
                return $this->redirect(['/post/default/view', 'id' => $id]);
            }else{
                MessagePrompt::setErrorMsg($model->getErrors());
            }
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
        if ($model->load(Yii::$app->request->post())) {
            if($model->save()){
                $topic = new Topic();
                $topic->finalReplyUpdate($model->post_id,$this->_user_name);
                MessagePrompt::setSucMsg('修改成功！');
                return $this->redirect(['/post/default/view', 'id' => $model->post_id]);
            }
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
        if($model::updateAll(['status'=>0],['id'=>$id])){
            MessagePrompt::setSucMsg('删除成功！');
        }
        return $this->redirect(['/post/default/view', 'id' => $model->post_id]);
    }

    /**
     * Finds the postComment model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return postComment the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = postComment::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
