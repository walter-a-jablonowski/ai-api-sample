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
$model = $input['model'] ?? 'gpt-3.5-turbo';

if(!$prompt) 
{
  echo json_encode(['error' => 'No prompt provided']);
  exit;
}

try 
{
  $client = new GuzzleHttp\Client();
  
  $response = $client->post('https://api.openai.com/v1/chat/completions', 
  [
    'headers' => [
      'Authorization' => 'Bearer ' . $apiKey,
      'Content-Type' => 'application/json'
    ],
    'json' => [
      'model' => $model,
      'messages' => [
        [
          'role' => 'user',
          'content' => $prompt
        ]
      ],
      'temperature' => 0.7,
      'max_tokens' => 1000
    ]
  ]);
  
  $result = json_decode($response->getBody(), true);
  
  if(isset($result['choices'][0]['message']['content']))
    echo json_encode(['result' => $result['choices'][0]['message']['content']]);
  else
    echo json_encode(['error' => 'Unexpected API response format']);
} 
catch(Exception $e) 
{
  echo json_encode(['error' => $e->getMessage()]);
}
