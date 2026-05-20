<?php

namespace App\Services;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Stichoza\GoogleTranslate\GoogleTranslate;
use Stichoza\GoogleTranslate\Exceptions\RateLimitException;
use Stichoza\GoogleTranslate\Exceptions\TranslationRequestException;

class GoogleTranslatorService
{
  private GoogleTranslate $translator;

  public function __construct()
  {
    $this->translator = new GoogleTranslate('ja');
    $this->translator->setSource('id');
  }

  public function translate(string $text): string
  {
    if (blank($text) || $text === '-') {
      return $text;
    }

    try {
      return $this->translator->translate($text) ?? $text;
    } catch (RateLimitException $e) {
      Log::warning('Google Translate rate limit hit', ['text' => $text]);
      return $text;
    } catch (TranslationRequestException | \Exception $e) {
      Log::error('Google Translate error', ['error' => $e->getMessage()]);
      return $text;
    }
  }

  public function translateCollection(Collection $collection, array $fields): Collection
  {
    if ($collection->isEmpty()) {
      return $collection;
    }

    return $collection->map(function ($item) use ($fields) {
      $cloned = clone $item;

      foreach ($fields as $field) {
        $value = $cloned->{$field} ?? '';

        if (blank($value) || $value === '-') {
          continue;
        }

        $cloned->{$field} = $this->translate((string) $value);

        usleep(300000); // 300ms delay biar aman dari rate limit
      }

      return $cloned;
    });
  }

  public function translateModel(object $model, array $fields): object
  {
    $cloned = clone $model;

    foreach ($fields as $field) {
      $value = $cloned->{$field} ?? '';

      if (blank($value) || $value === '-') {
        continue;
      }

      $cloned->{$field} = $this->translate((string) $value);

      usleep(300000);
    }

    return $cloned;
  }
}
