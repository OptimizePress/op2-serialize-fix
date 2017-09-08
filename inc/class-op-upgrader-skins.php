<?php

class Op_Upgrader_Skin extends WP_Upgrader_Skin
{
    protected $slug;

    function set_slug($slug)
    {
        $this->slug = $slug;
    }

    function add_strings()
    {
        $this->upgrader->strings['downloading_package']   = __('Downloading package (%s)...', $this->slug);
        $this->upgrader->strings['unpack_package']        = __('Unpacking...', $this->slug);
        $this->upgrader->strings['installing_package']    = __('Installing package...', $this->slug);
        $this->upgrader->strings['remove_old']            = __('Removing old package...', $this->slug);
    }
}