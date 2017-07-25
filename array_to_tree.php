<?php
/**
 * Created by PhpStorm.
 * User: maxim
 * Date: 05.07.17
 * Time: 10:47
 */

$array = [
    [
        'id' => 1,
        'name' => '1',
        'parent' => [
            'id' => 2,
            'name' => '2',

            'parent' => null
        ]
    ],
    [
        'id' => 3,
        'name' => '3',
        'parent' => null
    ],
    [
        'id' => 4,
        'name' => '4',
        'parent' => [
            'id' => 1,
            'name' => '1',
            'parent' => [
                'id' => 2,
                'name' => '2',

                'parent' => null
            ]
        ]
    ],
    [
        'id' => 5,
        'name' => '3',
        'parent' => [
            'id' => 3,
            'name' => '3',
            'parent' => null
        ]
    ],

];

function courseTree($elements)
{
    $branch = [];
    $loop = false;
    foreach ($elements as $key => $element) {
        if (key_exists('parent', $element) && $element['parent'] != null) {
            $parent = $element['parent'];

            if (!key_exists('children', $parent)) {
                $parent['children'] = [];
            }

            foreach ($elements as $index => $child) {
                if (key_exists('parent', $child) && $child['parent']['id'] == $parent['id']) {
                    unset($child['parent']);
                    $parent['children'][] = $child;
                    unset($elements[$index]);
                }
            }

            foreach ($branch as $index => $old_branch) {
                if ($parent['id'] == $old_branch['id']) {
                    unset($branch[$index]);
                }
            }

            if ($parent['parent'] != null) {
                $loop = true;
            } else {
                unset($parent['parent']);
            }

            $branch[] = $parent;

        } else {
            $branch[] = $element;
        }
        unset($elements[$key]);
    }
    if ($loop) {
        $branch = courseTree($branch);
    }

    return $branch;
}


$new_array = $array;
$tree = courseTree($new_array);
print_r($tree);
