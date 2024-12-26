# OpenAI API Demo

A simple PHP demo showing how to use the OpenAI API.

## Free Usage

OpenAI offers $5 in free credits for new accounts that can be used within the first 3 months. After that, you'll need to add a payment method to continue using the API.

Different models have different pricing:
- GPT-3.5 Turbo: $0.0010 / 1K input tokens, $0.0020 / 1K output tokens
- GPT-4 Turbo: $0.01 / 1K input tokens, $0.03 / 1K output tokens
- GPT-4: $0.03 / 1K input tokens, $0.06 / 1K output tokens

## Setup

1. Create an OpenAI account at https://platform.openai.com/
2. Get your API key from https://platform.openai.com/api-keys
3. Enter your API key in `config.yml`

## Usage

1. Start PHP development server:
   ```bash
   php -S localhost:8000
   ```

2. Open http://localhost:8000/openai/ in your browser

## Features

- Simple web interface for OpenAI API interaction
- Support for multiple models:
  - GPT-4 Turbo (fastest, newest)
  - GPT-4 (most capable)
  - GPT-3.5 Turbo (most economical)
- AJAX-based requests using fetch API
- Error handling and user feedback
- Clean, modern UI
- Configuration via YAML file

## Requirements

- PHP 7.4 or higher
- Composer
- OpenAI API account (free credits available for new accounts)
