<?php

namespace App\Models\Traits;

use App\Models\ClientSupport;
use Illuminate\Support\Facades\DB;
use App\Models\Category;

trait Register
{
    /**
     * 登録
     *
     * @param  mixed $attributes
     * @param  function $before_function
     * @param  function $after_function
     *
     * @return mixed(object/bool)
     */
    public static function register(array $attributes, $before_function = null, $after_function = null, $success_function = null, $fail_function = null)
    {
        try {
            $rtn = [];
            if (!empty($before_function)) {
                $attributes = $before_function($attributes);
            }

            $rtn = self::create($attributes);

            if (!empty($after_function)) {
                $rtn = $after_function($rtn);
            }

            DB::commit();

            if (!empty($success_function)) {
                $rtn = $success_function($rtn);
            }

            return $rtn;
        } catch (\Exception $e) {
            DB::rollback();
            \Log::error(get_class().':register(): '.$e->getMessage());

            if (!empty($fail_function)) {
                $fail_function($rtn);
            }

            return false;
        }
    }
}
