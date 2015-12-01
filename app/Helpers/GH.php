<?php

class GH
{
    public static function link($url, $method, $button_text, $data = [], $classes = "")
    {
        $id  = md5("id_" . time() * rand(1, 1000));
        $out = Form::open(['style' => 'display:inline', 'url' => $url, 'method' => $method]);
        foreach ($data as $key => $value)
            $out .= Form::hidden($key, $value, ['class' => 'form-control']);
        $out .= Form::submit($button_text, ['id' => $id, 'class' => 'btn btn-primary btn-sm ' . $classes, 'data-method' => $method]);
        $out .= Form::close();

        return $out;
    }

    public static function href($url, $method, $button_text, $data = [], $classes = "")
    {
        $id  = md5("id_" . time() * rand(1, 1000));
        $out = Form::open(['style' => 'display:none', 'url' => $url, 'method' => $method]);
        foreach ($data as $key => $value)
            $out .= Form::hidden($key, $value, ['class' => 'form-control']);
        $out .= Form::submit($button_text, ['id' => $id, 'class' => 'btn btn-primary btn-sm ' . $classes, 'data-method' => $method]);
        $out .= Form::close();
        $out .= "<a href=\"javascript:$('#{$id}').click();\">{$button_text}</a>";

        return $out;
    }

    public static function open($url, $method, $data = [], $classes = "")
    {
        $id  = md5("id_" . time() * rand(1, 1000));
        $out = Form::open(['style' => 'display:none', 'url' => $url, 'method' => $method]);
        foreach ($data as $key => $value)
            $out .= Form::hidden($key, $value, ['class' => 'form-control']);
        $out .= Form::submit("...", ['id' => $id, 'class' => 'btn btn-primary btn-sm ' . $classes, 'data-method' => $method]);
        $out .= Form::close();
        $out .= "<a href=\"javascript:$('#{$id}').click();\">";

        return $out;
    }

}