<?php return function($_MKH)
{
    $url = "<?php echo {$_MKH[0]} ?>?";
    unset($_MKH[0]);
    foreach($_MKH as $value)
    {
        $url = "{$url}<?php echo {$value} ?>&";
    }

    return substr($url,0,-1);
};