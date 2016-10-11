<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/10/11
 * Time: 16:28
 */

namespace backend\models;


class TimeSectionSearch
{
        /**
         * @param $query
         * @param $attribute
         * @param $time
         * @return mixed
         */
        public static function andTimeSection($query, $attribute, $time){
            if(!empty($time)){
                $createdAt = explode('-', $time);
                $createdAtStart = strtotime($createdAt[0]);
                $createdAtEnd = strtotime($createdAt[1]);
                $query->andFilterWhere(['between' , $attribute , $createdAtStart , $createdAtEnd]);
                return $query;
            }
        }
}