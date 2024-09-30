<?php
namespace app\models;

use Yii;
use yii\base\Model;

class LoginForm extends Model
{
    public $username;
    public $password;

    public function rules()
    {
        return [
            [['username', 'password'], 'required', 'message' => 'Заполните поле'],
            ['password', 'validatePassword'],
        ];
    }

    public function validatePassword($attribute, $params)
    {
        $user = User::findByUsername($this->username); // Найти пользователя по имени

        if (!$user || !Yii::$app->security->validatePassword($this->password, $user->password)) {
            $this->addError($attribute, 'Неправильный логин или пароль.');
        }
    }

    public function login()
    {
        if ($this->validate()) { // Проверка валидности данных формы
            $user = User::findByUsername($this->username);
            if ($user && Yii::$app->security->validatePassword($this->password, $user->password)) {
                return Yii::$app->user->login($user); // Вход пользователя
            } else {
                $this->addError('password', 'Неверный логин или пароль.'); // Добавление ошибки
            }
        }
        return false;
        
    }
}