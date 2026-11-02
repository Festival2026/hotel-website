<?php
// app/models/validators/results_verification.php

require_once 'app/models/validators/custom_form_validation.php';

class ResultsVerification extends CustomFormValidation
{
    protected $correctAnswers = [
        'question1' => 'предел',
        'question2' => [
            'Метод подстановки',
            'Метод интегрирования по частям'
        ],
        'question3' => 'Метод Рунге-Кутты'
    ];

    public $results = [];
    public $score = 0;
    public $maxScore = 3;

    public function __construct()
    {
        parent::__construct();
        // Дополнительные правила для теста
        $this->SetRule('question1', 'isNotEmpty');
        $this->SetRule('question3', 'isNotEmpty');
    }

    /**
     * Переопределяем Validate, чтобы добавить проверку правильности ответов.
     */
    public function Validate($post_array)
    {
        parent::Validate($post_array);

        $this->checkQuestion1($post_array);
        $this->checkQuestion2($post_array);
        $this->checkQuestion3($post_array);
    }

    protected function checkQuestion1($data)
    {
        if (!isset($data['question1']) || trim($data['question1']) === '') {
            $this->results['question1'] = false;
            return;
        }
        $answer = mb_strtolower(trim($data['question1']), 'UTF-8');
        $isCorrect = mb_strpos($answer, 'предел') !== false;
        $this->results['question1'] = $isCorrect;
        if ($isCorrect) $this->score++;
    }

    protected function checkQuestion2($data)
    {
        if (!isset($data['question2'])) {
            $this->results['question2'] = false;
            return;
        }
        $userAnswers = is_array($data['question2']) ? $data['question2'] : [$data['question2']];
        $correct = $this->correctAnswers['question2'];
        sort($userAnswers);
        sort($correct);
        $isCorrect = ($userAnswers === $correct);
        $this->results['question2'] = $isCorrect;
        if ($isCorrect) $this->score++;
    }

    protected function checkQuestion3($data)
    {
        if (!isset($data['question3']) || trim($data['question3']) === '') {
            $this->results['question3'] = false;
            return;
        }
        $isCorrect = ($data['question3'] === $this->correctAnswers['question3']);
        $this->results['question3'] = $isCorrect;
        if ($isCorrect) $this->score++;
    }
}