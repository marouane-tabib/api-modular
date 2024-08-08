<?php

namespace App\Http\Requests\Concerns;

trait HasFailedValidationResponseMessages
{
    protected $messagedRules = ['required'];

    private array $validationMessages = [
        // Popular
        'required'             => 'Please provide a value for the :attribute field.',
        'boolean'              => 'The :attribute field must be either true or false.',
        'string'               => 'The :attribute must be a string.',
        'numeric'              => 'The :attribute must be a numeric value.',
        'email'                => 'Please enter a valid email address for the :attribute.',
        'confirmed'            => 'The :attribute confirmation does not match.',
        'date'                 => 'Please enter a valid date for the :attribute.',
        'array'                => 'The :attribute must be an array.',
        'file'                 => 'Please upload a file for the :attribute.',
        'image'                => 'Please upload an image for the :attribute.',
        'in'                   => 'The selected :attribute is invalid.',
        'unique'               => 'The :attribute has already been taken.',
        'min'                  => [
            'numeric' => 'The :attribute must be at least :min.',
            'file'    => 'The :attribute must be at least :min kilobytes.',
            'string'  => 'The :attribute must be at least :min characters.',
            'array'   => 'The :attribute must have at least :min items.',
        ],
        'max'                  => [
            'numeric' => 'The :attribute must not be greater than :max.',
            'file'    => 'The :attribute must not be greater than :max kilobytes.',
            'string'  => 'The :attribute must not be greater than :max characters.',
            'array'   => 'The :attribute must not have more than :max items.',
        ],

        // Less Popular
        'required_if'          => 'Please provide a value for the :attribute when :other is :value.',
        'required_unless'      => 'Please provide a value for the :attribute unless :other is in :values.',
        'required_with'        => 'Please provide a value for the :attribute when :values is present.',
        'required_with_all'    => 'Please provide a value for the :attribute when :values are present.',
        'required_without'     => 'Please provide a value for the :attribute when :values is not present.',
        'required_without_all' => 'Please provide a value for the :attribute when none of :values are present.',
        'accepted'             => 'The :attribute must be accepted.',
        'active_url'           => 'Please enter a valid URL for the :attribute.',
        'alpha'                => 'The :attribute may only contain letters.',
        'alpha_dash'           => 'The :attribute may only contain letters, numbers, and dashes.',
        'alpha_num'            => 'The :attribute may only contain letters and numbers.',
        'before'               => 'The :attribute must be a date before :date.',
        'before_or_equal'      => 'The :attribute must be a date before or equal to :date.',
        'between'              => [
            'numeric' => 'The :attribute must be between :min and :max.',
            'file'    => 'The :attribute must be between :min and :max kilobytes.',
            'string'  => 'The :attribute must be between :min and :max characters.',
            'array'   => 'The :attribute must have between :min and :max items.',
        ],
        'date_equals'          => 'The :attribute must be a date equal to :date.',
        'date_format'          => 'The :attribute does not match the format :format.',
        'different'            => 'The :attribute and :other must be different.',
        'digits'               => 'The :attribute must be :digits digits.',
        'digits_between'       => 'The :attribute must be between :min and :max digits.',
        'distinct'             => 'The :attribute field has a duplicate value.',
        'ends_with'            => 'The :attribute must end with one of the following: :values.',
        'exists'               => 'The selected :attribute is invalid.',
        'gt'                   => [
            'numeric' => 'The :attribute must be greater than :value.',
            'file'    => 'The :attribute must be greater than :value kilobytes.',
            'string'  => 'The :attribute must be greater than :value characters.',
            'array'   => 'The :attribute must have more than :value items.',
        ],
        'gte'                  => [
            'numeric' => 'The :attribute must be greater than or equal :value.',
            'file'    => 'The :attribute must be greater than or equal :value kilobytes.',
            'string'  => 'The :attribute must be greater than or equal :value characters.',
            'array'   => 'The :attribute must have :value items or more.',
        ],
        'ip'                   => 'Please enter a valid IP address for the :attribute.',
        'ipv4'                 => 'Please enter a valid IPv4 address for the :attribute.',
        'ipv6'                 => 'Please enter a valid IPv6 address for the :attribute.',
        'json'                 => 'The :attribute must be a valid JSON string.',
        'lt'                   => [
            'numeric' => 'The :attribute must be less than :value.',
            'file'    => 'The :attribute must be less than :value kilobytes.',
            'string'  => 'The :attribute must be less than :value characters.',
            'array'   => 'The :attribute must have less than :value items.',
        ],
        'lte'                  => [
            'numeric' => 'The :attribute must be less than or equal :value.',
            'file'    => 'The :attribute must be less than or equal :value kilobytes.',
            'string'  => 'The :attribute must be less than or equal :value characters.',
            'array'   => 'The :attribute must not have more than :value items.',
        ],
        'mimes'                => 'The :attribute must be a file of type: :values.',
        'mimetypes'            => 'The :attribute must be a file of type: :values.',
        'not_in'               => 'The selected :attribute is invalid.',
        'not_regex'            => 'The :attribute format is invalid.',
        'present'              => 'The :attribute field must be present.',
        'regex'                => 'The :attribute format is invalid.',
        'same'                 => 'The :attribute and :other must match.',
        'size'                 => [
            'numeric' => 'The :attribute must be :size.',
            'file'    => 'The :attribute must be :size kilobytes.',
            'string'  => 'The :attribute must be :size characters.',
            'array'   => 'The :attribute must contain :size items.',
        ],
        'starts_with'          => 'The :attribute must start with one of the following: :values.',
        'timezone'             => 'The :attribute must be a valid time zone.',
        'uploaded'             => 'The :attribute failed to upload.',
        'url'                  => 'Please enter a valid URL for the :attribute.',
        'uuid'                 => 'The :attribute must be a valid UUID.',
    ];

    /**
    * @throws InvalidArgumentException
    */
    public function messages()
    {
        if (isset($this->messagedRules) || !empty($this->messagedRules)) {
            if (!empty($this->messagedRules) && is_array($this->messagedRules)) {
                return $this->arrayMultiPluck($this->validationMessages, $this->messagedRules);
            } else {
                throw new \InvalidArgumentException("You must specify the messagedRules attribute");
            }
        }
    }

    public function arrayMultiPluck(array $array, array $keys): array
    {
        return array_intersect_key($array, array_flip($keys));
    }
}