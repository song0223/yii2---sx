<?php
namespace frontend\controllers;

use common\models\Post;
use common\models\PostComment;
use common\services\UserService;
use frontend\modules\post\models\Topic;
use Yii;
use yii\data\ActiveDataProvider;
use common\components\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\ForbiddenHttpException;
use yii\web\Response;

/**
 * Hot controller
 */
class IndexController extends Controller
{

    public function beforeAction($action)
    {
        if (Yii::$app->user->isGuest) {
            Yii::$app->getResponse()->redirect(\Yii::$app->getUser()->loginUrl)->send();
        }
        return parent::beforeAction($action);
    }
    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
                'minLength' => 4,
                'maxLength' => 4
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $topics = new ActiveDataProvider([
            'query' => Post::find()
                ->where(['status' => 1])
                ->limit(10)
                ->orderBy(['updated_at'=>SORT_DESC])
        ]);
        return $this->render('index',[
            'topics' => $topics
        ]);
    }

    public function actionTopic(){
        $data = Yii::$app->request->queryParams;
        if($data){
            $topic = Topic::findOne($data['id']);
            $userService = new UserService();
            list($resutl,$model) = $userService->userAddAction($topic,$data['type'],$data['do']);
            if($resutl){
                return $this->message('操作成功', 'success');
            }else{
                return $this->message('操作失败'.$model->getErrors(), 'error');
            }
        }
    }


    public function actionComment(){
        $data = Yii::$app->request->queryParams;
        if($data) {
            $userService = new UserService();
            $postComment = PostComment::findOne($data['id']);
            list($resutl, $model) = $userService->userAddAction($postComment, $data['type'], $data['do']);
            if ($resutl) {
                return $this->message('操作成功', 'success');
            } else {
                return $this->message('操作失败' . $model->getErrors(), 'error');
            }
        }
    }
}
