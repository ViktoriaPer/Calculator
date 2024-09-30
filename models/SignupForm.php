<?php
namespace app\models;

use yii\base\Model;

class SignupForm extends Model
{
    public $username;
    public $password;
    public $email;
    public $password_repeat;

    public function rules()
    {
        return [
            [['username', 'password', 'email', 'password_repeat'], 'required', 'message' => 'Заполните поле'],
            ['username', 'match', 'pattern' => '/^[A-Za-zА-Яа-яЁё]+$/u', 'message' => 'Логин может содержать только буквы A-Z или А-я.'],
            ['email', 'email', 'message' => 'Некорректный формат электронной почты.'],
            ['email', 'unique', 'targetClass' => User::class, 'message' => 'Этот email уже зарегистрирован.'],
            ['username', 'unique', 'targetClass' => User::class, 'message' => 'Этот логин уже занят.'],
            ['password', 'string', 'min' => 8, 'message' => 'Пароль должен содержать минимум 8 символов.'],
            ['password', 'match', 'pattern' => '/^(?=.*[0-9])/', 'message' => 'Пароль должен содержать хотя бы одну цифру.'],
            ['password_repeat', 'compare', 'compareAttribute' => 'password', 'message' => 'Пароли не совпадают.'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'username' => 'Логин',
            'password' => 'Пароль',
            'email' => 'E-mail',
            'password_repeat' => 'Повторите пароль',
        ];
    }

    public function signup()
    {
        if ($this->validate()) {
            $user = new User();
            $user->username = $this->username;
            $user->email = $this->email;
            $user->password = \Yii::$app->security->generatePasswordHash($this->password);
            // Поле role будет автоматически установлено в 'user' в модели User

            return $user->save() ? $user : null;
        }
        return null;
    }
}
