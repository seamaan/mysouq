<?php

namespace Illuminate\Foundation\Validation;

use Illuminate\Http\Request;
use Illuminate\Contracts\Validation\Factory;
use Illuminate\Validation\ValidationException;

trait ValidatesRequests
{
    /**
     * Run the validation routine against the given validator.
     *
     * @param  \Illuminate\Contracts\Validation\Validator|array  $validator
     * @param  \Illuminate\Http\Request|null  $request
     * @return array
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function validateWith($validator, Request $request = null)
    {
        $request = $request ?: request();

        if (is_array($validator)) {
            $validator = $this->getValidationFactory()->make($request->all(), $validator);
        }

        return $validator->validate();
    }

    /**
     * Validate the given request with the given rules.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  array  $rules
     * @param  array  $messages
     * @param  array  $customAttributes
     * @return array
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function validate(Request $request, array $rules, array $messages = [], array $customAttributes = []){
        if(count($customAttributes)==0)
        {
            foreach ($rules as $key=>$value)
            {
                $customAttributes[$key]=trans('lang.'.$key);
            }

        }
        if (isset($rules['translate']) && is_array($rules['translate']))
        {
            foreach($rules['translate'] as $k => $v)
            {
                if (str_contains($k, '.'))
                {
                    if (explode('.', $k)[1] == '*')
                    {
                        foreach (\App\Lang::all() as $lang)
                        {
                            $key = explode('.', $k)[0];
                            $rules[$key.$lang->id] = $v;
                            $customAttributes[$key.$lang->id] = trans('lang.'.$key).' ( '.$lang->name.' ) ';
                        }
                    }else
                    {
                        $lang = \App\Lang::where('code',explode('.', $k)[1]);
                        if ($lang->exists())
                        {
                            $lang = $lang->first();
                            $key = explode('.', $k)[0];
                            $rules[$key.$lang->id] = $v;
                            $customAttributes[$key.$lang->id] = trans('lang.'.$key).' ( '.$lang->name.' ) ';
                        }
                    }
                }else
                {
                    foreach (\App\Lang::all() as $lang)
                    {
                        $key = $k;
                        $rules[$key.$lang->id] = $v;
                        $customAttributes[$key.$lang->id] = trans('lang.'.$key).' ( '.$lang->name.' ) ';
                    }
                }

            }
        }
        $rules = array_except($rules, 'translate');
        return $this->getValidationFactory()->make(
            $request->all(), $rules, $messages, $customAttributes
        )->validate();
    }

    /**
     * Validate the given request with the given rules.
     *
     * @param  string  $errorBag
     * @param  \Illuminate\Http\Request  $request
     * @param  array  $rules
     * @param  array  $messages
     * @param  array  $customAttributes
     * @return array
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function validateWithBag($errorBag, Request $request, array $rules,
                                    array $messages = [], array $customAttributes = [])
    {
        try {
            return $this->validate($request, $rules, $messages, $customAttributes);
        } catch (ValidationException $e) {
            $e->errorBag = $errorBag;

            throw $e;
        }
    }

    /**
     * Get a validation factory instance.
     *
     * @return \Illuminate\Contracts\Validation\Factory
     */
    protected function getValidationFactory()
    {
        return app(Factory::class);
    }
}
