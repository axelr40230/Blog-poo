<?php


namespace App;


class Form
{
    private $data;
    public $surround = 'p';

    /**
     * Form constructor.
     * @param array $data
     */
    public function __construct($data = array())
    {
        $this->data = $data;
    }

    /**
     * Permet de mettre en forme les champs de formulaire // Allows you to format form fields
     * @param $html
     * @return string
     */
    private function surround($html) : string
    {
        return "<{$this->surround}>$html</{$this->surround}>";
    }

    /**
     * Création de label pour les champs de formulaires // Label creation for form fields
     * @param $for
     * @param $content
     * @return string
     */
    public function label($for, $content, $class = null) : string
    {
        return '<label for="'. $for .'" class="'. $class .'">'. $content .'</label>';
    }

    /** Création de champs de formulaire de type input // Creating input type form fields
     * @param $for
     * @param $class
     * @param $type
     * @param $name
     * @param null $value
     * @return string
     */
    public function input($for, $class, $type, $name, $placeholder = null, $value = null)
    {
        return '<input id="'. $for .'" class="'. $class .'" type="'. $type .'" value="'. $value .'" name="'. $name .'" placeholder="'. $placeholder .'">';
    }

    /**
     * Création d'un champs de formulaire de type textarea // Creating a textarea type form field
     * @param $content
     * @param $name
     * @return string
     */
    public function textarea($content, $name) : string
    {
        return $this->surround('<textarea id="form-content" name="'. $name .'">'. $content .'</textarea>');
    }


    /**
     * Création d'un champs de formulaire de type select -- A FINALISER // Creation of a form field of type select - TO FINALIZE
     * @param $for
     * @return string
     */
    public function select($for) : string
    {
        return $this->surround('
        <div class="form-group">
                        <select class="form-control form-control-solid" id="'. $for .'">
                            <option>1</option>
                            <option>2</option>
                            <option>3</option>
                            <option>4</option>
                            <option>5</option>
                        </select>
                    </div>
        ');
    }

    /**
     * Création d'un champs de formulaire de type submit // Creating a submit form field
     * @param $content
     * @param $name
     * @param $class
     * @return string
     */
    public function submit($content, $name, $class) : string
    {
        return $this->surround('<button class="'. $class .'" type="submit" name="'. $name .'">'. $content .'</button>');
    }
}