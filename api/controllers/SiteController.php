<?php
namespace api\controllers;

use yii\rest\Controller;
/**
 * Site controller
 */
class SiteController extends Controller
{
    public function actionIndex(): array
    {
        return [
            'This is a test service'
        ];
    }
}
