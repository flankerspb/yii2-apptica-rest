<?php

namespace app\models;

use BadMethodCallException;
use Yii;
use yii\db\ActiveRecord;
use yii\web\Request;
use yii\web\Response;

/**
 * This is the model class for table "access_log".
 *
 * @property int         $id
 * @property float       $request_time
 * @property string      $user_ip
 * @property string      $user_agent
 * @property string      $request_method
 * @property string      $request_url
 * @property string|null $request_body
 * @property int         $status_code
 */
class AccessLog extends ActiveRecord
{
    /** {@inheritdoc} */
    public static function tableName()
    {
        return 'access_log';
    }


    /** {@inheritdoc} */
    public function rules()
    {
        return [
            [['request_time'], 'number'],
            [['user_ip', 'user_agent', 'request_method', 'request_url', 'status_code'], 'required'],
            [['status_code'], 'integer'],
            [['user_ip'], 'string', 'max' => 39],
            [['user_agent', 'request_url', 'request_body'], 'string', 'max' => 255],
            [['request_method'], 'string', 'max' => 7],
        ];
    }


    /** {@inheritdoc} */
    public function attributeLabels()
    {
        return [
            'id'             => 'ID',
            'request_time'   => 'Request Time',
            'user_ip'        => 'User Ip',
            'user_agent'     => 'User Agent',
            'request_method' => 'Request Method',
            'request_url'    => 'Request Url',
            'request_body'   => 'Request Body',
            'status_code'    => 'Status Code',
        ];
    }


    /**
     * @return static
     */
    public static function create()
    {
        if (!(Yii::$app instanceof \yii\web\Application)) {
            throw new BadMethodCallException();
        }

        /**
         * @var Request  $request
         * @var Response $response
         */
        $request  = Yii::$app->request;
        $response = Yii::$app->response;

        $log = new static();

        $log->request_time   = $_SERVER['REQUEST_TIME_FLOAT'];
        $log->user_ip        = $request->userIP;
        $log->user_agent     = $request->userAgent;
        $log->request_method = $request->method;
        $log->request_url    = $request->url;
        $log->request_body   = $request->bodyParams ? json_encode($request->bodyParams) : null;
        $log->status_code    = $response->statusCode;

        return $log;
    }
}
