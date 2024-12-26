<?php
require_once '../vendor/autoload.php';

use Symfony\Component\Yaml\Yaml;

$config = Yaml::parseFile(__DIR__ . '/config.yml');
$apiKey = $config['api_key'] ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>OpenAI API Demo</title>
  <style>
    body 
    {
      font-family: Arial, sans-serif;
      max-width: 800px;
      margin: 20px auto;
      padding: 0 20px;
    }
    
    textarea 
    {
      width: 100%;
      height: 150px;
      margin: 10px 0;
      padding: 10px;
    }
    
    #result 
    {
      white-space: pre-wrap;
      background: #f5f5f5;
      padding: 15px;
      border-radius: 5px;
      margin-top: 20px;
    }
    
    .error 
    {
      color: red;
      padding: 10px;
      background: #fee;
      border-radius: 5px;
    }

    .model-select 
    {
      margin: 10px 0;
    }
  </style>
</head>
<body>
  <h1>OpenAI API Demo</h1>
  
  <?php if(!$apiKey || $apiKey === 'your_api_key_here'): ?>
    <div class="error">
      Please set your API key in config.yml to use this demo.<br>
      Note: OpenAI offers $5 in free credits for new accounts.
    </div>
  <?php endif; ?>
  
  <form id="promptForm">
    <div class="model-select">
      <label for="model">Select Model:</label>
      <select id="model" name="model">
        <option value="gpt-4-turbo-preview">GPT-4 Turbo</option>
        <option value="gpt-4">GPT-4</option>
        <option value="gpt-3.5-turbo">GPT-3.5 Turbo</option>
      </select>
    </div>
    
    <div>
      <label for="prompt">Enter your prompt:</label>
      <textarea id="prompt" name="prompt" required></textarea>
    </div>
    <button type="submit" <?= (!$apiKey || $apiKey === 'your_api_key_here') ? 'disabled' : '' ?>>Submit</button>
  </form>
  
  <div id="result"></div>

  <script>
    document.getElementById('promptForm').addEventListener('submit', async function(e) 
    {
      e.preventDefault()
      
      const prompt = document.getElementById('prompt').value
      const model = document.getElementById('model').value
      const resultDiv = document.getElementById('result')
      
      resultDiv.textContent = 'Loading...'
      
      try 
      {
        const response = await fetch('ajax/submit_prompt.php', 
        {
          method: 'POST',
          headers: 
          {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify({ prompt, model })
        })
        
        const data = await response.json()
        
        if(data.error)
          resultDiv.innerHTML = `<div class="error">${data.error}</div>`
        else
          resultDiv.textContent = data.result
      } 
      catch(error) 
      {
        resultDiv.innerHTML = `<div class="error">Error: ${error.message}</div>`
      }
    })
  </script>
</body>
</html>
