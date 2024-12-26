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
  <title>Gemini API Demo</title>
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
  </style>
</head>
<body>
  <h1>Gemini API Demo</h1>
  
  <?php if(!$apiKey || $apiKey === 'your_api_key_here'): ?>
    <div class="error">
      Please set your API key in config.yml to use this demo.
    </div>
  <?php endif; ?>
  
  <form id="promptForm">
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
          body: JSON.stringify({ prompt })
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
