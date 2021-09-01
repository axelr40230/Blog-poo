<?php

namespace App;

class Validator
{
    protected $data = [];
    protected $rules = [];
    protected $errors = [];
    protected $errorToken = [];
    protected $token;
    protected $method = [];

    public function __construct()
    {

    }

    public function validate(array $data = [], array $rules = [])
    {
        // ['first_name' => 'Alexandra', 'last_name' => 'Smith']
        $this->data = $data;
        $this->rules = $rules;

        foreach ($this->rules as $key => $rules) {
            $this->checkCsrf();
            $this->checkInput($key, $rules);
        }
    }

    public function fails(): bool
    {
        if (count($this->errors) > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function error(string $key): ?string
    {
        if (array_key_exists($key, $this->errors)) {
            $infos = $this->errors[$key];
            echo '<div class="py-2 px-5 my-2 rounded border-warning border">';
            foreach ($infos as $info) {
                if ($info) {
                    echo '<p class="text-warning small text-center">' . $info . '</p>';
                }
            }
            echo '</div>';
        }

        return null;

    }

    public function errorToken(string $key): ?string
    {
        if (array_key_exists($key, $this->errorToken)) {
            echo '<div class="py-2 px-5 my-2 rounded border-warning border"><p class="text-warning small text-center">' . $this->errorToken['_token'] . '</p></div>';
        }

        return null;

    }

    public function old(string $key): ?string
    {
        if (array_key_exists($key, $this->data)) {
            return $this->data;
        }

        return null;
    }

    public function csrf()
    {
        if(empty($this->token)) {
            $this->token = md5(uniqid(rand(), true));

            return sprintf('<input type="hidden" name="_token" value="%s" />', $this->token);
        }

        return sprintf('<input type="hidden" name="_token" value="%s" />', $this->token);
    }

    protected function checkCsrf()
    {
        $token = $this->data['_token'];

        if (empty($token) || $token !== $this->token) {
            $this->errorToken['_token'] = 'Dommage, le formulaire a expiré';
            return false;
        }

        return true;
    }

    protected function checkInput(string $key, array $rules): bool
    {
        foreach ($rules as $rule) {
            if ($rule === 'required') {
                $method = sprintf('rule%s', ucfirst($rule));
                $param = null;

                $this->$method($key, $param);
            } else {
                [$rule, $param] = explode(':', $rule);

                // 'min:2' => 'ruleMin'
                $method = sprintf('rule%s', ucfirst($rule));
                // 'first_name', '2'
                $this->$method($key, $param);

            }

        }

        return !array_key_exists($key, $this->errors);


    }

    protected function ruleRequired(string $key, $param = null): bool
    {
        $check = !empty($key);

        if (true === $check) {
            $this->errors[$key][] = 'Ce champs est requis';
        }

        return $check;
    }

    protected function ruleMin(string $key, $param = null): bool
    {
        $check = strlen($key) <= $param;

        if (!$check) {
            $this->errors[$key][] = sprintf('Ce champs doit faire au moins %d caractères', $param);
        }

        return $check;
    }

    protected function ruleMax(string $key, $param = null): bool
    {
        $check = strlen($key) >= $param;

        if (!$check) {
            $this->errors[$key][] = sprintf('Ce champs doit faire au maximum %d caractères', $param);
        }

        return $check;
    }

    protected function ruleEmail(string $key, $param = null): bool
    {
        return false;
    }

    protected function ruleUnique(string $key, $param = null): bool
    {
        return false;
    }
}