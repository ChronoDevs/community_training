<?php

namespace App\Models\Traits;

use Illuminate\Support\Facades\DB;

trait Deleter
{
    /**
     * Delete the record.
     *
     * @param  function $before_function
     * @param  function $after_function
     *
     * @return bool
     */
    public function deleter($before_function = null, $after_function = null, $success_function = null, $fail_function = null)
    {
        DB::beginTransaction();
        try {
            if (!empty($before_function)) {
                $before_function();
            }

            $this->delete();

            if (!empty($after_function)) {
                $after_function();
            }

            DB::commit();

            if (!empty($success_function)) {
                $success_function();
            }

            return true;
        } catch (\Exception $e) {
            DB::rollback();
            \Log::error(get_class().':delete(): '.$e->getMessage());

            if (!empty($fail_function)) {
                $fail_function();
            }

            return false;
        }
    }
}
