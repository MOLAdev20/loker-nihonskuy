<?php

use LLPhant\Chat\OpenAIChat;
use LLPhant\OpenAIConfig;

if (!function_exists('toJapan')) {
  /**
   * Helper buat ngitung diskon berdasarkan harga dan kode kupon
   */
  function toJapan(string $text, ?string $systemMessage = null): string
  {
    $config = new OpenAIConfig();

    $config->apiKey = env("AI_API_KEY");

    $config->url = env("AI_API_URL");


    $chat = new OpenAIChat($config);


    $chat->model = env("AI_MODEL");

    $chat->setSystemMessage($systemMessage ?: "Kamu adalah translator profesional bahasa Indonesia - Jepang. Tugasmu adalah menjadikan 1 paragraf utuh dari poin-poin yang diberikan lalu terjemahkan teks yang masuk langsung ke dalam bahasa Jepang tanpa ada kalimat pengantar, salam, atau penjelasan tambahan dalam bahasa Indonesia. Langsung berikan hasil translasinya.");

    $response = $chat->generateText($text);

    return $response;
  }
}
