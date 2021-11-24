<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class UniqueInGroup implements Rule
{
    private $table;
    private $column;
    private $groupColumn;
    private $groupId;
    private $except;

    /**
     * Create a new rule instance.
     *
     * @param string $table Table to be checked
     * @param string $column Column to be checked
     * @param string $groupColumn Column Group to be checked. like post_id into categories table
     * @param string $groupId Group Id to be checked. like post_id into categories table
     * @param mixed $except Ignored value. The data type must be equal to $column. default null.
     * @return void
     */
    public function __construct($table, $column, $groupColumn, $groupId, $except = null)
    {
        $this->table = $table;
        $this->column = $column;
        $this->groupColumn = $groupColumn;
        $this->groupId = $groupId;
        $this->except = $except;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return DB::table($this->table)->where($this->groupColumn, $this->groupId)
                                  ->when(!empty($this->except), function ($query) {
                                      return $query->where($this->column, '<>', $this->except);
                                  })
                                  ->where($this->column, $value)
                                  ->count() == 0;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute has already been taken.';
    }
}
