<?php

function validate(array $request, array $rules)
{
    $error = [];
    if (is_array($rules) && !empty($rules)) {
        foreach ($rules as $field => $rule) {
            $fieldRule = explode("|", $rule);
            foreach ($fieldRule as $row) {
                $ruleKey = getrulekey($row);
                $rulevalue = getrulevalue($row);
                if ($ruleKey == 'required' && ifvalueexists($request, $field)) {
                    $error[$field]['required'] = removeUnderscore(($field)) . " field is required";
                } else if ($ruleKey == 'email' && ifvalidemail($request, $field)) {
                    $error[$field]['email'] = removeUnderscore(($field)) . " email is invalid";
                } else if ($ruleKey == 'min' && ifvaluemin($request, $field, $rulevalue)) {
                    $error[$field]['min'] = removeUnderscore(($field)) . " field is more than minimum length.";
                } else if ($ruleKey == 'max' && ifvaluemin($request, $field, $rulevalue)) {
                    $error[$field]['max'] = removeUnderscore(($field)) . " field is less than maximum length.";
                }
            }
        }
    }

    return $error;
}

function ifvaluemin($request, $field, $val)
{
    $check = $request[$field];
    return strlen($check) < $val;
}

function ifvaluemax($request, $field, $val)
{
    $check = $request[$field];
    return strlen($check) > $val;
}

function ifvalueexists($request, $field)
{
    return empty($request[$field]);
}

function ifvalidemail($request, $field)
{
    $email = $request[$field];
    if (!empty($email))
        !preg_match(
            "^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$^",
            $email
        )
            ? FALSE : TRUE;
    else
        return TRUE;
}

function removeUnderscore($string)
{
    return str_replace('_', ' ', $string);
}

function getrulevalue($string)
{
    $arr = explode(":", $string);
    return $arr[1] ? $arr[1] : null;
}

function getrulekey($string)
{
    $arr = explode(":", $string);
    return $arr[0] ? $arr[0] : null;
}
