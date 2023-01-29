<?php

namespace app\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * @property int    $id
 * @property string $iso2
 * @property string $iso3
 * @property string $title
 * @property string $short_title
 *
 * @property int    $created_at
 * @property int    $updated_at
 */
class Country extends ActiveRecord
{
    /** {@inheritdoc} */
    public static function tableName()
    {
        return 'country';
    }


    /** {@inheritdoc} */
    public function behaviors() : array
    {
        return [
            TimestampBehavior::class,
        ];
    }


    /** {@inheritdoc} */
    public function rules()
    {
        return [
            [['iso2', 'iso3', 'title', 'short_title'], 'required'],
            [['iso2'], 'string', 'max' => 2],
            [['iso3'], 'string', 'max' => 3],
            [['title', 'short_title'], 'string', 'max' => 255],
        ];
    }


    /** {@inheritdoc} */
    public function attributeLabels()
    {
        return [
            'id'          => 'ID',
            'iso2'        => 'Iso2',
            'iso3'        => 'Iso3',
            'title'       => 'Title',
            'short_title' => 'Short Title',
            'created_at'  => 'Created At',
            'updated_at'  => 'Updated At',
        ];
    }
}
