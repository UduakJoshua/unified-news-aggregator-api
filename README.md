# Unified News Aggregator API

## Overview

A Laravel-based backend service that aggregates news articles from multiple external sources (e.g., Guardian API, NewsAPI) and exposes them via a unified API for frontend consumption.

---

## Description

This project implements a news aggregator service that fetches articles from different sources, normalizes them into a consistent format, stores them in a MySQL database, and provides a RESTful API for retrieving articles based on filters such as source, category, or publication date.  


## Key Capabilities

- Aggregates news from at least two external sources

- Stores articles in a local database

- Periodically updates data from live sources

- Provides REST endpoints for searching and filtering articles

## Tech Stack

- Framework: Laravel

- Database: Relational database (MySQL)

- API Style: REST + JSON

## Scope

Backend-only application

## Installation 
1. Clone the Repository
git clone https://github.com/your-username/unified-news-aggregator-api.git
cd unified-news-aggregator-api
2. Install Dependencies
composer install

Make sure PHP, Composer, and MySQL are installed on your system.

3. Set Up Environment Variables

Copy .env.example to .env:

cp .env.example .env

Update the .env file with your database and API credentials:

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=news_aggregator or whatever you name your db
DB_USERNAME=root
DB_PASSWORD=       # your MySQL password, leave blank if none


GUARDIAN_API_KEY=your_guardian_api_key
NEWSAPI_API_KEY=your_newsapi_api_key

4. Create Database

Create a MySQL database matching your .env configuration. Example using CLI:

5. Run Migrations
php artisan migrate

This will create all the necessary tables in the database.
6. Seed the database


## Author

Uduak Joshua Charlie
