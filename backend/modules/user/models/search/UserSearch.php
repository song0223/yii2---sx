<?php
namespace backend\modules\user\models\search;

use yii\data\ActiveDataProvider;
use common\models\User;
use yii\base\Model;
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/9/27
 * Time: 11:13
 */
class UserSearch extends User
{

    public function rules()
    {
        // 只有在 rules() 的字段才能被搜索
        return [
            [['id','status'], 'integer'],
            [['username', 'email','role','status','created_at'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass 父类实现的scenarios()
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = self::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['created_at' => SORT_DESC]],
            'pagination' => [
                //'pageSize' => 15,
            ],
        ]);

        // 加载搜索表单数据并验证
        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        if($this->created_at){
            $createdAt = explode('-', $this->created_at);
            $createdAtStart = strtotime($createdAt[0]);
            $createdAtEnd = strtotime($createdAt[1]);
            $query->andFilterWhere(['between' , 'created_at' , $createdAtStart , $createdAtEnd]);
        }

        // 通过添加过滤器来调整查询语句
        $query->andFilterWhere(['id' => $this->id]);
        $query->andFilterWhere(['status' => $this->status]);
        $query->andFilterWhere(['like', 'username', $this->username]);
        $query->andFilterWhere(['like', 'email', $this->email]);
        $query->andFilterWhere(['role' => $this->role]);

        //$query->andFilterWhere(['created_at' => $this->created_at]);

        return $dataProvider;
    }

}