<?php

namespace App\Models\Concerns;

/**
 * Models that have a `lang` column (added by the
 * 2026_05_25_120000_add_language_to_content_tables migration).
 *
 * Provides ->forLocale($locale) and a default-locale scope.
 */
trait Translatable
{
    public function scopeForLocale($query, $locale = null)
    {
        $locale = $locale ?: app()->getLocale();
        return $query->where($this->getTable() . '.lang', $locale);
    }
}
