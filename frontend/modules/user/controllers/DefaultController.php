<?php

namespace frontend\modules\user\controllers;

use common\models\PostComment;
use common\models\User;
use common\components\Controller;
use common\models\UserInfo;
use common\models\UserMeta;
use frontend\modules\post\models\Topic;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;

/**
 * Default controller for the `user` module
 */
class DefaultController extends Controller
{

    /**
     * 最新评论
     * @param $username
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionIndex($username = '')
    {
        $model = $this->user($username);
        if($this->_user_id != $model->id){
            UserInfo::updateAllCounters(['view_count' => 1] , ['user_id' => $model->id]);
        }
        $dataProvider = new ActiveDataProvider([
            'query' => PostComment::find()
                ->where(['user_id'=>$model->id,'status' => 1])
                ->orderBy(['created_at'=>SORT_DESC])
        ]);
        return $this->render('index',[
            'model' => $model,
            'dataProvider' => $dataProvider
        ]);
    }

    /**
     * 最新帖子
     * @param string $username
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionPost($username = ''){
        $model = $this->user($username);
        $dataProvider = new ActiveDataProvider([
            'query' => Topic::find()
                ->where(['user_id' => $model->id, 'type' => Topic::TYPE])
                ->andWhere('status > :status ',[':status' => Topic::STATUS_DELETED])
                ->orderBy(['created_at'=>SORT_DESC])
        ]);
        return $this->render('index',[
            'model' => $model,
            'dataProvider' => $dataProvider
        ]);
    }

    /**
     * 最新收藏
     * @param string $username
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionFavorite($username = ''){
        $model = $this->user($username);
        $dataProvider = new ActiveDataProvider([
            'query' => UserMeta::find()
                ->where(['user_id' => $model->id, 'type' => 'favorite', 'target_type' => Topic::TYPE])
                ->orderBy(['created_at'=>SORT_DESC])
        ]);
        return $this->render('index',[
            'model' => $model,
            'dataProvider' => $dataProvider
        ]);
    }

    public function user($username){
        $user = User::findOne(['username' => $username]);
        if(!$user){
            throw new NotFoundHttpException('没有该用户');
        }
        return $user;
    }
}
