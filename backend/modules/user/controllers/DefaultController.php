<?php

namespace backend\modules\user\controllers;

use common\widgets\MessagePrompt;
use Yii;
use common\models\User;
use yii\base\Object;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\modules\user\models\search\UserSearch;

/**
 * DefaultController implements the CRUD actions for User model.
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
                    'ban' => ['POST'],
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
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel
        ]);
    }

    /**
     * Displays a single User model.
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
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new User();

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
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

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
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        MessagePrompt::setSucMsg(Yii::t('app','Successful operation！'));
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
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }


    /**
     * @param $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionAssignMent($id){
        $model = $this->findModel($id);
        $authManager = Yii::$app->authManager;
        if($model->load(Yii::$app->request->post())){
            $role = (object) '';
            $role->name = '';
            $authManager->revokeAll($id); //清空角色 重新写入
            foreach($model->role as $role->name){
                $authManager->assign($role, $id);
            }
            MessagePrompt::setSucMsg(Yii::t('app','Successful operation！'));
            return $this->redirect(['assign-ment', 'id' => $model->id]);
        }else{
            $roles = $authManager->getRoles(); //所有角色
            $rolesByUser = $authManager->getRolesByUser($id); //当前用户角色
            return $this->render('assign',[
                'model' => $model,
                'roles' => $roles,
                'rolesByUser' => $rolesByUser
            ]);
        }
    }

    /**
     * 封禁用户
     * @param $id
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionBan($id){
        if(Yii::$app->user->id != $id){
            $model = $this->findModel($id);
            $model->status = User::STATUS_DELETED;
            $model->save();
            MessagePrompt::setSucMsg(Yii::t('app','Successful operation！'));
        }else{
            MessagePrompt::setErrorMsg(Yii::t('app','operation failed！'));
        }
        return $this->redirect(['update','id'=>$id]);
    }



    public function actionLiftBan($id){
        $model = $this->findModel($id);
        $model->status = User::STATUS_ACTIVE;
        $model->save();
        MessagePrompt::setSucMsg(Yii::t('app','Successful operation！'));

        return $this->redirect(['update','id'=>$id]);
    }
}
