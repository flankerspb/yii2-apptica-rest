<?php

namespace app\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * @property int    $id
 * @property string $title
 * @property string $short_title
 *
 * @property int    $created_at
 * @property int    $updated_at
 *
 * @property Application[] $applications
 */
class Developer extends ActiveRecord
{
    /** {@inheritdoc} */
    public static function tableName()
    {
        return 'developer';
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
            [['title', 'short_title'], 'required'],
            [['title', 'short_title'], 'string', 'max' => 255],
        ];
    }


    /** {@inheritdoc} */
    public function attributeLabels()
    {
        return [
            'id'          => 'ID',
            'title'       => 'Title',
            'short_title' => 'Short Title',
            'created_at'  => 'Created At',
            'updated_at'  => 'Updated At',
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getApplications()
    {
        return $this->hasMany(Application::class, ['developer_id' => 'id']);
    }
}
