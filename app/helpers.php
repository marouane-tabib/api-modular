<?php

function arrayMultiPluck(array $array, array $keys): array
{
    return array_intersect_key($array, array_flip($keys));
}
