<?php
// app/models/validators/custom_form_validation.php

require_once 'app/models/validators/form_validation.php';

class CustomFormValidation extends FormValidation
{
    /**
     * Конструктор: задаём набор правил для формы.
     */
    public function __construct()
    {
        // Правила для формы «Контакт» / «Тест»
        $this->SetRule('name',     'isNotEmpty');
        $this->SetRule('name',     'isValidFIO');   // наш кастомный метод
        $this->SetRule('email',    'isEmail');
        $this->SetRule('phone',    'isValidPhone'); // наш кастомный метод
        $this->SetRule('gender',   'isNotEmpty');
        $this->SetRule('message',  'isNotEmpty');
    }

    /**
     * Расширенная проверка ФИО.
     */
    public function isValidFIO($data)
    {
        if (!preg_match('/^[А-ЯЁ][а-яё]+ [А-ЯЁ][а-яё]+ [А-ЯЁ][а-яё]+$/u', trim($data))) {
            return "Введите ФИО в формате: Фамилия Имя Отчество (с заглавной буквы).";
        }
        return true;
    }

    /**
     * Расширенная проверка телефона.
     */
    public function isValidPhone($data)
    {
        if (!preg_match('/^\+?[0-9\s\-]{7,15}$/', trim($data))) {
            return "Введите корректный телефон (пример: +7 978 123-45-67).";
        }
        return true;
    }
}