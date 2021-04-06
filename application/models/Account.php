<?php

namespace application\models;

use application\core\Model;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\EqualTo;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotCompromisedPassword;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\Type;
use Symfony\Component\Validator\Validation;

class Account extends Model {
    
    public function validateRegisterForm($post) {
        $validator = Validation::createValidator();
        $this->error = [];

        $this->error[] = (string)$validator->validate($post['login'], [
            new NotBlank(['message' => 'Поле логин обязательно']),
            new Length([
                'min' => 2, 
                'max' => 50,
                'minMessage' => 'Минимальная длина имени 2 символов',
                'maxMessage' => 'Максимальная длина имени 50 символов'
                ]),
            new Regex([
                'pattern' => '/[^А-Яа-я -]+/u',
                'match' => false,  
                'message' => 'В имени допустимы только русские буквы, пробелы и дефисы'
            ])
        ]);

        $this->error[] = (string)$validator->validate($post['email'], [
            new NotBlank(['message' => 'Поле email обязательно']),
            new Email(['message' => 'Введен некорректный email']),
        ]);

        if ($this->isEmailExist($post['email'])) {
            $this->error[] =$post['email'].': '.'Пользователь с таким email уже существует';
        }

        $this->error[] = (string)$validator->validate($post['password'], [
            new NotBlank(['message' => 'Поле пароль обязательно']),
            new Length([
                'min' => 6,
                'minMessage' => 'Минимальная длина пароля 6 символов'
            ]),
            //new NotCompromisedPassword(['message' => 'Данный пароль является скомпроментированным']),
            new Regex([
                'pattern' => '/[А-Яа-яa-zA-Z]+/u',  
                'message' => 'Пароль не может содержать только цифры'
            ])
        ]);

        $this->error[] = (string)$validator->validate($post['passwordConf'], [
            new NotBlank(['message' => 'Поле подтверждение пароля обязательно']),
            new EqualTo([
                'value' => $post['password'],
                'message' => 'Пароли не совпадают'
            ])
        ]);

        if (!isset($post['accept'])) {
            $this->error[] = 'Для регистрации необходимо согласиться на обработку персональных данных';
        }

        $this->error = array_filter($this->error);

        return empty($this->error);
    } 

    public function validateLoginForm($post) {
        $this->error = "";
        if (!isset($post['email']) || !isset($post['password'])) {
            $this->error = "Поля логина и пароля являются обязптельными";
        }
        return empty($this->error);
    }

    public function isEmailExist($email) {
        $params = [
            'email' => $email,
        ];
        return !empty($this->db->column('select acc_id from account where acc_email = :email', $params));
    }

    public function register($post) {
        $params = [
            'login' => $post['login'],
            'email' => $post['email'],
            'password' => password_hash($post['password'], PASSWORD_BCRYPT),
        ];
        $this->db->query('insert into account (acc_name, acc_email, acc_password) values (:login, :email, :password)', $params);
    }

    public function login($post) {
        $this->error = "";
        $params = [
            'email' => $post['email'],
        ];
        $user_info = $this->db->row('select * from account where acc_email = :email', $params);
        if (!empty($user_info) && password_verify($post['password'], $user_info[0]['acc_password'])) {
            $_SESSION['auth'] = $user_info[0];
        } 
        else {
            $this->error = "Пользователь с таким логином/паролем не найден";
        }
        return empty($this->error);
    }

    public function logout() {
        unset($_SESSION['auth'], $_SESSION['login'], $_SESSION['id']);
    }
}