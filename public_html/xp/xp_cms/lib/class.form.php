<?php

class form {

    /**
     *
     * @param string $action
     * @param string $method
     * @param string $id
     * @param string $title
     * @param string $enctype
     * @param string $autocomplete
     * @return string
     */
    public static function form_open($action, $method = 'post', $id = '', $title = '', $enctype = '', $autocomplete = '') {
        //multipart/form-data
        $formhead = '<div class="form_' . $id . '">' . PHP_EOL;
        $formhead .= '<form id="' . $id . '" action="' . $action . '" method="' . $method . '" autocomplete="' . $autocomplete . '"  enctype="' . $enctype . '">' . PHP_EOL;
        $formhead .= '<fieldset>' . PHP_EOL;
        $formhead .= '<legend>' . $title . '</legend>' . PHP_EOL;
        return $formhead;
    }

    /**
     *
     * @return string
     */
    public static function form_close() {
        $formfooter = '</fieldset>' . PHP_EOL;
        $formfooter .= '</form>' . PHP_EOL;
        $formfooter .= '</div>' . PHP_EOL;
        return $formfooter;
    }

    /**
     *
     * @param string $type
     * @param string $name
     * @param string $required
     * @param string $class2 only for password
     * @return string
     */
    public static function form_input($type, $name, $class2 = '', $required = 'required') {
        //$type = text, password, file, email, url, date, number
        switch ($type) {
            case 'text':
                $input = '<div class="formlist formitem">' . PHP_EOL;
                $input .= '<label for="' . $name . '">' . $name . '</label>' . PHP_EOL;
                $input .= '<input type="' . $type . '" name="' . $name . '" class="' . $type . ' ' . $class2 . '" placeholder="' . $name . '" ' . $required . ' >' . PHP_EOL;
                $input .= '</div>' . PHP_EOL;
                return $input;
                break;
            case 'email':
            case 'url':
            case 'date':
            case 'number':
            case 'radio':
            case 'checkbox':
                $input = '<div class="formlist formitem">' . PHP_EOL;
                $input .= '<label for="' . $name . '">' . $name . '</label>' . PHP_EOL;
                $input .= '<input type="' . $type . '" name="' . $name . '" class="' . $type . '" placeholder="' . $name . '" ' . $required . ' >' . PHP_EOL;
                $input .= '</div>' . PHP_EOL;
                return $input;
                break;
            case 'submit':
            case 'reset':
                $input = '<div class="formlist formitem">' . PHP_EOL;
                $input .= '<label for="' . $name . '">&nbsp;</label>' . PHP_EOL;
                $input .= '<input type="' . $type . '" value="' . $name . '" class="' . $type . '">' . PHP_EOL;
                $input .= '</div>' . PHP_EOL;
                return $input;
                break;
            case 'password':
                $input = '<div class="formlist formitem">' . PHP_EOL;
                $input .= '<label for="' . $name . '">' . $name . '</label>' . PHP_EOL;
                $input .= '<input type="' . $type . '" name="' . $name . '" class="' . $type . ' ' . $class2 . '"  ' . $required . '>' . PHP_EOL;
                $input .= '</div>' . PHP_EOL;
                return $input;
                break;
            default:
                $input = '<div class="formlist formitem">' . PHP_EOL;
                $input .= '<label for="' . $name . '">' . $name . '</label>' . PHP_EOL;
                $input .= '<input type="' . $type . '" name="' . $name . '" class="' . $type . '"  ' . $required . '>' . PHP_EOL;
                $input .= '</div>' . PHP_EOL;
                return $input;
                break;
        }
    }

    /**
     *
     * @param string $name
     * @param string $value
     * @param int $rows
     * @param int $cols
     * @return string
     */
    public static function textarea($name, $value = null, $rows = 5, $cols = 20) {
        $textarea = '<div class="formlist formitem">' . PHP_EOL;
        $textarea .= '<label for="' . $name . '">' . $name . '</label>' . PHP_EOL;
        $textarea .= '<textarea class="textarea" name="' . $name . '" rows="' . $rows . '" cols="' . $cols . '">' . $value . '</textarea>';
        $textarea .= '<div>' . PHP_EOL;
        return $textarea;
    }

    /**
     *
     * @param string $name
     * @param array $values
     * @param string $multiple
     * @return string
     */
    public static function form_select($name, array $values, $multiple = '') {

        $select = '<div class="formlist formitem">' . PHP_EOL;
        $select .= '<label for="' . $name . '">' . $name . '</label>' . PHP_EOL;
        $select .= '<select ' . $multiple . '>' . PHP_EOL;
        foreach ($values as $key => $value) {
            $select .= '<option value="' . $key . '">' . $value . '</option>' . PHP_EOL;
        }
        $select .= '</select>' . PHP_EOL;

        $select .= '<div>' . PHP_EOL;
        return $select;
    }

    /**
     *
     * @param string $name
     * @param string $label
     * @param array $values
     * @param string $type
     * @return string
     */
    public static function form_multiple_checkBoxes_radios($name, $label, array $values, $type = 'checkbox') {
        $checkBoxesRadios = '<div class="formlist formitem">' . PHP_EOL;
        $checkBoxesRadios .= '<label for="' . $name . '">' . $label . '</label>' . PHP_EOL;
        foreach ($values as $key => $value) {
            $checkBoxesRadios .= '<div class="multiple"><input class="' . $type . '" type="' . $type . '" value="' . $key . '" name="' . $name . '"/>' . $value . '</div>' . PHP_EOL;
        }
        $checkBoxesRadios .= '</div>' . PHP_EOL;
        return $checkBoxesRadios;
    }

}
