# My E-Commerce Backend

A simple, secure Node.js API for e-commerce.

## Setup
1. Clone this repo.
2. Run `npm install`.
3. Set up environment variables (see .env.example).
4. Run the database schema in PostgreSQL.
5. Start with `npm start`.
6. Deploy to Render.

## API Endpoints
- POST /register: Register a user.
- POST /login: Login and get JWT.
- GET /products: Fetch products.
- POST /orders: Place an order (requires auth).
