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
  
  $response = $client->post('https://api.anthropic.com/v1/messages', 
  [
    'headers' => [
      'x-api-key' => $apiKey,
      'anthropic-version' => '2023-06-01',
      'content-type' => 'application/json'
    ],
    'json' => [
      'model' => 'claude-3-opus-20240229',
      'max_tokens' => 1024,
      'messages' => [
        [
          'role' => 'user',
          'content' => $prompt
        ]
      ]
    ]
  ]);
  
  $result = json_decode($response->getBody(), true);
  
  if(isset($result['content'][0]['text']))
    echo json_encode(['result' => $result['content'][0]['text']]);
  else
    echo json_encode(['error' => 'Unexpected API response format']);
} 
catch(Exception $e) 
{
  echo json_encode(['error' => $e->getMessage()]);
}
