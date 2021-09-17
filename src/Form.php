<?php

namespace App;

use App\Table\UserTable;

/**
 * Class Form
 * @package App
 */
class Form
{
    private $data;
    public $surround = 'p';

    /**
     * Form constructor.
     * @param array $data
     */
    public function __construct($data = [])
    {
        $this->data = $data;
    }

    /**
     * Permet de mettre en forme les champs de formulaire
     * Allows you to format form fields
     * @param $html
     * @return string
     */
    private function surround($html): string
    {
        return "<{$this->surround}>$html</{$this->surround}>";
    }

    /**
     * Création de label pour les champs de formulaires
     * Label creation for form fields
     * @param $for
     * @param $content
     * @return string
     */
    public function label($for, $content, $class = null): string
    {
        return '<label for="' . $for . '" class="' . $class . '">' . $content . '</label>';
    }

    /** Création de champs de formulaire de type input
     * Creating input type form fields
     * @param $for
     * @param $class
     * @param $type
     * @param $name
     * @param null $value
     * @return string
     */
    public function input($for, $class, $type, $name, $placeholder = null, $value = null)
    {
        return '<input id="' . $for . '" class="' . $class . '" type="' . $type . '" value="' . $value . '" name="' . $name . '" placeholder="' . $placeholder . '">';
    }

    /**
     * Création d'un champs de formulaire de type textarea
     * Creating a textarea type form field
     * @param $content
     * @param $name
     * @return string
     */
    public function textarea($content, $name, $placeholder = null): string
    {
        return $this->surround('<textarea id="form-content" name="' . $name . '" placeholder="' . $placeholder . '">' . $content . '</textarea>');
    }


    /**
     * Création d'un champs de formulaire de type select -- A FINALISER
     * Creation of a form field of type select - TO FINALIZE
     * @param $table
     * @param $for
     * @param $default
     * @param $method
     * @param null $with
     * @param array $arguments
     * @param array $display
     * @return string
     */
    public function select($table, $for, $default, $method, $column = null, $with = null, $arguments = [], $display = []): string
    {
        $html = '<select name="' . $for . '" class="form-control mb-4" id="' . $for . '">';
        $table = ucfirst($table);
        $table = rtrim($table, 's');
        $table = "App\Table\\" . $table . "Table";

        $table = new $table();

        if ($method === 'enumeration') {
            $options = $table->showColumn($column);
            foreach (explode("','", substr($options['Type'], 6, -2)) as $option) {
                if ($default == $option) {
                    $trad = new App();
                    $optionTranslate = $trad->translate($option);
                    $html .= '<option selected name="' . $option . '" value="' . $option . '">' . $optionTranslate . '</option>';
                } else {
                    $trad = new App();
                    $optionTranslate = $trad->translate($option);
                    $html .= '<option value="' . $option . '" name="' . $option . '" >' . $optionTranslate . '</option>';
                }
            }
            $html .= '</select>';

            return $html;
        }

        if ($method === 'compare') {
            $tableToCompare = ucfirst($with);
            $tableToCompare = rtrim($tableToCompare, 's');
            $tableToCompare = "App\Table\\" . $tableToCompare . "Table";
            $tableToCompare = new $tableToCompare();
            $options = $tableToCompare->findByStatus($arguments['status'], $arguments['orderBy']);
            $first = $display['first'];
            $second = $display['second'];
            foreach ($options as $option) {
                $element = $option->$first . ' ' . $option->$second;
                $value = $option->id;
                if ($default == $element) {
                    $html .= '<option selected name="' . $default . '" value="' . $value . '">' . $default . '</option>';
                } else {

                    $html .= '<option value="' . $value . '" name="' . $element . '" >' . $element . '</option>';
                }
            }
            $html .= '</select>';

            return $html;
        }


    }


    /**
     * Création d'un champs de formulaire de type submit
     * Creating a submit form field
     * @param $content
     * @param $name
     * @param $class
     * @return string
     */
    public function submit($content, $name, $class, $value): string
    {
        return $this->surround('<button class="' . $class . '" type="submit" name="' . $name . '" value="' . $value . '">' . $content . '</button>');
    }
}