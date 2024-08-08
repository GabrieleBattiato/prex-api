# PREX-api Project

## Description

This project provides an API with OAuth 2.0 authentication to interact with the Giphy API.

## Project Deployment

#### Requirements

- Docker
- Docker Compose

### Clone the Repository

```sh
git clone https://github.com/GabrieleBattiato/prex-api.git
cd prex-api
```

### Copy example.env
```sh
cp .env.example .env
```
#### Add your credentials
Open the `.env` file and add:
- Your database password to **DB_PASSWORD**: `DB_PASSWORD=your_db_password`
- Your Giphy api key value to **GIPHY_API_KEY**: `GIPHY_API_KEY=your_giphy_api_key` 

*(To create an API key in Giphy, sign up for a Giphy developer account at [Giphy Developers](https://developers.giphy.com/), create a new application, and follow the prompts to generate your API key)*


### Build and Run Docker Containers
```sh
docker-compose up --build
```


### Run Migrations
```sh
docker exec -it prex-api php artisan migrate
```


### Install Passport
```sh
docker exec -it prex-api php artisan passport:install
```
You will be prompted to **run all pending database migrations** and to **create the "personal access" and "password grant" clients**. Answer `yes` to both prompts.


### Seed the Database
```sh
docker exec -it prex-api php artisan db:seed
```
It will create a Test User with the following values:
- name: *Test User*
- email: *testuser@example.com*
- password: *password*


### Run Tests
```sh
docker exec -it prex-api php artisan test --testsuite=Unit
```

---
- Access the application at: [http://localhost:8080](http://localhost:8080)
- Access the database (phpmyadmin) at: [http://localhost:8081](http://localhost:8081)
---

## Postman Collection
Import postman collection: [postman_collection_prex.json](./postman_collection_prex.json).
The login request in the collection includes the following script in the *Scripts | Post-response* tab:
```javascript
const jsonData = pm.response.json();
if (jsonData.user && jsonData.user.access_token) {
   pm.environment.set("access_token", jsonData.user.access_token);
}
```


## User Interactions

The application store and log all user interactions:

1. **Database**:
   - Stored in the `user_service_interactions` table.

2. **Log File**:
   - Stored in `api_service.log` located in the `storage/logs` directory.


## Diagrams:

- Sequence Diagram: [file](diagrams/sequence_diagram.pdf)
- Use Case Diagram: [file](diagrams/use_case_diagram.pdf)
- Entity-Relationship Diagram: [file](diagrams/ERD.png)
