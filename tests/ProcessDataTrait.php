<?php

namespace Scopeli\FlowBundle;

trait ProcessDataTrait
{
    protected array $dataSet1 = [
        'name' => 'John',
        'boolean' => [true, false],
        'integer' => [10, 20, 30],
        'string' => ['php', 'bpmn'],
        'array' => [
            'key1' => ['aaa', 'bbb'],
            'key2' => ['ccc', 'ddd'],
        ],
    ];

    protected array $dataSet2 = [
        'name' => 'Harry',
        'boolean' => [true, false],
        'integer' => [40, 50, 60],
        'string' => ['code', 'flow'],
        'array' => [
            'key1' => ['www', 'xxx'],
            'key2' => ['yyy', 'zzz'],
        ],
    ];
}
