<?php

namespace app\models;

   use Yii;
   use yii\db\ActiveRecord;
   use yii\web\IdentityInterface;

   class User extends ActiveRecord implements IdentityInterface
   {
       public static function tableName()
       {
           return 'user';
       }

    public function getRole()
        {
            return $this->role; 
        }

       public static function findIdentity($id)
       {
           return static::findOne($id);
       }

       public static function findIdentityByAccessToken($token, $type = null)
       {
           // мб пригодится
           return null;
       }

       public static function findByUsername($username)
       {
           return static::findOne(['username' => $username]);
       }

       public static function findByEmail($email)
       {
           return static::findOne(['email' => $email]);
       }
       public function getId()
       {
           return $this->id; // Предполагается, что у вас есть поле `id` в таблице `user`
       }

       public function getAuthKey()
       {
           // вдруг нужно??
           return null;
       }

       public function validateAuthKey($authKey)
       {
           // нужно ли??
           return false;
       }

       public function rules()
       {
           return [
               [['username', 'email', 'password'], 'required'],
               [['username', 'email', 'password'], 'string', 'max' => 255],
               [['email'], 'email'],
               [['email'], 'unique'],
               [['username'], 'unique'],
           ];
       }

       public function beforeSave($insert)
       {
           if (parent::beforeSave($insert)) {
               if ($this->isNewRecord) {
                   $this->role = 'user';
               }
               return true;
           }
           return false;
       }
   }