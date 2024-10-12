<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\DB;

class UniqueQuestionForLanguage implements ValidationRule
{
    protected $languageId;
    protected $ignoreId;

    public function __construct($languageId, $ignoreId = null)
    {
        $this->languageId = $languageId;
        $this->ignoreId = $ignoreId;
    }

    /**
     * Run the validation rule.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     * @return void
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $query = DB::table('faq_details')
            ->where('question','=', $value)
            ->where('language_id', $this->languageId);

        if ($this->ignoreId) {
            $query->where('id', '!=', $this->ignoreId);
        }

        if ($query->exists()) {
            $fail('The ' . $attribute . ' has already been taken for the selected language.');
        }
    }
}
