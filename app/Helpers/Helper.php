<?php
if (!function_exists('css')) {

    /**
     * Get the path to the Keys folder.
     *
     * @param  string  $path
     * @return string
     */
    function css($key = '') {
        $cdnVersion = config('url.CDN_version');
        $get_data = config('static.css');
        $key_name = $get_data[$key];
        return config('url.static_css_url') . '/' . $key_name . '?v=' .$cdnVersion;
    }

}

if (!function_exists('images')) {

    /**
     * Get the path to the Keys folder.
     *
     * @param  string  $path
     * @return string
     */
    function images($key = '') {
        $cdnVersion = config('url.CDN_version');
        $get_data = config('static.images');
        $key_name = $get_data[$key];
       return config('url.static_img_url') . '/' . $key_name . '?v=' .$cdnVersion;
    }

}

if (!function_exists('js')) {

    /**
     * Get the path to the Keys folder.
     *
     * @param  string  $path
     * @return string
     */
    function js($key = '') {
        $cdnVersion = config('url.CDN_version');
        $get_data = config('static.js');
        $key_name = $get_data[$key];
        return config('url.static_js_url') . '/' . $key_name . '?v=' .$cdnVersion;
    }

}

if (!function_exists('theme')) {

    /**
     * Get the path to the Keys folder.
     *
     * @param  string  $path
     * @return string
     */
    function theme($key = '') {
        $cdnVersion = config('url.CDN_version');
        return config('url.static_theme_url') . '/' . $key . '?v=' .$cdnVersion;
    }

}
