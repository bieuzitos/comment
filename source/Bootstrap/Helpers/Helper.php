<?php

/**
 * @return string
 */
function url(): string
{
    return URL_TEST;
}

/**
 * @param string $param
 * @param array $values
 * 
 * @return string
 */
function jsonResponse(string $param, array $values): string
{
    return json_encode([$param => $values]);
}
