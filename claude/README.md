# Claude API Demo

A simple PHP demo showing how to use the Anthropic Claude API.

**Note: Claude API requires a paid Anthropic account - there is no free tier.**

## Setup

1. Create an Anthropic account at https://console.anthropic.com/
2. Get your API key from the Anthropic Console
3. Enter your API key in `config.yml`

## Usage

1. Start PHP development server:
   ```bash
   php -S localhost:8000
   ```

2. Open http://localhost:8000/claude/ in your browser

## Features

- Simple web interface for Claude API interaction
- Uses Claude 3 Opus model (latest version)
- AJAX-based requests using fetch API
- Error handling and user feedback
- Clean, modern UI
- Configuration via YAML file

## Requirements

- PHP 7.4 or higher
- Composer
- Paid Anthropic API account
