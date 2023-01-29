<?php

namespace app\controllers;


use app\models\Application;
use app\models\Charts;
use app\models\Country;
use DateTime;
use yii\filters\ContentNegotiator;
use yii\rest\Controller;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class ChartsController extends Controller
{
    /** {@inheritdoc} */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['contentNegotiator'] = [
            'class' => ContentNegotiator::class,
            'formats' => [
                'application/json' => Response::FORMAT_JSON
            ],
        ];

        return $behaviors;
    }


    public function actionAppTopCategory($date, $appId = 1421444, $countryId = 1)
    {
        $app = Application::findOne($appId);

        if(!$app) {
            throw new NotFoundHttpException("Application with id $appId not found");
        }

        $country = Country::findOne($countryId);

        if(!$country) {
            throw new NotFoundHttpException("Country with id $countryId not found");
        }

        $dateTime = DateTime::createFromFormat('Y-m-d', $date);

        if(!$dateTime) {
            throw new BadRequestHttpException("Invalid param 'date' value: $date");
        }

        $dateTime->setTime(0, 0);

        $minDateTime = new DateTime('2010-01-01');
        $maxDateTime = new DateTime('midnight');

        if($dateTime < $minDateTime || $dateTime > $maxDateTime) {
            throw new BadRequestHttpException("Out of range param 'date' value: $date");
        }

        $data = Charts::find()
            ->select(['MIN(position) as best_position'])
            ->where([
                'date'           => $date,
                'application_id' => $appId,
                'country_id'     => $countryId,
            ])
            ->indexBy('root_category_id')
            ->groupBy(['root_category_id'])
            ->column()
        ;

        foreach ($data as $key => $value) {
            if($value !== null) {
                $data[$key] = (int) $value;
            }
        }

        return (object) $data;
    }
}
