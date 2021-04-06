<?php

namespace api\controllers;

use common\models\News;
use yii\data\ActiveDataProvider;
use yii\rest\ActiveController;

/**
 * Class NewsController
 * @package api\controllers
 */
class NewsController extends ActiveController
{
    /**
     * @var string $modelClass
     */
    public $modelClass = News::class;

    /**
     * @return array
     */
    public function actions(): array
    {
        $actions = parent::actions();
        unset($actions['create'], $actions['update'], $actions['options']);
        $actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];
        return $actions;
    }

    /**
     * @return ActiveDataProvider
     */
    public function prepareDataProvider(): ActiveDataProvider
    {
        $count = \Yii::$app->request->get('limit');
        $offset = \Yii::$app->request->get('offset');

        $query = News::find();
        if ($count) {
            $query->limit = $count;
        }

        if ($offset) {
            $query->offset = $offset;
        }

        return new ActiveDataProvider([
            'query' => $query,
            'pagination' => false,
        ]);
    }
}
