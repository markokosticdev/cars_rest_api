### Implementation Log:

Models:
- Client
- Car
- History

Controllers:
- ClientController
- CarController
- HistoryController

Tests:
- ClientTest
- CarTest

Factories:
- ClientFactory
- CarFactory
- HistoryFactory

Migrations:
- CreateClientsTable
- CreateCarTable
- CreateHistoriesTable

Seeders:
- ClientTableSeeder
- CarTableSeeder
- HistoryTableSeeder

Routes:

admin routes:
- api/v1/clients
- api/v1/clients/add
- api/v1/clients/{client}
- api/v1/clients/{client}/update
- api/v1/clients/{client}/remove
- api/v1/clients/{client}/history
- api/v1/clients/{client}/history/remove
- api/v1/cars/add
- api/v1/cars/{car}/update
- api/v1/cars/{car}/remove

guest routes:
- api/v1/cars
- api/v1/cars/brands/{brand}
- api/v1/cars/{car}
- api/v1/cars/{car}/buy
- api/v1/cars/{car}/trade
- api/v1/cars/trade/evaluate
