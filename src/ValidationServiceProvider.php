<?php

namespace Kaiwh\Validation;

use Validator;

class ValidationServiceProvider extends \Illuminate\Support\ServiceProvider
{

    public function boot()
    {
        /**
         * 验证是否为手机号
         *
         * @return Boolean
         */
        Validator::extend('mobile', function ($attribute, $value, $parameters, $validator) {
            return preg_match('/^(?:14\d|17\d|13\d|15\d|18[1234567890])-?\d{5}(\d{3}|\*{3})$/', $value);
        });
        /**
         * 验证是否为账号
         *
         * @return Boolean
         */
        Validator::extend('account', function ($attribute, $value, $parameters, $validator) {
            $data = [
                $attribute => $value,
            ];
            $validator = Validator::make($data, [
                $attribute => 'email',
            ]);
            if ($validator->fails()) {
                $validator = Validator::make($data, [
                    $attribute => 'mobile',
                ]);
                return !$validator->fails();
            } else {
                return true;
            }
        });
        /**
         * 验证字段值是否仅包含字母字符。
         *
         * @return Boolean
         */
        Validator::extend('k_alpha', function ($attribute, $value, $parameters, $validator) {
            return preg_match('/^[a-zA-Z]+$/u', $value);
        });
        /**
         * 验证字段值是否仅包含字母、数字。
         *
         * @return Boolean
         */
        Validator::extend('k_alpha_num', function ($attribute, $value, $parameters, $validator) {
            return preg_match('/^[a-zA-Z0-9]+$/u', $value);
        });
        /**
         * 验证字段值是否仅包含字母、数字、破折号（ - ）以及下划线（ _ ）
         *
         * @return Boolean
         */
        Validator::extend('k_alpha_dash', function ($attribute, $value, $parameters, $validator) {
            return preg_match('/^[a-zA-Z0-9\-\_]+$/u', $value);
        });

        /**
         * 验证字段值是否为金额
         *
         * @return Boolean
         */
        Validator::extend('price', function ($attribute, $value, $parameters, $validator) {
            return preg_match('/(^[1-9]([0-9]+)?(\.[0-9]{1,4})?$)|(^(0){1}$)|(^[0-9]\.[0-9]{1,4}$)/', $value);
        });
    }
}
