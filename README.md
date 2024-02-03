
## Challenge Idea
We have two providers collect data from them two main providers to get products that contain offers  in json files we need to read and make some filter operations on them to get the result

You can check the json files inside jsons folder 

- `DataProviderX` data is stored in [DataProviderX.json]
- `DataProviderY` data is stored in [DataProviderY.json]

`clone the project`

`cd to reafFromFile`

`run cp .env.example .env`

`run composer install`

# #Run test to make sure app work fine
     php artisan test
![img_8.png](img_8.png)

## hit the endpoint with the required filters
`run php artisan serve --port 8001` to avoid any conflict with local port

![img_5.png](img_5.png)

#Using Docker

    docker-compose up -d --build
    docker-compose ps

![img_6.png](img_6.png)
 then make sure user have correct permission 
![img_7.png](img_7.png)

    install composer

    docker-compose exec app php artisan key:generate

![img_1.png](img_1.png)

![img_2.png](img_2.png)

![img_3.png](img_3.png)

![img_4.png](img_4.png)

