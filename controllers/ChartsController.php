<?php

namespace app\controllers;


use andreyv\ratelimiter\IpRateLimiter;
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
        $behaviors['rateLimiter'] = [
            // Use class
            'class' => IpRateLimiter::class,

            // The maximum number of allowed requests
            'rateLimit' => 5,

            // The time period for the rates to apply to
            'timePeriod' => 60,

            // Separate rate limiting for guests and authenticated users
            // Defaults to false
            // - false: use one set of rates, whether you are authenticated or not
            // - true: use separate ratesfor guests and authenticated users
            'separateRates' => false,

            // Whether to return HTTP headers containing the current rate limiting information
            'enableRateLimitHeaders' => false,

            // Array of actions on which to apply ratelimiter, if empty - applies to all actions
            // 'actions' => ['index'],

            // Allows to skip rate limiting for test environment
            'testMode' => false,
            // Defines whether proxy enabled, list of headers getting from request ipHeaders. By default ['X-Forwarded-For']
            'proxyEnabled' => false
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
