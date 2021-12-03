<?php
namespace App\Helpers;

use Illuminate\Support\Str;

class FunctionHelper {

    private static $blacklistFormulaKeyword = "alter and as asc between by count create delete desc distinct drop from group having in insert into is join like not on or order select set table union update values where limit begin trigger proc view index for add constraint key primary foreign collate clustered nonclustered declare exec go if use index holdlock nolock nowait paglock readcommitted readcommittedlock readpast readuncommitted repeatableread rowlock serializable snapshot tablock tablockx updlock with";

    /**
     * Format formula before save
     *
     * @param string $formula String of formula
     * @return string
     **/
    public static function formatFormula($formula)
    {
        return preg_replace(
            '!\s+!',
            ' ',
            str_replace(
                ["\r", "\n", "\t"],
                ' ',
                strip_tags(
                    stripslashes(
                        Str::of($formula)->trim()
                        )
                    )
            )
        );
    }

    /**
     * Get blacklist formula keyword
     *
     * @return array
     **/
    public static function getBlacklistFormulaKeywords()
    {
        return explode(' ', static::$blacklistFormulaKeyword);
    }

    public static function thousandsCurrencyFormat($num) {
        if ($num >= 1000) {
            $x = round($num);
            $x_number_format = number_format($x);
            $x_array = explode(',', $x_number_format);
            $x_parts = array('K', 'M', 'B', 'T');
            $x_count_parts = count($x_array) - 1;
            $x_display = $x;
            $x_display = $x_array[0] . ((int) $x_array[1][0] !== 0 ? '.' . $x_array[1][0] : '');
            $x_display .= $x_parts[$x_count_parts - 1];

            return $x_display;
        }

        return $num;
    }

}
