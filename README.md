# Order Payment Service

## General Info  
👋 Hi there! This is a simple order payment service built with PHP and Docker. It provides APIs for creating orders and checking the service health.  

## Technologies  
This project is created with:  
- PHP  
- Docker
- MySQL  

## Setup  
To run this project, make sure you have installed Docker, and ensure these ports are available:  

- `8080` - for the API service  
- `3306` - for MySQL (if applicable)  

### Install and run locally:  

```sh
# Clone the repository
git clone git@github.com:miqo-srapionyan/order-payment-service-php.git

# Navigate into the project directory
cd order-payment-service-php.git

# Start the service
docker-compose up -d --build
```
# API Documentation

## 1️⃣ Create an Order

**Endpoint:** `POST /api/orders`

**Request Body:**

```json
{
    "user_id": 1,
    "items": [{"product_id": 1, "quantity": 1}]
}
```

**Response:**

```json
{
    "order_id": 123,
    "status": "success"
}
```

## 2️⃣ Health Check

**Endpoint:** `GET /api/health`

**Response:**

```json
{
    "status": "ok"
}
```

