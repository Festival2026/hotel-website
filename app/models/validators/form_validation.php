<?php
// app/models/validators/form_validation.php

class FormValidation
{
    /**
     * Набор правил валидации.
     * Структура: ['field_name' => ['validator1', 'validator2', ...], ...]
     * Для одного поля можно задать несколько правил — они выполняются по порядку.
     */
    public $Rules = [];

    /**
     * Массив ошибок: ['field_name' => 'текст ошибки']
     * Для каждого поля храним только первую возникшую ошибку.
     */
    public $Errors = [];

    /**
     * Данные формы.
     */
    protected $data = [];

    /**
     * Добавляет правило валидации для поля.
     * Может вызываться несколько раз для одного поля — правила накапливаются.
     */
    public function SetRule($field_name, $validator_name)
    {
        if (!isset($this->Rules[$field_name])) {
            $this->Rules[$field_name] = [];
        }
        $this->Rules[$field_name][] = $validator_name;
    }

    /**
     * Основной метод валидации.
     * Применяет правила из $Rules к данным $post_array.
     */
    public function Validate($post_array)
    {
        $this->data = $post_array;
        $this->Errors = [];

        foreach ($this->Rules as $field_name => $validators) {
            // Если поля вообще нет в POST — пропускаем все проверки для него.
            // Это нужно, чтобы правила, заданные для формы «Контакт»,
            // не применялись к форме «Тест» (и наоборот).
            if (!array_key_exists($field_name, $post_array)) {
                continue;
            }

            $value = $post_array[$field_name];

            foreach ($validators as $validator_name) {
                // Поддержка доп. параметра: 'isLess:10', 'isGreater:100'
                $extra = null;
                $pureName = $validator_name;
                if (strpos($pureName, ':') !== false) {
                    list($pureName, $extra) = explode(':', $pureName, 2);
                }

                if (!method_exists($this, $pureName)) {
                    continue;
                }

                $result = $extra === null
                    ? $this->$pureName($value)
                    : $this->$pureName($value, $extra);

                // Если метод вернул строку — это сообщение об ошибке.
                // Сохраняем только первую ошибку для поля.
                if ($result !== true && $result !== null) {
                    if (!isset($this->Errors[$field_name])) {
                        $this->Errors[$field_name] = $result;
                    }
                }
            }
        }
    }

    /**
     * Проверка: значение не пустое.
     */
    public function isNotEmpty($data)
    {
        if (!is_string($data) || trim($data) === '') {
            return "Поле обязательно для заполнения.";
        }
        return true;
    }

    /**
     * Проверка: значение — целое число.
     */
    public function isInteger($data)
    {
        if (!preg_match('/^-?\d+$/', (string)$data)) {
            return "Значение должно быть целым числом.";
        }
        return true;
    }

    /**
     * Проверка: целое число, не меньше чем $value.
     */
    public function isLess($data, $value)
    {
        $check = $this->isInteger($data);
        if ($check !== true) return $check;
        if ((int)$data < (int)$value) {
            return "Значение должно быть не меньше, чем {$value}.";
        }
        return true;
    }

    /**
     * Проверка: целое число, не больше чем $value.
     */
    public function isGreater($data, $value)
    {
        $check = $this->isInteger($data);
        if ($check !== true) return $check;
        if ((int)$data > (int)$value) {
            return "Значение должно быть не больше, чем {$value}.";
        }
        return true;
    }

    /**
     * Проверка: корректный email.
     */
    public function isEmail($data)
    {
        if (!filter_var(trim((string)$data), FILTER_VALIDATE_EMAIL)) {
            return "Введите корректный e-mail (пример: user@mail.ru).";
        }
        return true;
    }

    /**
     * Выводит все ошибки в формате HTML.
     */
    public function ShowErrors()
    {
        if (empty($this->Errors)) return '';
        $html = '<div class="errors-block"><strong>Обнаружены ошибки:</strong><ul>';
        foreach ($this->Errors as $error) {
            $html .= '<li>' . htmlspecialchars($error) . '</li>';
        }
        $html .= '</ul></div>';
        return $html;
    }

    /**
     * Есть ли ошибки?
     */
    public function hasErrors()
    {
        return count($this->Errors) > 0;
    }
}