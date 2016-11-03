<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * TopicSearch represents the model behind the search form of `backend\modules\post\models\Topic`.
 */
class PostSearch extends Post
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'last_comment_time', 'view_count', 'comment_count', 'favorite_count', 'like_count', 'thanks_count', 'hate_count', 'status', 'order', 'updated_at'], 'integer'],
            [['title','post_meta_id', 'author', 'excerpt', 'image', 'content', 'tags', 'last_comment_name','created_at' ,'type'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Post::find()->where('status > 0')->orderBy(['updated_at'=>SORT_DESC]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            //'post_meta_id' => $this->post_meta_id,
            'user_id' => $this->user_id,
            'last_comment_time' => $this->last_comment_time,
            'view_count' => $this->view_count,
            'comment_count' => $this->comment_count,
            'favorite_count' => $this->favorite_count,
            'like_count' => $this->like_count,
            'thanks_count' => $this->thanks_count,
            'hate_count' => $this->hate_count,
            'status' => $this->status,
            'order' => $this->order,
            //'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'type' =>'topic'
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'author', $this->author])
            ->andFilterWhere(['like', 'excerpt', $this->excerpt])
            ->andFilterWhere(['like', 'image', $this->image])
            ->andFilterWhere(['like', 'content', $this->content])
            ->andFilterWhere(['like', 'tags', $this->tags])
            ->andFilterWhere(['like', 'last_comment_name', $this->last_comment_name]);
        $query->andFilterWhere(['in', 'post_meta_id', $this->post_meta_id]);

        return $dataProvider;
    }
}
