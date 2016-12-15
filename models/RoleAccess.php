<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "role_access".
 *
 * @property integer $id
 * @property integer $role_id
 * @property integer $access_id
 * @property string $created_time
 */
class RoleAccess extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'role_access';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['role_id', 'access_id'], 'integer'],
            [['created_time'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'role_id' => 'Role ID',
            'access_id' => 'Access ID',
            'created_time' => 'Created Time',
        ];
    }
}
