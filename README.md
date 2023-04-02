# challenge-stack

## Getting Started
### Start the backend
1. `cd backend`
2. Create a .env file based on .env.example
3. Run `docker compose build --pull --no-cache`
4. Run `docker compose up -d`
5. Wait few secondes for migrations or run `docker compose exec php bin/console d:m:m`
6. Run `docker compose exec php bin/console d:f:l` to load the fixtures

### Start the frontend
0. Install the latest `lts node`
1. `cd frontend`
2. Run `npm install`
3. Run `npm run dev`
4. Open `http://localhost:8080`

Utilisateur à tester avec est l'utilisateur avec l'id 2:
- mail : mail2@mail.com
- mdp 123456
