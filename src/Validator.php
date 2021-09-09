<?php

namespace App;

/**
 * Class Validator
 * @package App
 */
class Validator
{
    protected $data = [];
    protected $rules = [];
    protected $errors = [];
    protected $errorToken = [];
    protected $oldToken;
    protected $method = [];
    protected $newToken;

    /**
     * Validator constructor.
     * Récupère le token sauvegardé dans la session
     */
    public function __construct()
    {
        $this->oldToken = App::session()->get('_token');
        $this->generateToken();
    }

    /**
     * @param array $data
     * @param array $rules
     */
    public function validate(array $data = [], array $rules = [])
    {
        $this->data = $data;
        $this->rules = $rules;

        foreach ($this->rules as $key => $rules) {
            $this->checkCsrf();
            $this->checkInput($key, $rules);
        }
    }

    /**
     * @return bool
     */
    public function fails(): bool
    {
        if (count($this->errors) > 0) {
            return false;
        }
        return true;
    }

    /**
     * @param string $key
     * @return string|null
     */
    public function error(string $key): ?string
    {
        if (array_key_exists($key, $this->errors)) {
            $infos = $this->errors[$key];
            $html = '<div class="py-2 px-5 my-2 rounded border-warning border">';
            foreach ($infos as $info) {
                if ($info) {
                    $html .= '<p class="text-warning small text-center">' . $info . '</p>';
                }
            }
            $html .= '</div>';

            return $html;
        }

        return null;

    }

    /**
     * @param string $key
     * @return string|null
     */
    public function errorToken(string $key): ?string
    {
        if (array_key_exists($key, $this->errorToken)) {
            return '<div class="py-2 px-5 my-2 rounded border-warning border"><p class="text-warning small text-center">' . $this->errorToken['_token'] . '</p></div>';
        }

        return null;

    }

    /**
     * @param string $key
     * @return string|null
     */
    public function old(string $key): ?string
    {
        if (array_key_exists($key, $this->data)) {
            return $this->data;
        }

        return null;
    }

    /**
     * @return string
     */
    public function csrf()
    {

        return sprintf('<input type="hidden" name="_token" value="%s" />', $this->newToken);
    }

    /**
     *
     */
    protected function generateToken()
    {
        $this->newToken = md5(uniqid(rand(), true));
        App::session()->set('_token', $this->newToken);
    }

    protected function checkCsrf()
    {
        $token = $this->data['_token'];

        if (empty($token) || $token !== $this->oldToken) {
            $this->errorToken['_token'] = 'Dommage, le formulaire a expiré';
            return false;
        }

        return true;
    }

    /**
     * @param string $key
     * @param array $rules
     * @return bool
     */
    protected function checkInput(string $key, array $rules): bool
    {
        foreach ($rules as $rule) {
            if ($rule === 'required') {
                $method = sprintf('rule%s', ucfirst($rule));
                $param = null;

                $this->$method($key, $param);
            } elseif ($rule === 'email') {
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

    /**
     * @param string $key
     * @param null $param
     * @return bool
     */
    protected function ruleRequired(string $key, $param = null): bool
    {
        $check = !empty($key);

        if ($check === false) {
            $this->errors[$key][] = 'Ce champs est requis';
        }

        return $check;
    }

    /**
     * @param string $key
     * @param null $param
     * @return bool
     */
    protected function ruleMin(string $key, $param = null): bool
    {
        $check = strlen($this->data[$key]) >= $param;

        if (!$check) {
            $this->errors[$key][] = sprintf('Ce champs doit faire au moins %d caractères', $param);
        }

        return $check;
    }

    /**
     * @param string $key
     * @param null $param
     * @return bool
     */
    protected function ruleMax(string $key, $param = null): bool
    {
        $check = strlen($this->data[$key]) <= $param;

        if (!$check) {
            $this->errors[$key][] = sprintf('Ce champs doit faire au maximum %d caractères', $param);
        }

        return $check;
    }

    /**
     * @param string $key
     * @param null $param
     * @return bool
     */
    protected function ruleEmail(string $key, $param = null): bool
    {
        if(!filter_var($this->data[$key], FILTER_VALIDATE_EMAIL)) {
            $this->errors[$key][] = sprintf('Ce champs doit être un email', $param);
        }

        return true;
    }

    /**
     * @param string $key
     * @param null $param
     * @return bool
     */
    protected function ruleUnique(string $key, $param = null): bool
    {
        $type = rtrim($param, 's');
        $table = ucfirst($type);
        $table = "App\Table\\" . $table . "Table";
        $table = new $table;
        $function = $key . 'Check';
        $check = $table->$function($this->data[$key]);

        if ($check) {
            $this->errors[$key][] = sprintf('Cet email est déjà pris', $param);
        }

        return true;
    }

    protected function ruleExist(string $key, $param = null): bool
    {
        $type = rtrim($param, 's');
        $table = ucfirst($type);
        $table = "App\Table\\" . $table . "Table";
        $table = new $table;
        $function = $key . 'Check';
        $check = $table->$function($this->data[$key]);

        if (!$check) {

            $this->errors[$key][] = sprintf('Nous n\'avons pas trouvé de compte rattaché à cet email', $param);
        }


        return true;
    }

}