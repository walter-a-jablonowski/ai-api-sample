<?php
require_once '../../vendor/autoload.php';

use Symfony\Component\Yaml\Yaml;

header('Content-Type: application/json');

$config = Yaml::parseFile(__DIR__ . '/../config.yml');
$apiKey = $config['api_key'] ?? '';

if(!$apiKey || $apiKey === 'your_api_key_here') 
{
  echo json_encode(['error' => 'API key not configured in config.yml']);
  exit;
}

$input = json_decode(file_get_contents('php://input'), true);
$prompt = $input['prompt'] ?? '';

if(!$prompt) 
{
  echo json_encode(['error' => 'No prompt provided']);
  exit;
}

try 
{
  $client = new GuzzleHttp\Client();
  
  $response = $client->post('https://generativelanguage.googleapis.com/v1/models/gemini-pro:generateContent?key=' . $apiKey, 
  [
    'json' => [
      'contents' => [
        [
          'parts' => [
            [
              'text' => $prompt
            ]
          ]
        ]
      ]
    ]
  ]);
  
  $result = json_decode($response->getBody(), true);
  
  if(isset($result['candidates'][0]['content']['parts'][0]['text']))
    echo json_encode(['result' => $result['candidates'][0]['content']['parts'][0]['text']]);
  else
    echo json_encode(['error' => 'Unexpected API response format']);
} 
catch(Exception $e) 
{
  echo json_encode(['error' => $e->getMessage()]);
}
