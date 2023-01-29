<?php

namespace app\commands;

use app\models\Charts;
use fl\curl\Curl;
use fl\curl\Response;
use Yii;
use yii\console\Controller;
use yii\console\ExitCode;


class DataController extends Controller
{
    public function actionInitTestData()
    {
        $now = time();

        Yii::$app->db->createCommand()->insert('{{%country}}', [
            'id'          => 1,
            'iso2'        => 'US',
            'iso3'        => 'USA',
            'title'       => 'United States of America',
            'short_title' => 'USA',
            'created_at'  => $now,
            'updated_at'  => $now,
        ])->execute();


        Yii::$app->db->createCommand()->insert('{{%developer}}', [
            'id'          => 1,
            'title'       => 'Innersloth Limited liability Company',
            'short_title' => 'Innersloth LLC',
            'created_at'  => $now,
            'updated_at'  => $now,
        ])->execute();


        Yii::$app->db->createCommand()->insert('{{%application}}', [
            'id'            => 1421444,
            'googleplay_id' => 'com.innersloth.spacemafia',
            'appstore_id'   => 1351168404,
            'title'         => 'Among Us',
            'short_title'   => 'Among Us',
            'developer_id'  => 1,
            'created_at'    => $now,
            'updated_at'    => $now,
        ])->execute();
    }


    public function actionUpdateCharts($appId = 1421444, $countryId = 1)
    {
        $curl = new Curl();

        $path = "https://api.apptica.com/package/top_history/$appId/$countryId";

        $query = [
            'date_from' => date('Y-m-d', strtotime('-30days midnight')),
            'date_to'   => date('Y-m-d', strtotime('today midnight')),
            'B4NKGg'    => 'fVN5Q9KVOlOHDx9mOsKPAQsFBlEhBOwguLkNEDTZvKzJzT3l',
        ];

        /** @var Response $response */
        $response = $curl
            ->setQuery($query)
            ->get($path);

        $status_code = $response->data['status_code'] ?? null;

        if ($response->code !== 200 || $status_code !== 200) {
            echo "$response->url unavailable. HTTP code: $response->code. Status code: $status_code\n";

            return ExitCode::UNAVAILABLE;
        }

        $data = $response->data['data'];

        if (!$data) {
            echo "Charts data is empty\n";

            return ExitCode::OK;
        }

        // @TODO extract and optimize code
        foreach ($data as $rootCategoryId => $children) {

            foreach ($children as $categoryId => $dates) {

                foreach ($dates as $date => $position) {

                    /** @var Charts $item */
                    $item = Charts::find()
                        ->where([
                            'date'             => $date,
                            'country_id'       => $countryId,
                            'category_id'      => $categoryId,
                            'root_category_id' => $rootCategoryId,
                            'application_id'   => $appId,
                        ])
                        ->limit(1)
                        ->one()
                    ;

                    if(!$item) {
                        $item                   = new Charts();
                        $item->date             = $date;
                        $item->country_id       = $countryId;
                        $item->application_id   = $appId;
                        $item->category_id      = $categoryId;
                        $item->root_category_id = $rootCategoryId;
                        $item->position         = $position;

                        $item->save();
                    }
                }
            }
        }

        return ExitCode::OK;
    }
}
