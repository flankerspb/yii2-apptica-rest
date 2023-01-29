<?php

namespace app\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * @property int         $id
 * @property string|null $date
 * @property int         $position
 * @property int         $country_id
 * @property int         $application_id
 * @property int         $category_id
 * @property int         $root_category_id
 *
 * @property-read Application $application
 * @property-read Country     $country
 */
class Charts extends ActiveRecord
{
    /** {@inheritdoc} */
    public static function tableName()
    {
        return 'charts';
    }


    /** {@inheritdoc} */
    public function rules()
    {
        return [
            [['date'], 'safe'],
            [['country_id', 'category_id', 'root_category_id', 'application_id'], 'required'],
            [['position', 'country_id', 'category_id', 'root_category_id', 'application_id'], 'integer'],
            [['application_id'], 'exist', 'skipOnError' => true, 'targetClass' => Application::class, 'targetAttribute' => ['application_id' => 'id']],
            [['country_id'], 'exist', 'skipOnError' => true, 'targetClass' => Country::class, 'targetAttribute' => ['country_id' => 'id']],
        ];
    }


    /** {@inheritdoc} */
    public function attributeLabels()
    {
        return [
            'id'               => 'ID',
            'date'             => 'Date',
            'position'         => 'Position',
            'country_id'       => 'Country ID',
            'category_id'      => 'Category ID',
            'root_category_id' => 'Root Category ID',
            'application_id'   => 'Application ID',
        ];
    }


    /**
     * @return ActiveQuery
     */
    public function getApplication()
    {
        return $this->hasOne(Application::class, ['id' => 'application_id']);
    }


    /**
     * @return ActiveQuery
     */
    public function getCountry()
    {
        return $this->hasOne(Country::class, ['id' => 'country_id']);
    }
}
